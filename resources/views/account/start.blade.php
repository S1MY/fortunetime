@extends('../master')

@section('title', 'Быстрый старт')

@section('content')
    <style>
        .dFlex{
            display: inline-flex;
            justify-content: space-between;
        }
        .text{
            min-width: 50%;
        }
        .text .cabinetBtn{
            margin: 0 0 0 auto;
        }
    </style>
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                @include('account.layout.accountMaster')
                <div class="dFlex">
                    <video
                    width="620"
                    controls
                    poster="https://archive.org/download/WebmVp8Vorbis/webmvp8.gif">
                    Your browser doesn't support HTML5 video tag.
                    </video>
                    <div class="text">
                        <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>
                        @if (Auth::user()->UserInfo->activated == 1)
                            <a href="Система ФОРТУНА.pdf" class="cabinetBtn" download>Скачать Систему</a>
                        @else
                            <a href="#" class="cabinetBtn popupBtn" data-popup="starter">Скачать Систему</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
