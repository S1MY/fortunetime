@extends('../master')

@section('title', 'Личный кабинет')

@section('content')
<style>
    p{
        text-align: center;
    }
    span{
        display: inline-block;
        margin: 0 5px;
    }
</style>
@php

    $martixID = 61;

    $lineG = array(4, 12, 28, 60, 124, 252, 508);

    for ($i=1; $i < 7; $i++) {

        $placeInLine =
        DB::table('matrix_placers')->where([
            ['matrix_id', '=', $martixID],
            ['line', '=', $i],
        ])->orWhere([
            ['referer_id', '=', $martixID],
            ['referer_line', '=', $i],
        ])->get();

        $countInLine = $placeInLine->count();

        dd($placeInLine);

        if( !in_array($countInLine, $lineG) ){

            echo 'Свободная линия - '.$i;
            echo '<br>';
            echo 'Свободное место - '.$countInLine + 1;
            echo '<br>';
            echo 'MatrixID - '. $martixID;

            break;
        }
    }

    exit;

@endphp
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">

                @include('account.layout.accountMaster')

                <div class="cabinetFlex displayFlex spaceBetween">
                    <div class="cabinetItem">
                        <div class="cabinetTop displayFlex alignItemsCenter">
                            <div class="avatarItem">
                                @if (Auth::user()->UserInfo->avatar != '')
                                    <img src="{{ Storage::url(Auth::user()->UserInfo->avatar) }}" alt="avatar">
                                @endif
                            </div>
                            <div class="cabinetInfo">
                                @php
                                    $sugarID = md5(Auth::user()->login);
                                @endphp
                                <p class="cabinetName">
                                    @if (Auth::user()->UserInfo->user_name != null)
                                        {{ Auth::user()->UserInfo->user_name }} <span style="font-size: 16px;">({{ Auth::user()->login }})</span>
                                    @else
                                        {{ Auth::user()->login }}
                                    @endif
                                </p>
                                <p class="cabinetInfoItem">id: {{ $sugarID }}</p>
                                @if ( Auth::user()->UserInfo->activated == 0 )
                                    <p class="cabinetInfoItem">для активации аккаунте требуется оплата взноса</p>
                                @endif
                            </div>
                        </div>
                        <div class="linkBlock">
                            <p class="labelText">Ваша реферальная ссылка:</p>
                            <p class="fullLink">
                                <span class="linkCopy displayFlex alignItemsCenter spaceCenter" title="Скопировать">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_354_1362)">
                                            <path d="M20.2499 2.99951H6.74892C6.55 2.99951 6.35923 3.07853 6.21858 3.21919C6.07792 3.35984 5.9989 3.55061 5.9989 3.74953C5.9989 3.94845 6.07792 4.13922 6.21858 4.27988C6.35923 4.42053 6.55 4.49955 6.74892 4.49955H19.4999V17.25C19.4999 17.4489 19.5789 17.6397 19.7196 17.7803C19.8602 17.921 20.051 18 20.2499 18C20.4489 18 20.6396 17.921 20.7803 17.7803C20.9209 17.6397 21 17.4489 21 17.25V3.74953C21 3.55062 20.9209 3.35985 20.7803 3.21919C20.6396 3.07853 20.4489 2.99951 20.2499 2.99951V2.99951Z" fill="white" />
                                            <path d="M17.2498 5.99951H3.74886C3.33464 5.99951 2.99884 6.33531 2.99884 6.74953V20.2499C2.99884 20.6641 3.33464 20.9999 3.74886 20.9999H17.2498C17.664 20.9999 17.9998 20.6641 17.9998 20.2499V6.74953C17.9998 6.33531 17.664 5.99951 17.2498 5.99951Z" fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_354_1362">
                                                <path d="M0 0H18C21.3137 0 24 2.68629 24 6V18C24 21.3137 21.3137 24 18 24H0V0Z" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                <span class="linkRef">{{ Request::root() }}/referral/{{ Auth::user()->login }}</span>
                                <span class="copy">Скопировано</span>
                            </p>
                        </div>
                    </div>
                    <div class="cabinetItem">
                        <div class="cabinetTop displayFlex spaceBetween">
                            <div class="cabinetTopItem displayFlex spaceBetween alignItemsCenter">
                                <div class="cabinetTopIcon displayFlex alignItemsCenter spaceCenter">
                                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.9302 17H2.22845C1.95392 17 1.69065 17.1054 1.49653 17.2929C1.30241 17.4804 1.19336 17.7348 1.19336 18C1.19336 18.2652 1.30241 18.5196 1.49653 18.7071C1.69065 18.8946 1.95392 19 2.22845 19H22.9302C23.2047 19 23.468 18.8946 23.6621 18.7071C23.8562 18.5196 23.9653 18.2652 23.9653 18C23.9653 17.7348 23.8562 17.4804 23.6621 17.2929C23.468 17.1054 23.2047 17 22.9302 17ZM22.9302 21H2.22845C1.95392 21 1.69065 21.1054 1.49653 21.2929C1.30241 21.4804 1.19336 21.7348 1.19336 22C1.19336 22.2652 1.30241 22.5196 1.49653 22.7071C1.69065 22.8946 1.95392 23 2.22845 23H22.9302C23.2047 23 23.468 22.8946 23.6621 22.7071C23.8562 22.5196 23.9653 22.2652 23.9653 22C23.9653 21.7348 23.8562 21.4804 23.6621 21.2929C23.468 21.1054 23.2047 21 22.9302 21ZM6.3688 7C6.16408 7 5.96395 7.05865 5.79373 7.16853C5.62351 7.27841 5.49084 7.43459 5.4125 7.61732C5.33416 7.80004 5.31366 8.00111 5.3536 8.19509C5.39354 8.38907 5.49212 8.56725 5.63688 8.70711C5.78164 8.84696 5.96607 8.9422 6.16686 8.98079C6.36765 9.01937 6.57577 8.99957 6.76491 8.92388C6.95405 8.84819 7.11571 8.72002 7.22944 8.55557C7.34318 8.39112 7.40389 8.19778 7.40389 8C7.40389 7.73478 7.29483 7.48043 7.10072 7.29289C6.9066 7.10536 6.64332 7 6.3688 7ZM20.86 1H4.29862C3.47506 1 2.68522 1.31607 2.10287 1.87868C1.52052 2.44129 1.19336 3.20435 1.19336 4V12C1.19336 12.7956 1.52052 13.5587 2.10287 14.1213C2.68522 14.6839 3.47506 15 4.29862 15H20.86C21.6836 15 22.4734 14.6839 23.0558 14.1213C23.6381 13.5587 23.9653 12.7956 23.9653 12V4C23.9653 3.20435 23.6381 2.44129 23.0558 1.87868C22.4734 1.31607 21.6836 1 20.86 1ZM21.8951 12C21.8951 12.2652 21.7861 12.5196 21.5919 12.7071C21.3978 12.8946 21.1345 13 20.86 13H4.29862C4.0241 13 3.76082 12.8946 3.5667 12.7071C3.37259 12.5196 3.26353 12.2652 3.26353 12V4C3.26353 3.73478 3.37259 3.48043 3.5667 3.29289C3.76082 3.10536 4.0241 3 4.29862 3H20.86C21.1345 3 21.3978 3.10536 21.5919 3.29289C21.7861 3.48043 21.8951 3.73478 21.8951 4V12ZM12.5793 5C11.9652 5 11.3648 5.17595 10.8541 5.50559C10.3435 5.83524 9.94547 6.30377 9.71043 6.85195C9.4754 7.40013 9.41391 8.00333 9.53373 8.58527C9.65354 9.16721 9.94929 9.70176 10.3836 10.1213C10.8179 10.5409 11.3712 10.8266 11.9735 10.9424C12.5759 11.0581 13.2002 10.9987 13.7677 10.7716C14.3351 10.5446 14.82 10.1601 15.1613 9.66671C15.5025 9.17336 15.6846 8.59334 15.6846 8C15.6846 7.20435 15.3574 6.44129 14.7751 5.87868C14.1927 5.31607 13.4029 5 12.5793 5ZM12.5793 9C12.3746 9 12.1745 8.94135 12.0043 8.83147C11.834 8.72159 11.7014 8.56541 11.623 8.38268C11.5447 8.19996 11.5242 7.99889 11.5641 7.80491C11.6041 7.61093 11.7026 7.43275 11.8474 7.29289C11.9922 7.15304 12.1766 7.0578 12.3774 7.01921C12.5782 6.98063 12.7863 7.00043 12.9754 7.07612C13.1646 7.15181 13.3262 7.27998 13.44 7.44443C13.5537 7.60888 13.6144 7.80222 13.6144 8C13.6144 8.26522 13.5054 8.51957 13.3112 8.70711C13.1171 8.89464 12.8538 9 12.5793 9ZM18.7899 7C18.5851 7 18.385 7.05865 18.2148 7.16853C18.0446 7.27841 17.9119 7.43459 17.8336 7.61732C17.7552 7.80004 17.7347 8.00111 17.7747 8.19509C17.8146 8.38907 17.9132 8.56725 18.0579 8.70711C18.2027 8.84696 18.3871 8.9422 18.5879 8.98079C18.7887 9.01937 18.9968 8.99957 19.186 8.92388C19.3751 8.84819 19.5368 8.72002 19.6505 8.55557C19.7642 8.39112 19.8249 8.19778 19.8249 8C19.8249 7.73478 19.7159 7.48043 19.5218 7.29289C19.3277 7.10536 19.0644 7 18.7899 7Z" fill="white"/>
                                    </svg>
                                </div>
                                <div class="cabinetTopInfo">
                                    <p class="cabinetTopName">Заработано всего</p>
                                    <p class="cabinetTopCount">{{ Auth::user()->UserInfo->earned; }} rub.</p>
                                </div>
                            </div>
                            <div class="cabinetTopItem displayFlex spaceBetween alignItemsCenter">
                                <div class="cabinetTopIcon displayFlex alignItemsCenter spaceCenter">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 12C11.4067 12 10.8266 12.1759 10.3333 12.5056C9.83994 12.8352 9.45542 13.3038 9.22836 13.8519C9.0013 14.4001 8.94189 15.0033 9.05764 15.5853C9.1734 16.1672 9.45912 16.7018 9.87868 17.1213C10.2982 17.5409 10.8328 17.8266 11.4147 17.9424C11.9967 18.0581 12.5999 17.9987 13.1481 17.7716C13.6962 17.5446 14.1648 17.1601 14.4944 16.6667C14.8241 16.1734 15 15.5933 15 15C15 14.2044 14.6839 13.4413 14.1213 12.8787C13.5587 12.3161 12.7956 12 12 12ZM12 16C11.8022 16 11.6089 15.9414 11.4444 15.8315C11.28 15.7216 11.1518 15.5654 11.0761 15.3827C11.0004 15.2 10.9806 14.9989 11.0192 14.8049C11.0578 14.6109 11.153 14.4327 11.2929 14.2929C11.4327 14.153 11.6109 14.0578 11.8049 14.0192C11.9989 13.9806 12.2 14.0004 12.3827 14.0761C12.5654 14.1518 12.7216 14.28 12.8315 14.4444C12.9414 14.6089 13 14.8022 13 15C13 15.2652 12.8946 15.5196 12.7071 15.7071C12.5196 15.8946 12.2652 16 12 16ZM11.29 9.71C11.3851 9.80104 11.4972 9.87241 11.62 9.92C11.7397 9.97291 11.8691 10.0002 12 10.0002C12.1309 10.0002 12.2603 9.97291 12.38 9.92C12.5028 9.87241 12.6149 9.80104 12.71 9.71L15 7.46C15.1936 7.26639 15.3024 7.0038 15.3024 6.73C15.3024 6.4562 15.1936 6.19361 15 6C14.8064 5.80639 14.5438 5.69762 14.27 5.69762C13.9962 5.69762 13.7336 5.80639 13.54 6L13 6.59V3C13 2.73478 12.8946 2.48043 12.7071 2.29289C12.5196 2.10536 12.2652 2 12 2C11.7348 2 11.4804 2.10536 11.2929 2.29289C11.1054 2.48043 11 2.73478 11 3V6.59L10.46 6C10.2664 5.80639 10.0038 5.69762 9.73 5.69762C9.4562 5.69762 9.19361 5.80639 9 6C8.80639 6.19361 8.69762 6.4562 8.69762 6.73C8.69762 7.0038 8.80639 7.26639 9 7.46L11.29 9.71ZM19 15C19 14.8022 18.9414 14.6089 18.8315 14.4444C18.7216 14.28 18.5654 14.1518 18.3827 14.0761C18.2 14.0004 17.9989 13.9806 17.8049 14.0192C17.6109 14.0578 17.4327 14.153 17.2929 14.2929C17.153 14.4327 17.0578 14.6109 17.0192 14.8049C16.9806 14.9989 17.0004 15.2 17.0761 15.3827C17.1518 15.5654 17.28 15.7216 17.4444 15.8315C17.6089 15.9414 17.8022 16 18 16C18.2652 16 18.5196 15.8946 18.7071 15.7071C18.8946 15.5196 19 15.2652 19 15ZM20 8L17 8C16.7348 8 16.4804 8.10536 16.2929 8.29289C16.1054 8.48043 16 8.73478 16 9C16 9.26522 16.1054 9.51957 16.2929 9.70711C16.4804 9.89464 16.7348 10 17 10L20 10C20.2652 10 20.5196 10.1054 20.7071 10.2929C20.8946 10.4804 21 10.7348 21 11L21 19C21 19.2652 20.8946 19.5196 20.7071 19.7071C20.5196 19.8946 20.2652 20 20 20L4 20C3.73478 20 3.48043 19.8946 3.29289 19.7071C3.10536 19.5196 3 19.2652 3 19L3 11C3 10.7348 3.10536 10.4804 3.29289 10.2929C3.48043 10.1054 3.73478 10 4 10H7C7.26522 10 7.51957 9.89464 7.70711 9.70711C7.89464 9.51957 8 9.26522 8 9C8 8.73478 7.89464 8.48043 7.70711 8.29289C7.51957 8.10536 7.26522 8 7 8L4 8C3.20435 8 2.44129 8.31607 1.87868 8.87868C1.31607 9.44129 1 10.2044 1 11L1 19C1 19.7956 1.31607 20.5587 1.87868 21.1213C2.44129 21.6839 3.20435 22 4 22L20 22C20.7956 22 21.5587 21.6839 22.1213 21.1213C22.6839 20.5587 23 19.7956 23 19L23 11C23 10.2044 22.6839 9.44129 22.1213 8.87868C21.5587 8.31607 20.7956 8 20 8ZM5 15C5 15.1978 5.05865 15.3911 5.16853 15.5556C5.27841 15.72 5.43459 15.8482 5.61732 15.9239C5.80004 15.9996 6.00111 16.0194 6.19509 15.9808C6.38907 15.9422 6.56725 15.847 6.70711 15.7071C6.84696 15.5673 6.9422 15.3891 6.98079 15.1951C7.01937 15.0011 6.99957 14.8 6.92388 14.6173C6.84819 14.4346 6.72002 14.2784 6.55557 14.1685C6.39112 14.0586 6.19778 14 6 14C5.73478 14 5.48043 14.1054 5.29289 14.2929C5.10536 14.4804 5 14.7348 5 15Z" fill="white"/>
                                    </svg>
                                </div>
                                <div class="cabinetTopInfo">
                                    <p class="cabinetTopName">Доступно на вывод</p>
                                    <p class="cabinetTopCount">{{ Auth::user()->UserInfo->balance; }} rub.</p>
                                </div>
                            </div>
                        </div>
                        @if ( $matrix != null )
                            <a href="#" class="cabinetBigItem popupBtn martixBuyer" data-popup="starter" data-matrix-id="2">Начать заработок</a>
                        @else
                            <a href="{{ route('start') }}" class="cabinetBigItem">Начать заработок</a>
                        @endif
                    </div>
                </div>
                <div class="matrixTabs cabinetTabs">
                    <div class="matrixTab active" data-matrix="1" data-matrix-url="{{ route('getmatrix', ['id'=>Auth::user()->id, 'lvl'=>1] ) }}">М#1</div>
                    <div class="matrixTab{{$disabled}}" title="Матрица не активна" data-matrix="2" data-matrix-url="{{ route('getmatrix', ['id'=>Auth::user()->id, 'lvl'=>2] ) }}">М#2</div>
                    <div class="matrixTab{{$disabled}}" title="Матрица не активна" data-matrix="3" data-matrix-url="{{ route('getmatrix', ['id'=>Auth::user()->id, 'lvl'=>3] ) }}">М#3</div>
                    <div class="matrixTab{{$disabled}}" title="Матрица не активна" data-matrix="4" data-matrix-url="{{ route('getmatrix', ['id'=>Auth::user()->id, 'lvl'=>4] ) }}">М#4</div>
                    <div class="matrixTab{{$disabled}}" title="Матрица не активна" data-matrix="5" data-matrix-url="{{ route('getmatrix', ['id'=>Auth::user()->id, 'lvl'=>5] ) }}">М#5</div>
                    <div class="matrixTab{{$disabled}}" title="Матрица не активна" data-matrix="6" data-matrix-url="{{ route('getmatrix', ['id'=>Auth::user()->id, 'lvl'=>6] ) }}">М#6</div>
                    <div class="matrixTab{{$disabled}}" title="Матрица не активна" data-matrix="7" data-matrix-url="{{ route('getmatrix', ['id'=>Auth::user()->id, 'lvl'=>7] ) }}">М#7</div>
                    <div class="matrixTab{{$disabled}}" title="Матрица не активна" data-matrix="8" data-matrix-url="{{ route('getmatrix', ['id'=>Auth::user()->id, 'lvl'=>8] ) }}">М#8</div>
                    <div class="matrixTab{{$disabled}}" title="Матрица не активна" data-matrix="9" data-matrix-url="{{ route('getmatrix', ['id'=>Auth::user()->id, 'lvl'=>9] ) }}">М#9</div>
                </div>
                <div class="mainContainerMatrix">
                    @if ( $matrix != null)
                        @if ($matrix->matrix_id != null )
                            {{-- Если у пользователя кто-то запустил матрицу --}}
                                @php
                                    $active = '';
                                    if( $matrix->matrix_lvl == 1 ){
                                        $active = ' active';
                                    }
                                @endphp
                                <div class="matrixElement{{$active}}" data-matrix="{{ $matrix->matrix_lvl }}">
                                    @php
                                        $neeedly = 2;
                                    @endphp
                                    @for ($i = 1; $i < 8; $i++)
                                        @php
                                            $activeCabMatrix = '';
                                            $lineMatrix = $matrixInfos->where('line', $i);
                                            $lineMatrixCounter = $lineMatrix->count();
                                            $stringI = array(
                                                'первого',
                                                'второго',
                                                'третьего',
                                                'четвёртого',
                                                'пятого',
                                                'шестого',
                                                'седьмого',
                                            );
                                            if( $lineMatrixCounter > 0 ){
                                                $activeCabMatrix = ' active';
                                            }
                                        @endphp
                                        <div class="cabMatrixElement{{$activeCabMatrix}}">
                                            <h3 class="cabMatrixName">Партнеры {{ $stringI[$i-1] }} уровня <span>( {{ $lineMatrixCounter }} )</span></h3>
                                            <p class="cabMatrixDesc">Необходимое количество участников в каждом плече для закрытия уровня - {{ $neeedly }}</p>
                                            <div class="matrixFlex displayFlex spaceBetween">
                                                <div class="cabMatrixItem">
                                                    <p class="cabMatrixItemName">
                                                        Левое плечо
                                                        <span>
                                                            @php
                                                                $leftCount = $lineMatrix->where('shoulder', 0)->count();
                                                            @endphp
                                                            ({{ $leftCount }})
                                                        </span>
                                                    </p>
                                                    <div class="matrixLine displayFlex spaceBetween">
                                                        @php
                                                            $lineLeft = $lineMatrix->where('shoulder', 0);
                                                        @endphp
                                                        @foreach ($lineLeft as $matrixInfo)
                                                            <div class="matrixLineItem">
                                                                <div class="pageUserAvatar">
                                                                    @if ($matrixInfo->avatar != '')
                                                                        <img style="width: 100%" src="{{ Storage::url($matrixInfo->avatar) }}" alt="avatar">
                                                                    @endif
                                                                </div>
                                                                <div class="pageTableItemInfo">
                                                                    <p class="pageTableUsername">
                                                                        @if ($matrixInfo->user_name != null)
                                                                            {{ $matrixInfo->user_name }} <span style="font-size: 12px;">({{ $matrixInfo->login }})</span>
                                                                        @else
                                                                            {{ $matrixInfo->login }}
                                                                        @endif
                                                                    </p>
                                                                    <p class="pageTableDate">{{$matrixInfo->email}}</p>
                                                                </div>
                                                                <p class="matrixAddDate">{{ date("d.m.Y", strtotime( $matrixInfo->created_at )) }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="cabMatrixItem">
                                                    <p class="cabMatrixItemName">
                                                        Правое плечо
                                                        <span>
                                                            @php
                                                                $rightCount = $lineMatrix->where('shoulder', 1)->count();
                                                            @endphp
                                                            ({{ $rightCount }})
                                                        </span>
                                                    </p>
                                                    <div class="matrixLine displayFlex spaceBetween">
                                                        @php
                                                            $lineRight = $lineMatrix->where('shoulder', 1);
                                                        @endphp
                                                        @foreach ($lineRight as $matrixInfo)
                                                            <div class="matrixLineItem">
                                                                <div class="pageUserAvatar">
                                                                    @if ($matrixInfo->avatar != '')
                                                                        <img style="width: 100%" src="{{ Storage::url($matrixInfo->avatar) }}" alt="avatar">
                                                                    @endif
                                                                </div>
                                                                <div class="pageTableItemInfo">
                                                                    <p class="pageTableUsername">
                                                                        @if ($matrixInfo->user_name != null)
                                                                            {{ $matrixInfo->user_name }} <span style="font-size: 12px;">({{ $matrixInfo->login }})</span>
                                                                        @else
                                                                            {{ $matrixInfo->login }}
                                                                        @endif
                                                                    </p>
                                                                    <p class="pageTableDate">{{$matrixInfo->email}}</p>
                                                                </div>
                                                                <p class="matrixAddDate">{{ date("d.m.Y", strtotime( $matrixInfo->created_at )) }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $neeedly *= 2;
                                        @endphp
                                    @endfor
                                </div>
                        @else
                            {{-- Если у пользователя нет активных людей в матрице --}}
                                <div class="matrixElement active" data-matrix="1">
                                    <div class="cabMatrixElement active">
                                        <h3 class="cabMatrixName">Первый уровень успешно активирован!</h3>
                                        <p class="cabMatrixDesc">Приглашайте людей по реферальной ссылке и начинайте зарабатывать!</p>
                                    </div>
                                </div>
                        @endif
                    @else
                        {{-- Пользователь ещё не пополнился --}}
                            <div class="matrixElement active" data-matrix="1">
                                <div class="cabMatrixElement active">
                                    <h3 class="cabMatrixName">Вы ещё не активировали Ваш кабинет!</h3>
                                    <p class="cabMatrixDesc">Пополните первый уровень матрицы для начала заработка!</p>
                                </div>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
