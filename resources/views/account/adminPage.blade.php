@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.adminMaster')

                @foreach ($users as $user)
                    {{ $user->login }}
                @endforeach
            </div>
        </div>
    </section>
@endsection
