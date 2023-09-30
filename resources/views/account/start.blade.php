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
    </style>
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                @include('account.layout.accountMaster')
                <div class="leson active" data-leson="1">
                    <div class="dFlex">
                        <video width="620" controls poster="">
                            Your browser doesn't support HTML5 video tag.
                        </video>
                        <div class="text">
                            <p class="cabinetText titleStart">Система быстрого старта</p>
                            <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>
                            <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>

                            <a href="#" class="cabinetBtn nextLeson">Следующий урок</a>
                        </div>
                    </div>
                </div>
                <div class="leson" data-leson="2">
                    <div class="dFlex">
                        <video width="620" controls poster="">
                            Your browser doesn't support HTML5 video tag.
                        </video>
                        <div class="text">
                            <p class="cabinetText titleStart">Система быстрого старта 1</p>
                            <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>
                            <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>

                            <a href="#" class="cabinetBtn nextLeson">Следующий урок</a>
                        </div>
                    </div>
                </div>
                <div class="leson" data-leson="3">
                    <div class="dFlex">
                        <video width="620" controls poster="">
                            Your browser doesn't support HTML5 video tag.
                        </video>
                        <div class="text">
                            <p class="cabinetText titleStart">Система быстрого старта 2 </p>
                            <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>
                            <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>

                            <a href="#" class="cabinetBtn nextLeson">Следующий урок</a>
                        </div>
                    </div>
                </div>
                <div class="leson" data-leson="4">
                    <div class="dFlex">
                        <video width="620" controls poster="">
                            Your browser doesn't support HTML5 video tag.
                        </video>
                        <div class="text">
                            <p class="cabinetText titleStart">Система быстрого старта 3</p>
                            <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>
                            <p class="cabinetText">Система быстрого старта позволит вам пригласить минимум 10 партнёров в вашу команду. Даже без опыта. Всё что от вас требуется это соблюдать 4е простых шага, описанных в системе.</p>

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
                console.log(next);
                $('.leson').removeClass('active');
                $('.leson[data-leson=' + next + ']').addClass('active');
            });
        });
    </script>
@endsection
