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
            <div class="matrixElement active" data-matrix="{{ $matrix->matrix_lvl }}">
                <div class="cabMatrixElement active">
                    @php
                        $arrayNamesMatrix = array('Второй', 'Третий', 'Четвёртый', 'Пятый', 'Шестой', 'Седьмой', 'Восьмой', 'Девятый');
                        $titleMatrix = $arrayNamesMatrix[$matrix->matrix_lvl - 2];
                    @endphp
                    <h3 class="cabMatrixName">{{ $titleMatrix }} уровень успешно активирован!</h3>
                    <p class="cabMatrixDesc">Приглашайте людей по реферальной ссылке и начинайте зарабатывать!</p>
                </div>
            </div>
    @endif
@else
    {{-- Пользователь ещё не пополнился --}}
        <div class="matrixElement active" data-matrix="1">
            <div class="cabMatrixElement active">
                <h3 class="cabMatrixName">Вы ещё не активировали данный уровень!</h3>
                <p class="cabMatrixDesc">Нажмите начать заработок если хотите активировать уровень матрицы!</p>
            </div>
        </div>
@endif
