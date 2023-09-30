@extends('../master')

@section('title', 'Быстрый старт')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                @include('account.layout.accountMaster')
                <div class="dFlex">
                    <video
                    width="480"
                    controls
                    poster="https://archive.org/download/WebmVp8Vorbis/webmvp8.gif">
                    <source
                        src="https://archive.org/download/WebmVp8Vorbis/webmvp8_512kb.mp4"
                        type="video/mp4" />
                    <source
                        src="https://archive.org/download/WebmVp8Vorbis/webmvp8.ogv"
                        type="video/ogg" />
                    <source
                        src="https://archive.org/download/WebmVp8Vorbis/webmvp8.webm"
                        type="video/webm" />
                    Your browser doesn't support HTML5 video tag.
                    </video>
                </div>
                <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>
                @if (Auth::user()->UserInfo->activated == 1)
                    <a href="Система ФОРТУНА.pdf" class="cabinetBtn" download>Скачать Систему</a>
                @else
                    <a href="#" class="cabinetBtn popupBtn" data-popup="starter">Скачать Систему</a>
                @endif
            </div>
        </div>
    </section>
@endsection
