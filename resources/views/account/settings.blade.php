@extends('../master')

@section('title', 'Настройки')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.accountMaster')

                <div class="cabinetFlex displayFlex spaceBetween alignScretch flexWrap">
                    <div class="cabinetItem">
                        <div class="cabinetTop displayFlex alignItemsCenter">
                            <form id="avatarUpload" method="POST" enctype="multipart/form-data" action="{{ route('update.avatar', Auth::user()->id) }}" class="avatarCab">
                                @if (Auth::user()->UserInfo->avatar != '')
                                    <img src="{{ Storage::url(Auth::user()->UserInfo->avatar) }}" alt="avatar">
                                @endif
                                <div class="avatarLoad displayFlex alignItemsCenter spaceCenter">
                                    <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M28.4375 2.91669H6.56246C4.54969 2.91856 2.9185 4.54975 2.91663 6.56252V28.4375C2.9185 30.4503 4.54969 32.0815 6.56246 32.0834H28.4375C30.4502 32.0815 32.0814 30.4503 32.0833 28.4375V6.56252C32.0814 4.54975 30.4502 2.91856 28.4375 2.91669ZM6.56246 30.625C5.35487 30.6237 4.37629 29.6451 4.37496 28.4375V20.8183L9.86222 15.331C10.8598 14.337 12.4735 14.337 13.471 15.331L28.7361 30.5947C28.6376 30.6084 28.5397 30.6249 28.4375 30.625H6.56246ZM30.625 28.4375C30.6243 28.9893 30.4129 29.4874 30.0756 29.8721L19.9896 19.7869L21.5289 18.2477C22.5264 17.2536 24.1402 17.2536 25.1377 18.2477L30.625 23.735V28.4375ZM30.625 21.6729L26.1688 17.2167C24.6019 15.653 22.0647 15.653 20.4978 17.2167L18.9586 18.7559L14.5021 14.2999C12.9154 12.7846 10.4178 12.7846 8.83114 14.2999L4.37496 18.7561V6.56252C4.37629 5.35493 5.35487 4.37636 6.56246 4.37502H28.4375C29.6451 4.37636 30.6236 5.35493 30.625 6.56252V21.6729Z" fill="white"/>
                                    </svg>
                                </div>
                                <input type="file" name="userfile" class="avatarInput" title="Загрузить аватар..">
                            </form>
                            <div class="cabinetInfo">
                                <p class="cabinetName">{{ Auth::user()->login }}</p>
                                <p class="cabinetInfoItem">{{ Auth::user()->email }}</p>
                                @if ( Auth::user()->UserInfo->activated == 0 )
                                    <p class="cabinetInfoItem">для активации аккаунте требуется оплата взноса</p>
                                @else
                                    <p class="cabinetInfoItem active">Активирован</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ( Auth::user()->UserInfo->account_password == null )
                        <div class="cabinetItem">
                            <form class="passChange displayFlex spaceBetween AJAXForm" id="SetPincode" method="POST" action="{{ route('update.user', Auth::user()->id) }}">
                                @csrf
                                <input type="password" class="formInput setCode" placeholder="Пин-код" name="pincode">
                                <button class="passBtn">Установить пин-код</button>
                            </form>
                        </div>
                    @else
                        <div class="cabinetItem">
                            <form class="passChange displayFlex spaceBetween AJAXForm" id="SetPincode" method="POST" action="{{ route('update.user', Auth::user()->id) }}">
                                @csrf
                                <input type="password" class="formInput" placeholder="Новый пароль" name="pass">
                                <input type="password" class="formInput" placeholder="Повторите пароль" name="repass">
                                <input type="password" class="formInput" placeholder="Пин-код" name="pincode">
                                <button class="passBtn">Сменить Пароль</button>
                            </form>
                        </div>
                        <div class="cabinetItem">
                            <form class="passChange displayFlex spaceBetween AJAXForm" id="SetPincode" method="POST" action="{{ route('update.user', Auth::user()->id) }}">
                                @csrf
                                <input type="password" class="formInput" placeholder="Новый пароль" name="pass">
                                <input type="password" class="formInput" placeholder="Повторите пароль" name="repass">
                                <input type="password" class="formInput" placeholder="Пин-код" name="pincode">
                                <button class="passBtn">Сменить Пароль</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
