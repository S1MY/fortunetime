@extends('../master')

@section('title', 'Заявки на вывод')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.adminMaster')

                @if ( $outputs->count() == 0 )
                    <h3 class="cabMatrixName" style="margin-top: 20px">Заявок ещё не было...</h3>
                @else
                    <div class="info">
                        <h3 class="cabMatrixName" style="margin-top: 20px">Информация</h3>
                        <p>Уже выплатили: <span style="font-weight: bold;">{{ $outputsum }} руб.</span></p>
                        <p>Предстоит выплатить: <span style="font-weight: bold;">{{ $outputsumnext }} руб.</span></p>
                    </div>

                    <div class="tableWrapper">
                        <h3 class="cabMatrixName" style="margin-top: 20px">{{ $title }}</h3>
                        <table class="adminTable">
                            <tr>
                                <th>Логин</th>
                                <th>Куда выплачивать</th>
                                <th>Реквизиты</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                                <th>Дата</th>
                                <th>Выплачено?</th>
                            </tr>
                            @foreach ($outputs as $paied)
                                <tr>
                                    <td class="tacenter">{{ $paied->login }}</td>
                                    <td class="tacenter" style="text-transform: uppercase;">{{ $paied->reqname }}</td>
                                    <td class="tacenter">{{ $paied->req }}</td>
                                    <td class="tacenter">{{ $paied->amount }}</td>
                                    <td class="tacenter">{{ $paied->status }}</td>
                                    <td class="tacenter">{{ $paied->created_at }}</td>
                                    @php
                                        if( $paied->status == 0 ){
                                            $text = 'Выплатить';
                                        }else{
                                            $text = 'Да';
                                        }
                                    @endphp
                                    <td class="tacenter"><a href="#" id="adminPayed" data-id="{{ $paied->id }}" data-action="{{ route('adminPayedGo') }}">{{ $text }}</a></td>
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
