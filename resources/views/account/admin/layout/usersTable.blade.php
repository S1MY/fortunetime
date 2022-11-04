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
            <td class="tacenter cursorPointer">{{ $user->login }}</td>
            <td>{{ $user->email }}</td>
            <td class="tacenter cursorPointer">{{ $user->sponsor_login }}</td>
            <td class="tacenter">{{ $user->sponsor_counter }}</td>
            <td class="tacenter">{{ $user->balance }}</td>
            <td class="tacenter">{{ $user->created_at }}</td>
        </tr>
    @endforeach

</table>

{{ $users->links('vendor.pagination.default') }}
