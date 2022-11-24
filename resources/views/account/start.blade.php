@extends('../master')

@section('title', 'Быстрый старт')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                @include('account.layout.accountMaster')
                <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>
                @if (Auth::user()->UserInfo->activated == 1)
                    <a href="#" class="cabinetBtn popupBtn" data-popup="starter">Скачать Систему</a>
                @else
                    <a href="Система ФОРТУНА.pdf" class="cabinetBtn popupBtn" download>Скачать Систему</a>
                @endif
            </div>
        </div>
    </section>
@endsection
