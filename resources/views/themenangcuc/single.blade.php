@extends('themes::themenangcuc.layout')

@php
    $watchUrl = '#';
    if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '') {
        $watchUrl = $currentMovie->episodes
            ->sortBy([['server', 'asc']])
            ->groupBy('server')
            ->first()
            ->sortByDesc('name', SORT_NATURAL)
            ->groupBy('name')
            ->last()
            ->sortByDesc('type')
            ->first()
            ->getUrl();
    }
    if ($currentMovie->status == 'trailer') {
        $watchUrl = 'javascript:alert("Phim đang được cập nhật!")';
    }
@endphp

@section('content')
    <div class="detail-bl myui-panel col-pd clearfix" itemscope="" itemtype="http://schema.org/Movie">
        <div class="myui-content__thumb">
            <a class="myui-vodlist__thumb img-md-220 img-sm-220 img-xs-130 picture" href="{{ $watchUrl }}"
                title="{{ $currentMovie->name }} | {{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})">
                <img itemprop="image"
                    alt="{{ $currentMovie->name }} | {{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})"
                    src="{{ $currentMovie->getThumbUrl() }}">
                <span class="play hidden-xs"></span>
                <span class="btn btn-default btn-block btn-watch">XEM PHIM</span>
            </a>
            <div class="clearfix"></div>
        </div>
        <div class="myui-content__detail">
            <h1 class="title text-fff" itemprop="name">{{ $currentMovie->name }} </h1>
            <h2 class="title2"> {{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})</h2>
            <div class="myui-media-info">
                <div class="info-block">
                    <div>Thể loại:
                        <span>
                            {!! $currentMovie->categories->map(function ($category) {
                                    return '<a href="' . $category->getUrl() . '" tite="' . $category->name . '">' . $category->name . '</a>';
                                })->implode(', ') !!}
                        </span>
                    </div>
                    <div>Trạng thái:
                        <span style="background: #d9534f; color: #fff; padding: 3px; border-radius: 3px; font-weight: 500;"
                            itemprop="duration">{{ $currentMovie->episode_current }} {{ $currentMovie->language }}</span>
                    </div>
                    <div>Đạo diễn:
                        <span itemprop="director">
                            {!! count($currentMovie->directors)
                                ? $currentMovie->directors->map(function ($director) {
                                        return '<a href="' .
                                            $director->getUrl() .
                                            '" tite="Đạo diễn ' .
                                            $director->name .
                                            '"><span itemprop="director">' .
                                            $director->name .
                                            '</span></a>';
                                    })->implode(', ')
                                : 'Đoán xem' !!}
                        </span>
                    </div>
                    <div>Diễn viên:
                        <span itemprop="actor">
                            {!! count($currentMovie->actors)
                                ? $currentMovie->actors->map(function ($actor) {
                                        return '<a href="' .
                                            $actor->getUrl() .
                                            '" tite="Diễn viên ' .
                                            $actor->name .
                                            '"><span itemprop="actor">' .
                                            $actor->name .
                                            '</span></a>';
                                    })->implode(', ')
                                : 'Không biết' !!}
                        </span>
                    </div>
                </div>
                @if ($currentMovie->showtimes && $currentMovie->showtimes != '')
                    <div class="myui-player__notice">Lịch chiếu: {!! strip_tags($currentMovie->showtimes) !!}</div>
                @endif
                <div class="rating-block">
                    @include('themes::themenangcuc.inc.rating2')
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="myui-movie-detail">
            <h3 class="title">Nội dung chi tiết</h3>
            <div class="text-collapse content">
                <div class="sketch content" itemprop="description">
                    <p>{{ $currentMovie->name }} - {{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})
                    </p>
                    <p>{!! $currentMovie->content !!}</p>
                </div>
                <div id="tags"><label>Keywords:</label>
                    <div class="tag-list">
                        @foreach ($currentMovie->tags as $tag)
                            <h3>
                                <strong>
                                    <a href="{{ $tag->getUrl() }}" title="{{ $tag->name }}" rel='tag'>
                                        {{ $tag->name }}
                                    </a>
                                </strong>
                            </h3>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <meta itemprop="name"
            content="{{ $currentMovie->name }} - {{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})">
        <meta itemprop="thumbnailUrl" content="{{ $currentMovie->getThumbUrl() }}">
        <meta itemprop="image" content="{{ $currentMovie->getThumbUrl() }}">
        <meta itemprop="uploadDate" content="{{ $currentMovie->updated_at }}">
        <meta itemprop="url" content="{{ $currentMovie->getUrl() }}">
        <meta itemprop="dateCreated" content="{{ $currentMovie->created_at }}">
    </div>
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
                                                class="btn btn-default"
                                                title="{{ $name }}">{{ $name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="myui-panel myui-panel-bg clearfix">
                <div class="myui-panel-box clearfix">
                    <div class="myui-panel__head active bottom-line clearfix">
                        <h3 class="title">Có thể bạn sẽ thích</h3>
                    </div>
                    <ul id="type" class="myui-vodlist__bd clearfix">
                        @foreach ($movie_related as $movie)
                            <li class="col-lg-5 col-md-6 col-sm-4 col-xs-3">
                                <div class="myui-vodlist__box">
                                    <a class="myui-vodlist__thumb"
                                        href="{{ $movie->getUrl() }}"
                                        title="{{ $movie->name }} | {{ $movie->origin_name }} ({{ $movie->publish_year }})"
                                        style="background: url({{ $movie->getThumbUrl() }});">
                                        <span class="play hidden-xs"></span>
                                        <span class="pic-tag pic-tag-top">{{ $movie->episode_current }} {{ $movie->language }}</span>
                                    </a>
                                    <div class="myui-vodlist__detail">
                                        <h4 class="title text-overflow">
                                            <a href="/phim-nu-hoang-nuoc-mat/12102.html" title="{{ $movie->name }} | {{ $movie->origin_name }} (2024)">{{ $movie->name }} </a>
                                        </h4>
                                        <p class="text text-overflow text-muted hidden-xs">
                                            {{ $movie->origin_name }} (2024)
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-wide-3 col-xs-1 myui-sidebar hidden-sm hidden-xs">
            @include('themes::thememotchill.sidebar')
        </div>
    </div>
@endsection

@push('scripts')
    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
