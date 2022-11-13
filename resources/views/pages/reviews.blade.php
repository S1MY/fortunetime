@extends('../master')

@section('title', 'Последние отзывы')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                <div class="pageFlex displayFlex spaceBetween reviewsFlex">
                    <div class="pageFlexItem">
                        <h1 class="pageName">Последние отзывы</h1>
                        @php
                            $user = null;
                            if( Auth::user() != null ){
                                $user = Auth::user()->id;
                            }
                        @endphp
                        <form class="reviewsForm AJAXForm" id="ReviewStore" method="POST" action="{{ route('createReview') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user }}">
                            <textarea class="contactArea" name="review" placeholder="Ваш отзыв"></textarea>
                            <button class="standartBtn">Оставить отзыв</button>
                        </form>
                        <h3 class="dopSecTitle">Всего отзывов: <span>{{ $revCount }}</span></h3>
                        @foreach ($reviews as $review)
                            <div class="reviewItem">
                                <div class="pageTableItemL">
                                    <div class="pageUserAvatar"></div>
                                    <div class="pageTableItemInfo">
                                        <p class="pageTableUsername">{{ $review->User->login }}</p>
                                        <p class="pageTableDate">{{ date('d M в H:i', strtotime($review->created_at)); }}</p>
                                    </div>
                                </div>
                                <p class="reviewText">{{ $review->review }}</p>
                            </div>
                        @endforeach
                        {{ $reviews->links('vendor.pagination.default') }}
                    </div>
                    <div class="pageFlexItem">
                        <h2 class="pageName">Последние видео-отзывы</h2>
                        <div class="reviewVideo">
                            <video name="media" autoplay="" controls="" style="width: 100%;">
                                <source src="https://fortune-time.ru/video/Ролик на отзыв.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
