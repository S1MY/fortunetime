@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                <h1 class="caninetName">Админ панель</h1>
                <div class="cabMenuFlex displayFlex alignItemsCenter spaceBetween">
                    <a href="{{ route('account') }}" class="cabMenuLink{{ Route::currentRouteName() == 'account' ? ' active' : '' }}">Все пользователи</a>
                    <a href="{{ route('start') }}" class="cabMenuLink{{ Route::currentRouteName() == 'start' ? ' active' : '' }}">Все пополнения</a>
                    {{-- <a href="{{ route('automation') }}" class="cabMenuLink{{ $disabledMunuLink }}{{ Route::currentRouteName() == 'automation' ? ' active' : '' }}">Автоматизация</a> --}}
                    <a href="{{ route('reviews') }}" class="cabMenuLink">Менеджер отзывов</a>
                    {{-- <a href="{{ route('settings') }}" class="cabMenuLink{{ Route::currentRouteName() == 'settings' ? ' active' : '' }}">Настройки</a> --}}
                    <a href="{{ route('logout') }}" class="cabMenuLink">Выйти</a>
                </div>
            </div>
        </div>
    </section>
@endsection
