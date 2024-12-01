@extends('themes::themenangcuc.layout')

@php
    $years = Cache::remember('all_years', \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60), function () {
        return \Ophim\Core\Models\Movie::select('publish_year')
            ->distinct()
            ->pluck('publish_year')
            ->sortDesc();
    });
@endphp



@section('content')
    <div id="p0" data-pjax-container="" data-pjax-push-state data-pjax-timeout="1000">
        <div class="myui-panel myui-panel-list mt-2 clearfix">

            @include('themes::themenangcuc.inc.catalog_filter')

            <div class="myui-panel-box clearfix">
                    <div class="myui-panel_bd clearfix">
                        <div class="myui-panel_hd">
                                <div class="myui-panel__head clearfix">
                                    <span class="icon icon-cinema"></span>
                                    <h1 class="title">{{ $section_name }}</h1>
                                </div>
                        </div>
                        <br />
                        <div id="myui-vodlist clearfix" class="film-list" role="list">
                            @foreach ($data as $key => $movie)
                                @php
                                    $xClass = 'item';
                                    if ($key === 0 || $key % 4 === 0) {
                                        $xClass .= ' no-margin-left';
                                    }
                                @endphp

                                @include('themes::themenangcuc.inc.catalog_sections_movies_item')
                            @endforeach
                            
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    {{ $data->appends(request()->all())->links('themes::themenangcuc.inc.pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection

