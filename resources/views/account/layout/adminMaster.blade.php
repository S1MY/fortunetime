

<h1 class="caninetName">Админ панель</h1>
<div class="cabMenuFlex displayFlex alignItemsCenter spaceBetween adminPanelCabinet">
    <a href="{{ route('adminPage') }}" class="cabMenuLink{{ Route::currentRouteName() == 'adminPage' ? ' active' : '' }}">Все пользователи</a>
    <a href="{{ route('paied') }}" class="cabMenuLink{{ Route::currentRouteName() == 'paied' ? ' active' : '' }}">Все пополнения</a>
    <a href="{{ route('adminoutput') }}" class="cabMenuLink{{ Route::currentRouteName() == 'adminoutput' ? ' active' : '' }}">Заявки на вывод</a>
    <a href="{{ route('adminfaq') }}" class="cabMenuLink{{ Route::currentRouteName() == 'adminfaq' ? ' active' : '' }}">Добавить FAQ</a>
    <a href="{{ route('adminreviews') }}" class="cabMenuLink{{ Route::currentRouteName() == 'adminreviews' ? ' active' : '' }}">Менеджер отзывов</a>
    <a href="{{ route('adminnews') }}" class="cabMenuLink{{ Route::currentRouteName() == 'settings' ? ' active' : '' }}">Новости</a>
</div>

<style>
    .cabMenuLink {
        width: calc((100% - 20px) / 6);
    }
    @media (max-width: 1100px){
        .adminPanelCabinet{
            display: none;
        }
    }
</style>
