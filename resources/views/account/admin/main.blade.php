@extends('../master')

@section('title', 'Список пользователей')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.adminMaster')

                <h3 class="cabMatrixName" style="margin-top: 20px">Настройка вывода</h3>

                <form id="formSorting" action="{{ route('adminSorting') }}">
                    <input type="hidden" name="activated" id="activated" value="0">
                    <input type="hidden" name="sponsor_login" id="sponsor_login" value="0">
                    <input type="hidden" name="all" id="all" value="0">
                </form>

                <div class="cabMenuFlex displayFlex alignItemsCenter cabAdminMenu">
                    <p class="adminBtn cursorPointer" data-sorting-name="activated">Активированные</p>
                    <p class="adminBtn cursorPointer" data-sorting-name="sponsor_login">Поменять реферала</p>
                    <p class="adminBtn cursorPointer" data-sorting-name="all">Показать всех</p>
                </div>
                <div class="tableWrapper">
                    <h3 class="cabMatrixName" style="margin-top: 20px">{{ $title }}</h3>
                    <table class="adminTable">
                        <tr>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Логин</th>
                            <th>Email</th>
                            <th>Пригласитель</th>
                            <th>Количество приглашённых</th>
                            <th>Баланс</th>
                            <th>Дата регистрации</th>
                        </tr>

                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->user_name }}</td>
                                <td>{{ $user->user_surname }}</td>
                                <td class="tacenter cursorPointer"><a href="{{ route('showMatrix', $user->login) }}">{{ $user->login }}</a></td>
                                <td>{{ $user->email }}</td>
                                @if ($user->sponsor_login == null)
                                    <td class="tacenter cursorPointer changeRef">Поменять реферала</td>
                                @else
                                    <td class="tacenter cursorPointer">{{ $user->sponsor_login }}</td>
                                @endif
                                <td class="tacenter">{{ $user->sponsor_counter }}</td>
                                <td class="tacenter">{{ $user->balance }}</td>
                                <td class="tacenter">{{ $user->created_at }}</td>
                            </tr>
                        @endforeach

                    </table>

                    {{ $users->links('vendor.pagination.default') }}
                </div>
            </div>
        </div>
    </section>
@endsection
