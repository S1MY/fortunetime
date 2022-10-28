@extends('../master')

@section('title', 'Автоматизация')

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
                            <th>Логин</th>
                            <th>Сумма</th>
                            <th>Дата</th>
                        </tr>

                        @foreach ($paieds as $paied)
                            <tr>
                                <td>{{ $paied->login }}</td>
                                <td>{{ $paied->amount }}</td>
                                <td>{{ $paied->created_at }}</td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
