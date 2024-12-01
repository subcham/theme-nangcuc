@once
    @push('header')
        <style>
            .absolute {
                position: absolute;
            }

            .list-film li:nth-child(even) {
                background: rgb(24 24 24);
            }
            .most-view .list-film .item .number-rank {
                background: #c58560 !important;
            }
            .most-view .list-film .item a:hover, .list-film .film-item-ver .name a:hover {
                color: #da966e;
            }
            .most-view .tabs .tab:hover {
                background: #333;
            }
            .title-box .tophot,.right-content .block .caption {
                color: #da966e;
            }

            .main-content .right-content {
                width: 300px;
                float: right;
            }
            .right-content .widget {
                margin: 0 0 10px 0;
            }

            .right-content .block {
                /*padding: 20px 10px;*/
                /*margin: 0 0 20px 0;*/
                /*width: 300px;*/
                overflow: hidden;
            }

            .right-content .block .caption {
                margin: 0 0 10px 0;
                padding: 0 0 5px 0;
                color: #ff9601;
                border-bottom: 2px dashed #5d5d5d;
                font-size: 25px;
                font-family: 'roboto';
                font-weight: 300;
                text-transform: uppercase;
            }

            .right-content .block .caption .fa {
                margin: 0 5px 0 0;
            }

            .right-content .block .fb-page {
                max-height: 220px;
                overflow: hidden;
            }
            .right-content .most-view .fa-play {
                font-size: 9px;
                color: #0072bd;
                margin: 0 2px 0 0;
                position: absolute;
                left: 0;
                top: 10px;
            }

            .right-content .fb-like-box {
                background: #ffffff;
                border: 1px dashed #a0cce9;
            }
            .most-view .list-film .item {
                position: relative;
                padding: 5px 0 5px 35px;
            }

            .most-view .list-film .item:first-child {
                border-top: none;
            }

            .most-view .list-film .item .number-rank {
                background: #ff9601;
                color: #fff;
                font-weight: bold;
                left: 5px;
                top: 17px;
                width: 23px;
                height: 23px;
                line-height: 23px;
                text-align: center;
                font-size: 13px;
                border-radius: 15px;
            }

            .most-view .list-film .item a {
                color: #FFFFFF;
                font-size: 13px;
                font-weight: bold;
            }

            .most-view .list-film .item a:hover {
                color: #ff9601;
            }

            .most-view .list-film .item .count_view {
                color: #BABABA;
                font-size: 12px;
                margin: 3px 0 0 0;
                font-style: italic;
            }

            .most-view .tabs .tab {
                width: 33.33%;
                padding: 8px 0;
                float: left;
                border-radius: 0;
                text-align: center;
                font-weight: bold;
                cursor: pointer;
            }

            .most-view .tabs .tab:hover {
                color: #ffffff;
            }

            .most-view .tabs .tab.active {
                background-color: #5d5d5d;
            }

            .right-content .most-view .fa-play {
                font-size: 9px;
                color: #0072bd;
                margin: 0 2px 0 0;
                position: absolute;
                left: 0;
                top: 10px;
            }

            .most-view li {
                list-style: none;
            }

            .tabs .tab {
                display: inline-block;
                padding: 3px 15px;
                border-radius: 20px;
                color: #fff;
                margin: 0 0 10px;
                font-size: 13px;
            }
        </style>
    @endpush
@endonce

<div class="myui-panel clearfix right-content">
    <div class="myui-panel_hd">
        <div class="myui-panel__head active clearfix">
            <h3 class="title">{{ $top['label'] }}</h3><span class="icon icon-cinema"></span>
        </div>
    </div>

    <div class="myui-panel_bd">
        <div class="most-view block">
        <div class="tabs">
            <div data-id="d" class="tab active">Ngày</div>
            <div data-id="w" class="tab">Tuần</div>
            <div data-id="m" class="tab">Tháng</div>
        </div>
        <div class="clearfix"></div>

        <ul class="list-film">
            @foreach ($top['data']['d'] as $key => $movie)
                <li class="item d">
                    <span class="number-rank absolute">{{ $loop->iteration }}</span>
                    <span>
                        <a href="{{$movie->getUrl()}}" title="{{$movie->name}}">
                            {{$movie->name}}
                        </a>
                    </span>
                    <div class="count_view">{{$movie->view_day}} Views</div>
                </li>
            @endforeach

            @foreach ($top['data']['w'] as $key => $movie)
                <li class="item w" style="display: none">
                    <span class="number-rank absolute">{{ $loop->iteration }}</span>
                    <span>
                        <a href="{{$movie->getUrl()}}" title="{{$movie->name}}">
                            {{$movie->name}}
                        </a>
                    </span>
                    <div class="count_view">{{$movie->view_week}} Views</div>
                </li>
            @endforeach

            @foreach ($top['data']['m'] as $key => $movie)
                <li class="item m" style="display: none">
                    <span class="number-rank absolute">{{ $loop->iteration }}</span>
                    <span>
                        <a href="{{$movie->getUrl()}}" title="{{$movie->name}}">
                            {{$movie->name}}
                        </a>
                    </span>
                    <div class="count_view">{{$movie->view_month}} Views</div>
                </li>
            @endforeach
        </ul>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(".most-view .tab").click(function () {
                var type = $(this).attr('data-id');
                // $(".most-view .list-film").html("");
                $(".most-view .tab").removeClass('active');
                $(this).addClass('active');
                // var data = { 'action': 'top_viewed', 'type': type }

                $(".most-view .list-film .d").hide();
                $(".most-view .list-film .w").hide();
                $(".most-view .list-film .m").hide();

                $(".most-view .list-film .item." + type).show();
            })
        })
    </script>
</div>