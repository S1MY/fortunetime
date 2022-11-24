@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.adminMaster')

                @if ($paiedsum != 0)
                    <h3 class="cabMatrixName" style="margin-top: 20px">Пополнений ещё не было...</h3>
                @else
                    <div class="info">
                        <h3 class="cabMatrixName" style="margin-top: 20px">Информация</h3>
                        <p>Общая сумма: <span style="font-weight: bold;">{{ $paiedsum }} руб.</span></p>
                    </div>

                    <div class="tableWrapper">
                        <h3 class="cabMatrixName" style="margin-top: 20px">{{ $title }}</h3>
                        <table class="adminTable">
                            <tr>
                                <th>Логин</th>
                                <th>Сумма</th>
                                <th>Агрегатор</th>
                                <th>Дата</th>
                            </tr>
                            @foreach ($paieds as $paied)
                                <tr>
                                    <td class="tacenter">{{ $paied->login }}</td>
                                    <td class="tacenter">{{ $paied->amount }}</td>

                                    <td class="tacenter">{{ $paied->payeer }}</td>
                                    <td class="tacenter">{{ $paied->created_at }}</td>
                                </tr>
                            @endforeach

                        </table>

                        {{-- {{ $paieds->links('vendor.pagination.default') }} --}}
                    </div>
                @endif


            </div>
        </div>
    </section>
@endsection
