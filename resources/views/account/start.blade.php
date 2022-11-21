@extends('../master')

@section('title', 'Быстрый старт')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                @include('account.layout.accountMaster')
                {{-- <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>
                <a href="#" class="cabinetBtn popupBtn" data-popup="starter">Скачать Систему</a> --}}
                <p class="cabinetText" style="text-align: center">Старт маркетинг проекта будет 23.11.2022!
                <br>    В данный наблюдаем за нагрузкой оказанной на сервер и на сайт!
                <br>    Мы обязательно оповестим вас по EMail адрессу и в наших группах!</p>
            </div>
        </div>
    </section>
@endsection
