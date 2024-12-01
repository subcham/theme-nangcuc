@extends('themes::themenangcuc.layout')

@section('content')
    <style>
        .video-footer {
            margin-top: 5px;
        }

        .btn-active {
            color: #fff !important;
            background: #d9534f !important;
            border-color: #d9534f !important;
        }

        .btn-sv {
            margin-right: 5px;
        }

        .btn-sv:last-child {
            margin-right: 0;
        }

        #player-loaded>div {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }
    </style>

    <div class="video-p-first mt-3">
        <div class="cc-warning text-center">
            - Cách tìm kiếm phim trên Google: <b>"Tên phim + {{ request()->getHost() }}"</b><br>
        </div>
        @if ($currentMovie->showtimes && $currentMovie->showtimes != '')
            <div class="myui-player__notice">Lịch chiếu: {!! strip_tags($currentMovie->showtimes) !!}</div>
        @endif
    </div>

    <div id="main-player">
        {{-- <div class="loader"></div> --}}
        <div id="player-loaded"></div>
    </div>
    <div class="video-footer">
        <script>
            function detectMobile() {
                const toMatch = [
                    /Android/i,
                    /webOS/i,
                    /iPhone/i,
                    /iPad/i,
                    /iPod/i,
                    /BlackBerry/i,
                    /Windows Phone/i
                ];

                return toMatch.some((toMatchItem) => {
                    return navigator.userAgent.match(toMatchItem);
                });
            }
        </script>
    </div>

    <div id="ploption" class="text-center">
        @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
            <a onclick="chooseStreamingServer(this)" data-type="{{ $server->type }}" data-id="{{ $server->id }}"
                data-link="{{ $server->link }}" class="streaming-server current btn-sv btn btn-primary">
                Server #{{ $loop->iteration }}
            </a>
        @endforeach
    </div>

    <div itemscope itemtype="http://schema.org/Movie">
        <div class="rating-block text-center">
            @include('themes::themenangcuc.inc.rating2')
        </div>
        <center style="padding:10px"><input type="text" id="searchBox" placeholder="Tìm tập phim..."
                style="background: 0 0; border: 1px solid #fff; height: 32px; width: 200px; padding: 5px; color:#fff; border-radius: 3px !important">
        </center>
        <div class="row">
            <div class="col-md-wide-7 col-xs-1 padding-0">
                <div id="servers-container" class="myui-panel myui-panel-bg clearfix ">
                    <div class="myui-panel-box clearfix">
                        <div class="myui-panel_hd">
                            <div class="myui-panel__head active bottom-line clearfix">
                                <div class="title">Tập phim</div>
                                <ul class="nav nav-tabs active">
                                    @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                                        <li class="{{ $loop->index == 0 ? 'active' : '' }}"><a
                                                href="#tab_{{ $loop->index }}">{{ $server }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content myui-panel_bd">
                            @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                                <div class="tab-pane fade in clearfix {{ $loop->index == 0 ? 'active' : '' }}"
                                    id="tab_{{ $loop->index }}">
                                    <ul class="myui-content__list sort-list clearfix"
                                        style="max-height: 300px; overflow: auto;">
                                        @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                                            <li class="col-lg-8 col-md-7 col-sm-6 col-xs-4">
                                                <a href="{{ $item->sortByDesc('type')->first()->getUrl() }}"
                                                    class="btn btn-default @if ($item->contains($episode)) active @endif"
                                                    title="{{ $name }}">{{ $name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div style="border: 1px solid #b8b612; font-size: 15px" class="myui-panel myui-panel-bg clearfix">
                    - Hãy thử chuyển sang server khác (nếu có) nếu bạn gặp tình trạng giật/lag khi xem phim.<br>
                    - Bạn nên sử dụng Trình duyệt Chrome để xem phim tối ưu nhất!<br>
                    - Tham gia nhóm <a href="https://t.me/+z49SfoKsTZ00OGRl" target="_blank" rel="nofollow noopener">
                        <span style="color:#e62117"><strong>Telegram</strong></span></a> của chúng mình để được hỗ trợ kịp
                    thời nha.
                </div>
                <div class="myui-panel myui-panel-bg clearfix">
                    <div class="myui-panel-box clearfix">
                        <div class="myui-panel_hd">
                            <div class="myui-panel__head clearfix height-auto">
                                <h1 class="title" itemprop="name">{{ $currentMovie->name }} - Tập {{ $episode->name }}
                                </h1>
                                <h2 class="title2">{{ $currentMovie->origin_name }}</h2>
                            </div>
                        </div>
                        <div class="myui-panel_bd">
                            <div class="col-pd text-collapse content">
                                <div class="sketch content" itemprop="description">
                                    <h3>{{ $currentMovie->name }}, {{ $currentMovie->origin_name }}</h3>
                                    {!! $currentMovie->content !!}
                                </div>
                                <div id="tags"><label>Keywords:</label>
                                    <div class="tag-list">
                                        @foreach ($currentMovie->tags as $tag)
                                            <h3>
                                                <strong>
                                                    <a href="{{ $tag->getUrl() }}" title="{{ $tag->name }}"
                                                        rel='tag'>
                                                        {{ $tag->name }}
                                                    </a>
                                                </strong>
                                            </h3>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="myui-panel myui-panel-bg clearfix">
                    <style>
                        @media only screen and (max-width: 767px) {
                            .fb-comments {
                                width: 100% !important
                            }

                            .fb-comments iframe[style] {
                                width: 100% !important
                            }

                            .fb-like-box {
                                width: 100% !important
                            }

                            .fb-like-box iframe[style] {
                                width: 100% !important
                            }

                            .fb-comments span {
                                width: 100% !important
                            }

                            .fb-comments iframe span[style] {
                                width: 100% !important
                            }

                            .fb-like-box span {
                                width: 100% !important
                            }

                            .fb-like-box iframe span[style] {
                                width: 100% !important
                            }
                        }

                        .fb-comments,
                        .fb-comments span {
                            background-color: #eee
                        }

                        .fb-comments {
                            margin-bottom: 20px
                        }
                    </style>
                    <div style="color:white;font-weight:bold;padding:5px; border: 1px solid #dd163b">
                        Quý khán giả tuyệt đối không được nhấn vào các đường link lạ trong phần bình luận để tránh trường hợp bị hack tài khoản Facebook, lộ lọt thông tin cá nhân!
                    </div>
                    <div data-order-by="reverse_time" id="commit-99011102" class="fb-comments"
                        data-href="{{ $currentMovie->getUrl() }}" data-width="" data-numposts="10"></div>
                    <script>
                        document.getElementById("commit-99011102").dataset.width = $("#commit-99011102").parent().width();
                    </script>
                </div>
            </div>

            <div class="col-md-wide-3 col-xs-1 myui-sidebar hidden-sm hidden-xs">
                @include('themes::themenangcuc.sidebar')
            </div>
        </div>
    </div>

    {{-- Load player --}}
    <script>
        $('.btn-sv').on('click', function() {
            var __this = $(this);

            __this.parent().find('a.btn').removeClass('btn-active');
            __this.addClass('btn-active');
        });

        function removeAds(__this) {
            __this.closest('.player_ads').hide();
        }
    </script>
@endsection

@push('scripts')
    <script src="/themes/nangcuc/static/player/skin/juicycodes.js"></script>
    <link href="/themes/nangcuc/static/player/skin/juicycodes.css" rel="stylesheet" type="text/css">

    {{--    <script src="/themes/nangcuc/static/player/js/p2p-media-loader-core.min.js"></script> --}}
    {{--    <script src="/themes/nangcuc/static/player/js/p2p-media-loader-hlsjs.min.js"></script> --}}

    <script src="/themes/nangcuc/static/player/jwplayer.js"></script>
    {{--    <script src="/js/jwplayer-8.9.3.js"></script> --}}
    {{--    <script src="/js/hls.min.js"></script> --}}
    {{--    <script src="/js/jwplayer.hlsjs.min.js"></script> --}}


    <script>
        var episode_id = {{ $episode->id }};
        const wrapper = document.getElementById('player-loaded');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname.replace(`-${episode_id}`, `-${id}`);

            history.pushState({
                path: newUrl
            }, "", newUrl);
            episode_id = id;

            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('bg-red-600');
            })
            el.classList.add('bg-red-600')

            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/nangcuc/static/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe sandbox = "allow-same-origin allow-scripts" width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                    fake_player.on('adSkipped', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe sandbox = "allow-same-origin allow-scripts" width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                    fake_player.on('adComplete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe sandbox = "allow-same-origin allow-scripts" width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe sandbox = "allow-same-origin allow-scripts" width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                        allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    file: link,
                    image: "{{ $currentMovie->getPosterUrl() }}",
                    autostart: true,
                    controls: true,
                    primary: "html5",
                    playbackRateControls: true,
                    playbackRates: [0.5, 0.75, 1, 1.5, 2],
                    // sharing: {
                    //     sites: [
                    //         "reddit",
                    //         "facebook",
                    //         "twitter",
                    //         "googleplus",
                    //         "email",
                    //         "linkedin",
                    //     ],
                    // },
                    volume: 100,
                    mute: false,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua",
                        admessage: "Quảng cáo còn xx giây."
                    },
                    tracks: [{
                        "file": "/sub.vtt",
                        "kind": "captions",
                        label: "VN",
                        default: "true"
                    }],
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    // if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                    //     var engine = new p2pml.hlsjs.Engine(engine_config);
                    //     player.setup(objSetup);
                    //     jwplayer_hls_provider.attach();
                    //     p2pml.hlsjs.initJwPlayer(player, {
                    //         liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                    //         maxBufferLength: 300,
                    //         loader: engine.createLoaderClass(),
                    //     });
                    // } else {
                    player.setup(objSetup);
                    // }
                } else {
                    player.setup(objSetup);
                }

                player.addButton(
                    '<svg xmlns="http://www.w3.org/2000/svg" class="jw-svg-icon jw-svg-icon-rewind2" viewBox="0 0 240 240" focusable="false"><path d="m 25.993957,57.778 v 125.3 c 0.03604,2.63589 2.164107,4.76396 4.8,4.8 h 62.7 v -19.3 h -48.2 v -96.4 H 160.99396 v 19.3 c 0,5.3 3.6,7.2 8,4.3 l 41.8,-27.9 c 2.93574,-1.480087 4.13843,-5.04363 2.7,-8 -0.57502,-1.174985 -1.52502,-2.124979 -2.7,-2.7 l -41.8,-27.9 c -4.4,-2.9 -8,-1 -8,4.3 v 19.3 H 30.893957 c -2.689569,0.03972 -4.860275,2.210431 -4.9,4.9 z m 163.422413,73.04577 c -3.72072,-6.30626 -10.38421,-10.29683 -17.7,-10.6 -7.31579,0.30317 -13.97928,4.29374 -17.7,10.6 -8.60009,14.23525 -8.60009,32.06475 0,46.3 3.72072,6.30626 10.38421,10.29683 17.7,10.6 7.31579,-0.30317 13.97928,-4.29374 17.7,-10.6 8.60009,-14.23525 8.60009,-32.06475 0,-46.3 z m -17.7,47.2 c -7.8,0 -14.4,-11 -14.4,-24.1 0,-13.1 6.6,-24.1 14.4,-24.1 7.8,0 14.4,11 14.4,24.1 0,13.1 -6.5,24.1 -14.4,24.1 z m -47.77056,9.72863 v -51 l -4.8,4.8 -6.8,-6.8 13,-12.99999 c 3.02543,-3.03598 8.21053,-0.88605 8.2,3.4 v 62.69999 z"></path></svg>',
                    "Forward 10 Seconds", () => player.seek(player.getPosition() + 10), "Forward 10 Seconds");
                player.addButton(
                    '<svg xmlns="http://www.w3.org/2000/svg" class="jw-svg-icon jw-svg-icon-rewind" viewBox="0 0 240 240" focusable="false"><path d="M113.2,131.078a21.589,21.589,0,0,0-17.7-10.6,21.589,21.589,0,0,0-17.7,10.6,44.769,44.769,0,0,0,0,46.3,21.589,21.589,0,0,0,17.7,10.6,21.589,21.589,0,0,0,17.7-10.6,44.769,44.769,0,0,0,0-46.3Zm-17.7,47.2c-7.8,0-14.4-11-14.4-24.1s6.6-24.1,14.4-24.1,14.4,11,14.4,24.1S103.4,178.278,95.5,178.278Zm-43.4,9.7v-51l-4.8,4.8-6.8-6.8,13-13a4.8,4.8,0,0,1,8.2,3.4v62.7l-9.6-.1Zm162-130.2v125.3a4.867,4.867,0,0,1-4.8,4.8H146.6v-19.3h48.2v-96.4H79.1v19.3c0,5.3-3.6,7.2-8,4.3l-41.8-27.9a6.013,6.013,0,0,1-2.7-8,5.887,5.887,0,0,1,2.7-2.7l41.8-27.9c4.4-2.9,8-1,8,4.3v19.3H209.2A4.974,4.974,0,0,1,214.1,57.778Z"></path></svg>',
                    "Rewind 10 Seconds", () => player.seek(player.getPosition() - 10), "Rewind 10 Seconds");

                const resumeData = 'OPCMS-PlayerPosition-' + id;

                player.on('ready', function() {
                    if (typeof(Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function() {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function() {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function() {
                    if (typeof(Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const episode = '{{ $episode->id }}';
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>
    <script>
        let searchBtn = document.getElementById("searchBox");



        let lists = document.getElementsByClassName("sort-list");
        // 		let list = document.getElementsByClassName("episodes")[0].getElementsByTagName("li");

        searchBtn.addEventListener("click", searchList);
        searchBox.addEventListener("keyup", searchList);


        function searchList() {

            let searchTerm = searchBox.value.toLowerCase();

            for (let j = 0; j < lists.length; j++) {

                list = lists[j].getElementsByTagName("li");


                for (let i = 0; i < list.length; i++) {
                    let item = list[i].getElementsByTagName('a')[0].innerHTML.toLowerCase();

                    if (item.indexOf(searchTerm) > -1) {
                        list[i].style.display = "";

                    } else {
                        list[i].style.display = "none";
                    }
                }
            }

        }
    </script>
@endpush
