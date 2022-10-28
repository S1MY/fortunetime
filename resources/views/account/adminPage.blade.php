@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.adminMaster')

                @foreach ($users as $user)
                    <div class="itemWrapper">
                        <p class="wrapperContent">{{ $user->login }}</p>
                        <p class="wrapperContent">{{ $user->email }}</p>
                        <p class="wrapperContent">{{ $user->sponsor }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
