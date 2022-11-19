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

                    {{ $users->links('vendor.pagination.default') }}
                </div>
            </div>
        </div>
    </section>

    <div class="popupResponse changeRef">
        <div class="popupResponseBg"></div>

        <div class="popupResponseItem">

            <svg width="97" height="97" viewBox="0 0 97 97" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M48.5 88.9167C70.8221 88.9167 88.9167 70.8221 88.9167 48.5C88.9167 26.1779 70.8221 8.08333 48.5 8.08333C26.1779 8.08333 8.08333 26.1779 8.08333 48.5C8.08333 70.8221 26.1779 88.9167 48.5 88.9167ZM44.1108 53.6572C43.7713 55.9205 45.6951 57.7878 47.9827 57.7878H49.8823C50.4219 57.7878 50.9414 57.5822 51.3348 57.2128C51.7283 56.8433 51.9662 56.3379 52.0001 55.7992C52.2305 53.6733 53.1439 51.8142 54.7323 50.2258L57.2785 47.72C59.267 45.7193 60.6573 43.9046 61.4535 42.2758C62.2498 40.6228 62.6458 38.8727 62.6458 37.0257C62.6458 32.9638 61.4212 29.8235 58.972 27.6086C56.5227 25.3695 53.0792 24.25 48.6415 24.25C44.2441 24.25 40.7723 25.4221 38.214 27.7703C36.6996 29.1749 35.5923 30.9622 35.0089 32.9436C34.2653 35.3848 36.4639 37.5147 39.0102 37.5147C41.1684 37.5147 42.781 35.7566 44.2805 34.1197C44.4907 33.8894 44.6968 33.659 44.9029 33.4407C45.8487 32.4425 47.0935 31.9453 48.6415 31.9453C51.9071 31.9453 53.54 33.7802 53.54 37.4501C53.54 38.6666 53.2247 39.8306 52.5983 40.938C51.9718 42.0252 50.7027 43.4479 48.7991 45.206C46.9157 46.944 45.6183 48.7182 44.9029 50.5208C44.5513 51.414 44.2886 52.4608 44.1108 53.6572V53.6572ZM44.3411 64.21C43.3994 65.1436 42.9265 66.3399 42.9265 67.7949C42.9265 69.2297 43.3873 70.4139 44.3088 71.3516C45.2505 72.2812 46.4873 72.75 48.015 72.75C49.5428 72.75 50.7633 72.2812 51.6889 71.3475C52.6306 70.4139 53.1035 69.2297 53.1035 67.7949C53.1035 66.3399 52.6185 65.1436 51.6565 64.21C50.7148 63.2521 49.4983 62.7752 48.015 62.7752C46.5277 62.7752 45.303 63.2521 44.3371 64.21H44.3411Z" fill="#FFC700"/>
            </svg>

            <br><br>

            <p class="popupResponseText">Изменение реферала</p>

            <form action="{{ route('changeUserReferal') }}" id="faqRemove" method="POST">
                <input type="hidden" name="changeID" id="removeid" value="">
                <input type="text" class="formInput" style="width: 100%" placeholder="Введите логин нового реферала">
                <button class="passBtn" style="width: 100%">Изменить</button>
            </form>

        </div>
    </div>

@endsection
