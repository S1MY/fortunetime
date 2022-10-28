@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.adminMaster')
                <table>
                    <tr>
                        <th>Имя</td>
                        <th>Фамилия</td>
                        <th>Логин</td>
                        <th>Email</td>
                        <th>Пригласитель</td>
                        <th>Количество приглашённых</td>
                        <th>Баланс</td>
                        <th>Активирован</td>
                    </th>

                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->user_name }}</td>
                            <td>{{ $user->user_surname }}</td>
                            <td>{{ $user->login }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->sponsor }}</td>
                            <td>{{ $user->sponsor_counter }}</td>
                            <td>{{ $user->balance }}</td>
                            <td>{{ $user->activated }}</td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </section>
@endsection
