@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.adminMaster')

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
                    {{-- {{ dd($user) }} --}}
                        <tr>
                            <td>{{ $user->user_name }}</td>
                            <td>{{ $user->user_surname }}</td>
                            <td class="tacenter">{{ $user->login }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="tacenter">{{ $user->sponsor_login }}</td>
                            <td class="tacenter">{{ $user->sponsor_counter }}</td>
                            <td>{{ $user->balance }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </section>
@endsection
