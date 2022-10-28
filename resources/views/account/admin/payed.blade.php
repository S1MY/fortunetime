@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.adminMaster')

                <div class="tableWrapper">
                    <h3 class="cabMatrixName" style="margin-top: 20px">{{ $title }}</h3>
                    <table class="adminTable">
                        <tr>
                            <th>Логин</th>
                            <th>Сумма</th>
                            <th>Дата</th>
                        </tr>
                        {{ dd($paieds) }}
                        @foreach ($paieds as $paied)
                            <tr>
                                <td class="tacenter">{{ $paied->login }}</td>
                                <td class="tacenter">{{ $paied->amount }}</td>
                                <td class="tacenter">{{ $paied->created_at }}</td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
