<li class="col-lg-6 col-md-6 col-sm-4 col-xs-3">
    <div class="myui-vodlist__box">
        <a data-pjax="0"
            class="myui-vodlist__thumb"
            href="{{$movie->getUrl()}}"
            title="{{$movie->name}}"
            style="background: url({{$movie->getThumbUrl()}});"
        >
            <span class="play hidden-xs"></span>
            <span class="pic-tag pic-tag-top" style="background-color: #00000066;">
                {{$movie->episode_current}} {{$movie->language}}
            </span>
        </a>
          <div class="myui-vodlist__detail">
            <h4 class="title text-overflow">
                <a
                    href="{{$movie->getUrl()}}"
                    title="{{$movie->name}}"
                >
                    {{$movie->name}}
                </a>
            </h4>
            <p class="text text-overflow text-muted hidden-xs">
                {{$movie->origin_name}}
            </p>
          </div>
    </div>
</li>