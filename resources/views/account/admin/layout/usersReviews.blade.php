
<div class="uReviewsWrapper">
    <h3 class="cabMatrixName" style="margin-top: 20px">{{$rewTitle}}</h3>

    @foreach ($reviews as $review)

        <div class="reviewItem">
            <div class="pageTableItemL">
                <div class="pageUserAvatar userImage">
                    @if ($review->avatar != '')
                        <img src="{{ Storage::url($review->avatar) }}" alt="avatar">
                    @endif
                </div>
                <div class="pageTableItemInfo">
                    @if ($review->user_name == '')
                        <p class="pageTableUsername">{{ $review->login }}</p>
                    @else
                        <p class="pageTableUsername">{{ $review->user_name }}</p>
                    @endif

                    <p class="pageTableDate">{{ date('d M в H:i', strtotime($review->created_at)); }}</p>
                </div>
            </div>
            <p class="reviewText">{{ $review->review }}</p>
            @if ( $review->published == 1 )
                <span class="reviewController" style="color: #4168D2; cursor: pointer;" data-id="{{ $review->revID }}" data-action="{{ route('reviewChanger') }}" data-value="0">Снять с публикации</span>
            @else
                <span class="reviewController" style="color: #27AE60; cursor: pointer;" data-id="{{ $review->revID }}" data-action="{{ route('reviewChanger') }}" data-value="1">Опубликовать</span>
            @endif
        </div>

    @endforeach
</div>
