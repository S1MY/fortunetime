

<h1 class="caninetName">Админ панель</h1>
<div class="cabMenuFlex displayFlex alignItemsCenter spaceBetween">
    <a href="{{ route('adminPage') }}" class="cabMenuLink{{ Route::currentRouteName() == 'adminPage' ? ' active' : '' }}">Все пользователи</a>
    <a href="{{ route('paied') }}" class="cabMenuLink{{ Route::currentRouteName() == 'paied' ? ' active' : '' }}">Все пополнения</a>
    <a href="{{ route('adminfaq') }}" class="cabMenuLink{{ Route::currentRouteName() == 'adminfaq' ? ' active' : '' }}">Добавить FAQ</a>
    <a href="{{ route('adminreviews') }}" class="cabMenuLink{{ Route::currentRouteName() == 'adminreviews' ? ' active' : '' }}">Менеджер отзывов</a>
    <a href="{{ route('adminnews') }}" class="cabMenuLink{{ Route::currentRouteName() == 'settings' ? ' active' : '' }}">Новости</a>
    <a href="{{ route('adminoutput') }}" class="cabMenuLink{{ Route::currentRouteName() == 'settings' ? ' active' : '' }}">Новости</a>
    <a href="{{ route('logout') }}" class="cabMenuLink">Выйти</a>
</div>
