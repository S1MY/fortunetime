

<h1 class="caninetName">Админ панель</h1>
<div class="cabMenuFlex displayFlex alignItemsCenter spaceBetween">
    <a href="{{ route('adminPage') }}" class="cabMenuLink{{ Route::currentRouteName() == 'adminPage' ? ' active' : '' }}">Все пользователи</a>
    <a href="{{ route('paied') }}" class="cabMenuLink{{ Route::currentRouteName() == 'start' ? ' active' : '' }}">Все пополнения</a>
    <a href="{{ route('automation') }}" class="cabMenuLink{{ Route::currentRouteName() == 'automation' ? ' active' : '' }}">Добавить FAQ</a>
    <a href="{{ route('reviews') }}" class="cabMenuLink">Менеджер отзывов</a>
    <a href="{{ route('settings') }}" class="cabMenuLink{{ Route::currentRouteName() == 'settings' ? ' active' : '' }}">Новости</a>
    <a href="{{ route('logout') }}" class="cabMenuLink">Выйти</a>
</div>
