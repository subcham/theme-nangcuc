@extends('themes::themenangcuc.layout_core')

@php
    $menu = \Ophim\Core\Models\Menu::getTree();
    $logo = setting('site_logo', '');
    preg_match('@src="([^"]+)"@', $logo, $match);

    // will return /images/image.jpg
    $logo = array_pop($match);
@endphp

@push('header')
    {{-- @if (!(new \Jenssegers\Agent\Agent())->isDesktop())
        <link rel="stylesheet" type="text/css" href="/themes/nangcuc/css/ipad.css?v=1.0.5" />
    @endif --}}

    <link href="{{ url('/') }}" rel="alternate" hreflang="vi">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"
        integrity="sha512-AFwxAkWdvxRd9qhYYp1qbeRZj6/iTNmJ2GFwcxsMOzwwTaRwz2a/2TX225Ebcj3whXte1WGQb38cXE5j7ZQw3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link href="/themes/nangcuc/static/css/main.css?v=5" rel="stylesheet" media="all">

    <script>
        function detectMob() {
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

    <style>
        #star i {
            color: orange
        }

        .flickity-prev-next-button {
            width: 40px;
            height: 50px;
        }

        .flickity-prev-next-button svg {
            vertical-align: middle !important;
        }

        @media all and (min-width: 813px) {

            .m-nav,
            .m-nav-over {
                display: none !important;
            }
        }

        @media screen and (max-width: 800px) {
            .myui-header__logo .logo {
                height: 50px !important;
                width: 120px !important;
                background-position: center center !important;
            }
        }

        @if ($logo)
            .myui-header__logo .logo {
                background: url({{ $logo }}) no-repeat;
                font-size: 1.5em;
                color: #fff !important;
                font-weight: 700;
                background-size: contain;
                display: block;
                width: 229px;
                height: 60px;
                text-indent: -9999px;
            }
        @endif
    </style>
@endpush

@section('body')
    @include('themes::themenangcuc.inc.header')

    <div class="container">
        <div id="top_ads"></div>

        @if (get_theme_option('ads_header'))
            {!! get_theme_option('ads_header') !!}
        @endif

        <div class="row">
            {{-- @yield('slider_recommended')
            <div class="clear"></div> --}}

            @yield('breadcrumb')
            @yield('content')
        </div>
        @if (get_theme_option('ads_preload'))
            {!! get_theme_option('ads_preload') !!}
        @endif
    </div>
@endsection

@section('footer')
    @if (get_theme_option('ads_catfish'))
        <div id="catfish" style="width: 100%;position:fixed;bottom:0;left:0;z-index:222" class="mp-adz">
            <div style="margin:0 auto;text-align: center;overflow: visible;" id="container-ads">
                <div id="hide_catfish"><a
                        style="font-size:12px; font-weight:bold;background: #ff8a00; padding: 2px; color: #000;display: inline-block;padding: 3px 6px;color: #FFF;background-color: rgba(0,0,0,0.7);border: .1px solid #FFF;"
                        onclick="jQuery('#catfish').fadeOut();">Đóng quảng cáo</a></div>
                <div id="catfish_content" style="z-index:999999;">
                    {!! get_theme_option('ads_catfish') !!}
                </div>
            </div>
        </div>
    @endif

    {!! get_theme_option('footer') !!}

    <script src="/themes/nangcuc/efc0d744/yii.js"></script>
    <script src="/themes/nangcuc/static/js/flickity.smart.min.js"></script>
    <script src="/themes/nangcuc/static/js/main.js?v=4"></script>
    {{-- <script src="/themes/nangcuc/js/ads_xx.js?v=7"></script> --}}

    <div id="footer_fixed_ads"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <div id="fb-root"></div>

    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '{{ setting('social_facebook_app_id') }}',
                xfbml: true,
                version: 'v5.0'
            });
            FB.AppEvents.logPageView();
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/vi_VN/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script>
        $('body').on('click', '.nav-tabs li a', function() {
            var tabactive = $(this).attr('href');
            $(this).closest('.nav-tabs').find('li').removeClass('active');
            $(this).parent().addClass('active');
            $('body').find('.myui-panel_bd .tab-pane').removeClass('active');
            $('body').find(tabactive).addClass('active');

            return false;
        });
    </script><!--script src="https://api.flygame.io/sdk/widget/chill_tv.1856.js" async></script-->

    {!! setting('site_scripts_google_analytics') !!}
    <script>
        jQuery(document).ready(function() {
            let timeoutID = null;
            $("input[name=search]").keyup(function(e) {
                clearTimeout(timeoutID);
                var search = e.target.value;
                if (search.length <= 2) {
                    $(".search-suggest").hide();
                    return false;
                }
                timeoutID = setTimeout(() => searching(search), 0)
            });

            function searching(search) {
                $.ajax({
                    type: "get",
                    url: "/search/" + search,
                    dataType: "json",
                    success: function(response) {
                        let results = "";
                        $(".search-suggest").show();
                        results +=
                            '<ul style="z-index: 100; display: block;" class="autocomplete-list">';
                        results += '<li class="">Kết quả tìm kiếm cho từ khóa: <span>' + search +
                            '</span></li>';
                        for (let i = 0; i < response.data.length; i++) {
                            const element = response.data[i];
                            let img = `<img src="${element['thumb_url']}" alt="${element['name']}">`;
                            let name = `<p>${element['name']}</p>`;
                            results +=
                                '<div class="list-movie-ajax"><div class="movie-item"><a href="' +
                                element["url"] + '" title="' + element["name"] +
                                ' class="ajax-thumb""><img class="search-img" src="' + element[
                                    "thumb_url"] + '" alt="' + element["name"] +
                                '"><div class="info"><div class="movie-title-1">' + element["name"] +
                                '</div><div class="movie-title-2">' + element["origin_name"] + ' (' +
                                element["publish_year"] + ')</div><div class="movie-title-chap">' +
                                element["episode_current"] + ' ' + element["language"] +
                                '</div></div></a></div></div>';;
                        }
                        results +=
                            '<li class="ss-bottom" style="padding: 0;border-bottom: none;display: block;width: 100%;height: 40px;line-height: 40px; background: #f44336; color: #fff; font-weight: 700;text-align: center;"><a href="/?search=' +
                            search + '">Nhấn enter để tìm kiếm</a></li>';
                        $(".search-suggest").html(results);
                    }
                });
            }
        });
    </script>
@endsection
