@extends('../master')

@section('title', 'Быстрый старт')

@section('content')
    <style>
        .dFlex{
            display: inline-flex;
            justify-content: space-between;
            margin-top: 16px;
            gap: 16px;
        }
        .text{
            max-width: 50%;
        }
        .text .cabinetBtn{
            margin: 16px 0 0 auto;
        }
        .titleStart{
            font-size: 24px;
            font-weight: bold;
        }
        .leson{
            display: none;
        }
        .leson.active{
            display: block;
        }
        .cabinetBtn{
            display: inline-flex;
            max-width: calc(50% - 2px);
        }
        @media (max-width: 1326px){
            .cabinetBtn{
                max-width: calc(50% - 2px);
            }
        }
        @media (max-width: 1240px){
            .dFlex{
                display: block;
            }
            .text,
            .dFlex video{
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                @include('account.layout.accountMaster')
                <div class="leson active" data-leson="1">
                    <div class="dFlex">
                        <video width="620" controls poster="" class="leson1">
                            Your browser doesn't support HTML5 video tag.
                            <source src="{{url('video/lesons/1/Урок 1 готов.mp4')}}" type="video/mp4">
                        </video>
                        <div class="text">
                            <p class="cabinetText titleStart">КОНТЕНТ И ПОДГОТОВКА</p>
                            <p class="cabinetText">В этом уроке мы с вами. <br>
                                Подготовим все необходимые материалы. <br>
                                Разберём и изучим подготовленный контент план <br>
                                Зарегистрируемся на всех необходимых для дальнейшей работы сайтах.</p>
                            <p class="cabinetText">Перед просмотром урока, необходимо скачать чек лист.</p>

                            <a href="{{url('video/lesons/1/Урок 1.zip')}}" download class="cabinetBtn">Скачать</a>
                            <a href="#" class="cabinetBtn nextLeson">Следующий урок</a>
                        </div>
                    </div>
                </div>
                <div class="leson" data-leson="2">
                    <div class="dFlex">
                        <video width="620" controls poster="" class="leson2">
                            Your browser doesn't support HTML5 video tag.
                            <source src="{{url('video/lesons/2/Урок 2 готов.mp4')}}" type="video/mp4">
                        </video>
                        <div class="text">
                            <p class="cabinetText titleStart">АВТОТРАНСЛЯЦИИ И РАБОТА НА САЙТАХ</p>
                            <p class="cabinetText">В этом уроке мы с вами. <br>
                                Узнаем что такое автотрансляции. <br>
                                Запустим вашу первую систему автоматизации. <br>
                                А так же начнём выполнять необходимые действия на рекламных сайтах.</p>
                            <p class="cabinetText">Перед просмотром урока, необходимо скачать чек лист.</p>

                            <a href="{{url('video/lesons/2/Урок 2.zip')}}" download class="cabinetBtn">Скачать</a>
                            <a href="#" class="cabinetBtn nextLeson">Следующий урок</a>
                        </div>
                    </div>
                </div>
                <div class="leson" data-leson="3">
                    <div class="dFlex">
                        <video width="620" controls poster="">
                            Your browser doesn't support HTML5 video tag.
                            <source src="{{url('video/lesons/3/Урок 3 готов.mp4')}}" type="video/mp4">
                        </video>
                        <div class="text">
                            <p class="cabinetText titleStart">СОЗДАНИЕ КОНТЕНТА И НЕЙРОСЕТИ</p>
                            <p class="cabinetText">В этом уроке мы с вами. <br>
                                Научимся использовать нейросети, для создания креативов. <br>
                                Научимся создавать продающие посты по формуле AIDA <br>
                                И разберём дальнейшие шаги.</p>
                            <p class="cabinetText">Перед просмотром урока, необходимо скачать чек лист.</p>

                            <a href="{{url('video/lesons/3/Урок 3.zip')}}" download class="cabinetBtn">Скачать</a>
                            <a href="#" class="cabinetBtn popupBtn martixBuyer" data-popup="starter" data-matrix-id="1">Начать заработок</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            $('.nextLeson').click(function(e){
                e.preventDefault();
                let next = parseInt($(this).parent().parent().parent().attr('data-leson')) + 1;
                if( next == 2 ){
                    $('video.leson1').remove();
                }else if(next == 3){
                    $('video.leson2').remove();
                }
                $('.leson').removeClass('active');
                $('.leson[data-leson=' + next + ']').addClass('active');
            });
        });
    </script>
@endsection
