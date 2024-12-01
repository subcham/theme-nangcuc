@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<div class="myui-topbg clearfix"></div>
<header class="myui-header__top clearfix" id="header-top">
    <div class="container">
        <div class="myui_custom_header">
            <div class="myui-header__logo">
                <a class="logo" href="/">{!! $brand !!}</a>
            </div>
            <div class="myui-header__search">
                <div class="container">
                    <div class="row">
                        <ul class="">
                            <li class="search-box dropdown-hover" href="javascript:;">
                                <form id="search" name="search" method="get" action="/">
                                    <input
                                        type="text"
                                        id="keyword"
                                        name="search"
                                        class="search_wd form-control"
                                        value="{{ request('search') }}"
                                        placeholder="V.d: tên phim, tên diễn viên..."
                                        autocomplete="off"
                                        />

                                    <button class="submit search_submit icon-btn" id="searchbutton" type="submit" name="submit">
                                        <svg><use xlink:href="/themes/nangcuc/static/sprite.svg#icon-search"></use></svg>
                                    </button>
                                </form>
                                <div style="display: block;" class="search-dropdown-hot dropdown-box bottom fadeInDown search-suggest"></div>
                                <div class="search-dropdown-hot dropdown-box bottom fadeInDown"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- <div id="box-user-menu" class="actions-user right">
                <div><a onclick="alert('Chức năng này đang cập nhật');return false;"><svg
                            class="icon icon--white icon-sign-in">
                            <use xlink:href="/themes/nangcuc/static/users.svg#sign-in"></use>
                        </svg>
                        Đăng nhập</a></div>
                <div><a onclick="alert('Chức năng này đang cập nhật');return false;"><svg
                            class="icon icon--white icon-users">
                            <use xlink:href="/themes/nangcuc/static/users.svg#users"></use>
                        </svg>
                        Đăng ký</a></div>
                <div><a onclick="alert('Chức năng này đang cập nhật');return false;"><svg
                            class="icon icon--white icon-bookmark">
                            <use xlink:href="/themes/nangcuc/static/users.svg#bookmark"></use>
                        </svg>
                        Bookmark</a></div>
            </div> --}}
        </div>
        <div class="mobile-control">
            <div class="menu control icon-btn" data-type="toggle" data-target=".nav"><svg><use xlink:href="/themes/nangcuc/static/sprite.svg#icon-menu"></use></svg></div>
            <div class="search control icon-btn" data-type="toggle" data-target="#search">
                <svg><use xlink:href="/themes/nangcuc/static/sprite.svg#icon-search2"></use></svg>
            </div>
        </div>
    </div>
    <div class="nav__content">
        <div class="container">
            <div class="menu-block">
                <ul class="myui-header__menu nav-menu">
                    @foreach ($menu as $item)
                        @if (count($item['children']))
                            <li>
                                <a href="javascript:void(0)" title="{{ $item['name'] }}">
                                    {{ $item['name'] }}
                                    <svg width="10" height="10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="#abb7c4" d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z" /></svg>
                                </a>
                                <ul class="sub">
                                    @foreach ($item['children'] as $children)
                                        <li><a href="{{ $children['link'] }}" title="{{ $children['name'] }}">{{ $children['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="{{ $item['link'] === '/' ? 'active' : 'hidden-sm' }}"><a {!! strpos($item['link'], 'bang-xep-hang') !== false ? 'class="color-orange"' : '' !!} title="{{ $item['name'] }}" href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</header>

