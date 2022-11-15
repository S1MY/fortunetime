@extends('../master')

@section('title', 'Новости проекта')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                <div class="pageFlex newsFlex">
                    <h1 class="pageName">Новости - <span>{{ $newCount }}</span></h1>
                    <div class="pageFullWidth spaceBetween">
                        @foreach ($news as $new)
                            <div class="newsItem">
                                <div class="newsTop displayFlex alignItemsCenter">
                                    <h3 class="newsTitle">{{ $new->title }}</h3>
                                    <p class="newsDate">{{ date('d M в H:i', strtotime($new->created_at)); }}</p>
                                </div>
                                @if ($new->content != null)
                                    <p class="newsText">{!!$new->content!!}</p>
                                @endif
                                @if ( $new->image != null )
                                    <img src="{{$new->image}}" alt="news" class="newsImage">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                {{ $news->links('vendor.pagination.default') }}
            </div>
        </div>
    </section>
@endsection
