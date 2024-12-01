@if ($recommendations)
    <div class="myui-top-movies">
        <h2 class="myui-block-title mr-sm-10 color-orange">{{ $recommendations['label'] }}</h2>
        <div class="flickity clearfix">

            @foreach ($recommendations['data'] as $movie)
                <div class="col-lg-6 col-md-6 col-sm-4 col-xs-3">
                    <div class="myui-vodlist__box">
                        <a href="{{ $movie->getUrl() }}" class="myui-vodlist__thumb" title="{{ $movie->name }}"
                            style="background: url(
                            @if ($movie->thumb_url) {{ $movie->getThumbUrl() }}
                            @else
                                /demo.jpg
                            @endif
                            );">
                            <span class="play hidden-xs"></span>
                            <span class="pic-tag pic-tag-top">{{ $movie->episode_current }}
                                {{ $movie->language }}</span>
                        </a>
                        <div class="myui-vodlist__detail">
                            <h4 class="title text-overflow">{{ $movie->name }}</h4>
                            <p class="text text-overflow hidden-xs">
                                {{ $movie->origin_name }} ({{ $movie->publish_year }})
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
