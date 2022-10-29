@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.adminMaster')

                <form class="passChange displayFlex spaceBetween AJAXForm" method="POST" action="">
                    <input type="text" class="formInput" placeholder="Введите вопрос" name="question">
                    <textarea name="answer" id="answer"></textarea>
                    <button class="passBtn">Добавить FAQ</button>
                </form>

            </div>
        </div>
    </section>
@endsection
