@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.adminMaster')

                <div class="bgBlue" style="color: #FFFFFF;
                                           background: #4168D2;
                                           display: inline-block;
                                           border-radius: 6px;
                                           margin-top: 10px;
                                           padding: 10px 18px;">
                    <h3>Общая сумма</h3>
                    <p style="font-size: 24px;
                              font-weight: bold;">{{ $paiedsum }} руб</p>
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
                                <td class="tacenter">{{ $paied->login }}</td>
                                <td class="tacenter">{{ $paied->amount }}</td>
                                <td class="tacenter">{{ $paied->created_at }}</td>
                            </tr>
                        @endforeach

                    </table>

                    {{ $paieds->links('vendor.pagination.default') }}
                </div>
            </div>
        </div>
    </section>
@endsection
