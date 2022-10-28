@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.adminMaster')

                @foreach ($users as $user)
                <table>
                    <th>
                        <td>Имя</td>
                        <td>Фамилия</td>
                        <td>Логин</td>
                        <td>Email</td>
                        <td>Пригласитель</td>
                        <td>Количество приглашённых</td>
                        <td>Баланс</td>
                        <td>Активирован</td>
                    </th>
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
                </table>
                @endforeach
            </div>
        </div>
    </section>
@endsection
