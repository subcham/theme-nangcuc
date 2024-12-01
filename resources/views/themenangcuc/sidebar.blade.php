@php
    $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $template] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 4, 'top_thumb']);
                try {
                     if ($relation == 'trending') {
                        $dataMovies = [
                            'd' => \Ophim\Core\Models\Movie::where('is_copyright', 0)
                                ->orderBy('view_day', 'desc')
                                ->limit($limit)
                                ->get(),
                            'w' => \Ophim\Core\Models\Movie::where('is_copyright', 0)
                                ->orderBy('view_week', 'desc')
                                ->limit($limit)
                                ->get(),
                            'm' => \Ophim\Core\Models\Movie::where('is_copyright', 0)
                                ->orderBy('view_month', 'desc')
                                ->limit($limit)
                                ->get()
                        ];
                    } else {
                        $dataMovies = \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy($sortKey, $alg)
                            ->limit($limit)
                            ->get();
                    }

                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => $dataMovies
                    ];
                } catch (\Exception $e) {
                    # code
                }
            }
        }

        return $data;
    });
@endphp

@foreach ($tops as $top)
    @include('themes::themenangcuc.inc.sidebar.' . $top['template'])
@endforeach