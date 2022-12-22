@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                @include('account.layout.accountMaster')
                <p class="cabinetText">Система авторекрута под ключ. Полностью автоматизированная система, которая позволяет поставить ваш бизнес на автомат уже в первый день её применения.</p>
                <div class="automatFlex displayFlex spaceBetween">
                    <div class="automatVideo">
                        <video name="media" autoplay controls style="width: 100%;">
                            <source src="https://fortune-time.pro/video/10.mp4" type="video/mp4">
                        </video>
                    </div>
                    {{-- <div class="automatLinks">
                        <a href="/" class="automatLink">Ссылка 1</a>
                        <a href="/" class="automatLink">Ссылка 2</a>
                        <a href="/" class="automatLink">Ссылка 3</a>
                        <a href="/" class="automatLink">Ссылка 4</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
