<div class="myui-panel myui-panel-bg clearfix">
    <div class="myui-panel-box clearfix">
        <div class="myui-panel_hd">
            <div class="myui-panel__head active clearfix">
                <h3 class="title">{{ $top['label'] }}</h3>
                <span class="icon icon-cinema"></span>
            </div>
        </div>
        <div class="myui-panel_bd">
            <ul class="myui-vodlist__media active col-pd clearfix">
                @foreach ($top['data'] as $key => $movie)
                    <li>
                        <div class="thumb">
                            <a class="myui-vodlist__thumb img-xs-70"
                                style="background: url({{$movie->getThumbUrl()}});"
                                href="{{$movie->getUrl()}}"
                                title="{{$movie->name}} | {{$movie->origin_name}} ({{$movie->publish_year}})"></a>
                        </div>
                        <div class="detail detail-side">
                            <h4 class="title">
                                <a class="icon-btn" href="{{$movie->getUrl()}}">{{$movie->name}}</a>
                            </h4>
                            <p class="font-12"><span class="text-muted">{{$movie->episode_current}} {{$movie->language}}</span></p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
