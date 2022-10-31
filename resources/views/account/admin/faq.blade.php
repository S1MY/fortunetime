@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner adminFaq">

                @include('account.layout.adminMaster')

                <h3 class="cabMatrixName" style="margin-top: 20px">Форма создания вопроса</h3>
                <form class="AJAXForm" id="adminFAQ" method="POST" action="{{ route('adminAddFAQ') }}">
                    <label for="question">
                        <input type="text" class="formInput" placeholder="Введите вопрос" name="question" id="question">
                    </label>
                    <label for="answer">
                        <textarea name="answer" id="summernote" placeholder="Введите ответ на вопрос"></textarea>
                    </label>
                    <button class="passBtn">Добавить FAQ</button>
                </form>
                <h3 class="cabMatrixName" style="margin-top: 20px">Существующие вопросы</h3>

                @foreach ($faqs as $faq)
                <div class="answerItem">
                    <p class="answerHeader displayFlex alignItemsCenter">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.7178 10.6409C15.2155 10.1505 13.4082 10.0188 12.0556 10.0019V9.99801C13.4082 9.98125 15.2155 9.84953 16.7178 9.35905C17.4419 9.19963 18.1646 8.81258 18.7673 8.20991C20.2087 6.76848 20.416 4.63877 19.2304 3.45315C18.7227 2.94543 18.0419 2.69315 17.3162 2.68379C17.3069 1.9581 17.0546 1.27729 16.5469 0.769611C15.3612 -0.416076 13.2315 -0.208705 11.7901 1.23275C11.1874 1.83534 10.8005 2.55827 10.6409 3.28219C10.1505 4.78448 10.0188 6.59181 10.0019 7.94439H9.99801C9.98125 6.59181 9.84953 4.78438 9.35905 3.28219C9.19963 2.55806 8.81258 1.83534 8.20991 1.23275C6.76848 -0.208705 4.63877 -0.416076 3.45315 0.769611C2.94543 1.27729 2.69315 1.9581 2.68379 2.68379C1.95806 2.69315 1.27729 2.94543 0.769611 3.45315C-0.416076 4.63877 -0.208705 6.76848 1.23275 8.20991C1.83538 8.81258 2.55827 9.19944 3.28219 9.35905C4.78448 9.84953 6.59181 9.98125 7.94439 9.99801V10.0019C6.59181 10.0188 4.78448 10.1505 3.28219 10.6409C2.55806 10.8004 1.83538 11.1874 1.23275 11.7901C-0.208705 13.2315 -0.416076 15.3612 0.769611 16.5469C1.27729 17.0546 1.95806 17.3069 2.68379 17.3162C2.69315 18.0419 2.94543 18.7227 3.45315 19.2304C4.63877 20.416 6.76848 20.2088 8.20991 18.7673C8.81258 18.1646 9.19944 17.4417 9.35905 16.7178C9.84953 15.2155 9.98125 13.4082 9.99801 12.0556H10.0019C10.0188 13.4082 10.1505 15.2155 10.6409 16.7178C10.8004 17.4419 11.1874 18.1646 11.7901 18.7673C13.2315 20.2087 15.3612 20.416 16.5469 19.2304C17.0546 18.7227 17.3069 18.0419 17.3162 17.3162C18.0419 17.3069 18.7227 17.0546 19.2304 16.5469C20.416 15.3612 20.2088 13.2315 18.7673 11.7901C18.1646 11.1874 17.4417 10.8006 16.7178 10.6409Z" fill="#4168D2"/>
                        </svg>
                        <span>{{ $faq->qustion }}</span>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="answerIcon" style="right: 40px;">
                            <path d="M9.98715 11.8612L15.9161 5.42491C16.024 5.29628 16.1545 5.19245 16.3001 5.11958C16.4456 5.04671 16.6031 5.00628 16.7633 5.00068C16.9235 4.99507 17.0831 5.02441 17.2326 5.08696C17.3822 5.1495 17.5186 5.24398 17.6339 5.36481C17.7493 5.48563 17.8411 5.63034 17.9039 5.79037C17.9668 5.9504 17.9995 6.1225 18 6.29648C18.0005 6.47045 17.9689 6.64277 17.9069 6.80324C17.845 6.9637 17.754 7.10905 17.6395 7.23067L17.6103 7.26235L10.8351 14.6191C10.6104 14.863 10.3057 15 9.98796 15C9.67024 15 9.36554 14.863 9.14086 14.6191L2.36565 7.26411C2.25249 7.14543 2.16197 7.00371 2.09927 6.84705C2.03656 6.69039 2.00289 6.52186 2.00018 6.35107C1.99747 6.18029 2.02577 6.01059 2.08347 5.85168C2.14117 5.69277 2.22714 5.54776 2.33647 5.42491C2.4458 5.30207 2.57634 5.2038 2.72065 5.13573C2.86496 5.06766 3.02021 5.0311 3.17753 5.02816C3.33485 5.02522 3.49116 5.05595 3.63755 5.11858C3.78393 5.18122 3.91752 5.27455 4.03067 5.39323L4.05986 5.42491L9.98715 11.8612Z" fill="#4168D2"/>
                        </svg>
                        <svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" class="answerIcon editIcon">
                            <path fill="#4168D2" d="M3.5,24h15A3.51,3.51,0,0,0,22,20.487V12.95a1,1,0,0,0-2,0v7.537A1.508,1.508,0,0,1,18.5,22H3.5A1.508,1.508,0,0,1,2,20.487V5.513A1.508,1.508,0,0,1,3.5,4H11a1,1,0,0,0,0-2H3.5A3.51,3.51,0,0,0,0,5.513V20.487A3.51,3.51,0,0,0,3.5,24Z"></path>
                            <path fill="#4168D2" d="M9.455,10.544l-.789,3.614a1,1,0,0,0,.271.921,1.038,1.038,0,0,0,.92.269l3.606-.791a1,1,0,0,0,.494-.271l9.114-9.114a3,3,0,0,0,0-4.243,3.07,3.07,0,0,0-4.242,0l-9.1,9.123A1,1,0,0,0,9.455,10.544Zm10.788-8.2a1.022,1.022,0,0,1,1.414,0,1.009,1.009,0,0,1,0,1.413l-.707.707L19.536,3.05Zm-8.9,8.914,6.774-6.791,1.4,1.407-6.777,6.793-1.795.394Z"></path>
                        </svg>
                    </p>
                    <p class="answerContent">{!! $faq->answer !!}</p>
                </div>
                @endforeach


            </div>
        </div>
    </section>

@endsection

