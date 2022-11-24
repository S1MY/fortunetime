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
            @if ($user->sponsor_login == null AND $user->activated == 0)
                <td class="tacenter cursorPointer changeRef"><a href="#" data-id="{{ $user->user_id }}">Поменять реферала</a></td>
            @else
                <td class="tacenter cursorPointer">{{ $user->sponsor_login }}</td>
            @endif
            <td class="tacenter">{{ $user->sponsor_counter }}</td>
            <td class="tacenter">{{ $user->balance }}</td>
            <td class="tacenter">{{ $user->created_at }}</td>
        </tr>
    @endforeach

</table>
