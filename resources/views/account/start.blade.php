@extends('../master')

@section('title', 'Быстрый старт')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                @include('account.layout.accountMaster')
                <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>
                <a href="" class="cabinetBtn">Скачать Систему</a>
            </div>
        </div>
    </section>
@endsection
