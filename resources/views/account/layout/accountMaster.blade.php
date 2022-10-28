<h1 class="caninetName">@yield('title')</h1>
@php
    $disabledMunuLink = '';
    // if( Auth::user()->UserInfo->activated == 0 ){
    //     $disabledMunuLink = ' disabledCabMunuLink';
    // }
@endphp

<div class="cabMenuFlex displayFlex alignItemsCenter spaceBetween">
    @if (Auth::user()->is_admin == 1)
        <a href="{{ route('account') }}" class="cabMenuLink{{ Route::currentRouteName() == 'account' ? ' active' : '' }}">Админ панель</a>
    @endif
    <a href="{{ route('account') }}" class="cabMenuLink{{ Route::currentRouteName() == 'account' ? ' active' : '' }}">Главная</a>
    <a href="{{ route('start') }}" class="cabMenuLink{{ $disabledMunuLink }}{{ Route::currentRouteName() == 'start' ? ' active' : '' }}">Быстрый старт</a>
    <a href="{{ route('automation') }}" class="cabMenuLink{{ $disabledMunuLink }}{{ Route::currentRouteName() == 'automation' ? ' active' : '' }}">Автоматизация</a>
    <a href="{{ route('reviews') }}" class="cabMenuLink">Отзывы</a>
    <a href="{{ route('settings') }}" class="cabMenuLink{{ Route::currentRouteName() == 'settings' ? ' active' : '' }}">Настройки</a>
    <a href="{{ route('logout') }}" class="cabMenuLink">Выйти</a>
</div>
