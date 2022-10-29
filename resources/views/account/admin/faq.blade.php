@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner adminFaq">

                @include('account.layout.adminMaster')

                <h3 class="cabMatrixName" style="margin-top: 20px">Форма создания вопроса</h3>
                <form class="passChange AJAXForm" method="POST" action="">
                    <label for="question">
                        <input type="text" class="formInput" placeholder="Введите вопрос" name="question" id="question">
                    </label>
                    <label for="answer">
                        <textarea name="answer" id="answer"></textarea>
                    </label>
                    <button class="passBtn">Добавить FAQ</button>
                </form>

            </div>
        </div>
    </section>
@endsection
