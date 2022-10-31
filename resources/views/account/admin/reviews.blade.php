@extends('../master')

@section('title', 'Автоматизация')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner adminFaq">

                @include('account.layout.adminMaster')

                <h3 class="cabMatrixName" style="margin-top: 20px">Все отзывы</h3>

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
                    </div>

                @endforeach
            </div>
        </div>
    </section>

    <div class="popupResponse succes">
        <div class="popupResponseBg"></div>

        <div class="popupResponseItem">

            <svg width="97" height="96" viewBox="0 0 97 96" fill="none" xmlns="http://www.w3.org/2000/svg"><circle opacity="0.12" cx="48.5" cy="48.0001" r="48" fill="#27AE60"/><g clip-path="url(#clip0_2669_4694)"><path d="M36.9847 49.0672C36.3679 48.557 35.5642 48.2802 34.7347 48.2923C33.9053 48.3044 33.1116 48.6045 32.5126 49.1323C31.9137 49.6602 31.554 50.3769 31.5056 51.1385C31.4572 51.9001 31.7237 52.6504 32.2517 53.2389L39.5484 60.2824C39.8539 60.5772 40.221 60.8121 40.6276 60.9732C41.0343 61.1342 41.4721 61.218 41.9149 61.2196C42.3553 61.2219 42.7917 61.1429 43.1982 60.9871C43.6047 60.8313 43.9731 60.6019 44.2814 60.3127L66.5659 39.1518C66.8681 38.866 67.106 38.5282 67.2662 38.1578C67.4265 37.7874 67.5058 37.3916 67.4997 36.993C67.4936 36.5944 67.4022 36.2008 67.2307 35.8347C67.0592 35.4685 66.811 35.1371 66.5002 34.8592C66.1894 34.5813 65.8222 34.3624 65.4194 34.2151C65.0167 34.0677 64.5863 33.9948 64.1529 34.0004C63.7195 34.006 63.2916 34.0901 62.8935 34.2478C62.4955 34.4055 62.1351 34.6338 61.8329 34.9197L41.9477 53.8435L36.9847 49.0672Z" fill="#27AE60"/></g><defs><clipPath id="clip0_2669_4694"><rect width="96" height="96" fill="white" transform="translate(0.5)"/></defs></svg>

            <br><br>

            <p class="popupResponseText">Успешно!</p>

        </div>
    </div>

    <div class="popupResponse deleteQuestion">
        <div class="popupResponseBg"></div>

        <form action="{{ route('faqDelete') }}" id="faqRemove" method="POST">
            <input type="hidden" name="removeid" id="removeid" value="">
        </form>

        <div class="popupResponseItem">

            <svg width="97" height="97" viewBox="0 0 97 97" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M48.5 88.9167C70.8221 88.9167 88.9167 70.8221 88.9167 48.5C88.9167 26.1779 70.8221 8.08333 48.5 8.08333C26.1779 8.08333 8.08333 26.1779 8.08333 48.5C8.08333 70.8221 26.1779 88.9167 48.5 88.9167ZM44.1108 53.6572C43.7713 55.9205 45.6951 57.7878 47.9827 57.7878H49.8823C50.4219 57.7878 50.9414 57.5822 51.3348 57.2128C51.7283 56.8433 51.9662 56.3379 52.0001 55.7992C52.2305 53.6733 53.1439 51.8142 54.7323 50.2258L57.2785 47.72C59.267 45.7193 60.6573 43.9046 61.4535 42.2758C62.2498 40.6228 62.6458 38.8727 62.6458 37.0257C62.6458 32.9638 61.4212 29.8235 58.972 27.6086C56.5227 25.3695 53.0792 24.25 48.6415 24.25C44.2441 24.25 40.7723 25.4221 38.214 27.7703C36.6996 29.1749 35.5923 30.9622 35.0089 32.9436C34.2653 35.3848 36.4639 37.5147 39.0102 37.5147C41.1684 37.5147 42.781 35.7566 44.2805 34.1197C44.4907 33.8894 44.6968 33.659 44.9029 33.4407C45.8487 32.4425 47.0935 31.9453 48.6415 31.9453C51.9071 31.9453 53.54 33.7802 53.54 37.4501C53.54 38.6666 53.2247 39.8306 52.5983 40.938C51.9718 42.0252 50.7027 43.4479 48.7991 45.206C46.9157 46.944 45.6183 48.7182 44.9029 50.5208C44.5513 51.414 44.2886 52.4608 44.1108 53.6572V53.6572ZM44.3411 64.21C43.3994 65.1436 42.9265 66.3399 42.9265 67.7949C42.9265 69.2297 43.3873 70.4139 44.3088 71.3516C45.2505 72.2812 46.4873 72.75 48.015 72.75C49.5428 72.75 50.7633 72.2812 51.6889 71.3475C52.6306 70.4139 53.1035 69.2297 53.1035 67.7949C53.1035 66.3399 52.6185 65.1436 51.6565 64.21C50.7148 63.2521 49.4983 62.7752 48.015 62.7752C46.5277 62.7752 45.303 63.2521 44.3371 64.21H44.3411Z" fill="#FFC700"/>
            </svg>

            <br><br>

            <p class="popupResponseText">Вы уверены что хотите удалить вопрос?</p>

            <div class="cabMenuFlex displayFlex alignItemsCenter spaceBetween">
                <a href="#" class="cabMenuLink delete" style="width: calc((100% - 100px) / 2);" data-remove="">Да</a>
                <a href="#" class="cabMenuLink refresh" style="width: calc((100% - 100px) / 2);">Нет</a>
            </div>

        </div>
    </div>

@endsection

