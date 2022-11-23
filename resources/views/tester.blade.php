@php

    // Данные для проверки
    $matrix_lvl = 1;


    // Заменить 10 на $user['id']
    $user = DB::table('users')->where('id', 45 )->first();

    // Проверяем есть ли у нас матрица

    $myMatrix = DB::table('matrix')->where([
                    ['user_id', '=', $user->id],
                    ['matrix_lvl', '=', $matrix_lvl],
                ])->first();

    if ( !$myMatrix ) {

        DB::table('matrix')->insert([
            'user_id' => $user->id,
            'matrix_lvl' => $matrix_lvl,
            'matrix_active' => 1,
            // 'created_at' => Carbon::now(),
            // 'updated_at' => Carbon::now()
        ]);

        // Обновляем статус активации

        DB::table('user_infos')->where([
            ['user_id', '=', $user->id],
        ])->update(['activated' => 1]);

    }

    // Берём спонсора и проверяем есть ли у него матрица
    $sp = $user->sponsor;

    $lineG = array(4, 8, 16, 32, 64, 128, 256);

    $spmatrix = DB::table('matrix')->where([
                ['user_id', '=', $sp],
                ['matrix_lvl', '=', $matrix_lvl],
            ])->first();

    if( $spmatrix ){
        // Берём id активной матрицы
        $spmid = $spmatrix->matrix_id;

        if( $spmid ){
            $matrix_id = $spmid;

            for ($i=1; $i <= 7; $i++) {
                $line = $i;
                echo '----- Итерация # ' . $i . ' -----';
                echo '<br>';

                $current_line = $i;

                $spmplacer = DB::table('matrix_placers')->where([
                    ['matrix_id', '=', $matrix_id],
                    ['line', '=', $i],
                ])->orWhere([
                    ['referer_id', '=', $matrix_id],
                    ['referer_line', '=', $i],
                ])->get();

                $spmplacerCounter = $spmplacer->count();

                if( $i > 1 ){
                    $spmplacerCounter = 0;

                    $prevLine = DB::table('matrix_placers')->where([
                        ['matrix_id', '=', $matrix_id],
                        ['line', '=', $i - 1],
                    ])->orWhere([
                        ['referer_id', '=', $matrix_id],
                        ['referer_line', '=', $i - 1],
                    ])->get();

                    echo 'Людей на прошлой линии: '.$prevLine->count();
                    echo '<br>';

                    for ($o=0; $o < $prevLine->count(); $o++) {
                        $prevLineUser = $prevLine[$o];

                        $UsMatrix = DB::table('matrix')->where([
                                        ['user_id', '=', $prevLineUser->user_id],
                                        ['matrix_lvl', '=', $matrix_lvl],
                                    ])->first();

                        $prevMatrixId = $UsMatrix->matrix_id;

                        if( $prevMatrixId != null ){
                            $prevMatrixPlacer = DB::table('matrix_placers')->where([
                                ['matrix_id', '=', $prevMatrixId],
                                ['line', '=', $i-1],
                            ])->orWhere([
                                ['referer_id', '=', $prevMatrixId],
                                ['referer_line', '=', $i-1],
                            ])->get();

                            if( $prevMatrixPlacer->count() == 1 ){
                                $spmplacerCounter = $spmplacerCounter + 1;

                                echo 'У пользователя '. $prevLineUser->user_id . ' на линии ' . $prevMatrixPlacer->count() . ' человек';
                                echo '<br>';

                            }elseif ( $prevMatrixPlacer->count() >= 2 ) {
                                $spmplacerCounter = $spmplacerCounter + 2;

                                echo 'У пользователя '. $prevLineUser->user_id . ' на линии более 2-ух человек';
                                echo '<br>';
                            }

                        }

                    }

                }


                if( $spmplacerCounter == $lineG[$i-1] ){
                    echo 'Линяя ' . $i . ' занята';
                    echo '<br>';
                }else{

                    echo 'Свободна '.$i.' линяя';
                    echo '<br>';
                    echo 'Людей на линии: ' . $spmplacerCounter;
                    echo '<br>';

                    if( $i != 1 ){

                        for ($uplace=($spmplacerCounter + 1); $uplace <= $lineG[$i-1]; $uplace++) {

                            echo '==== Проверка позиции: ' . $uplace . ' ====';
                            echo '<br>';

                            $rpos = 1;

                            for ($n=1; $n <= $uplace; $n++) {
                                if ( ($n - 1) % 2 == 0  && $n-1 != 0 ){
                                    $rpos++;
                                }
                            }

                            echo 'Позиция вышестоящего: ' . $rpos;
                            echo '<br>';

                            $refmplacer = DB::table('matrix_placers')->where([
                                ['matrix_id', '=', $matrix_id],
                                ['line', '=', $i-1],
                                ['user_place', '=', $rpos],
                            ])->orWhere([
                                ['referer_id', '=', $matrix_id],
                                ['referer_line', '=', $i-1],
                                ['referer_place', '=', $rpos],
                            ])->first();

                            dd($refmplacer);

                            exit;

                            $ruser_id = $refmplacer->user_id;

                            $refmatrix = DB::table('matrix')->where([
                                ['user_id', '=', $ruser_id],
                                ['matrix_lvl', '=', $matrix_lvl],
                            ])->first();

                            if( $refmatrix->matrix_id == null ){
                                echo 'Обновили данные матрицы';
                                echo '<br>';

                                $newMatrixID = DB::table('matrix_placers')->count()+1;

                                DB::table('matrix')->where([
                                    ['user_id', '=', $ruser_id],
                                    ['matrix_lvl', '=', $matrix_lvl],
                                ])->update(['matrix_id' => $newMatrixID]);
                            }

                            if( $refmatrix ){
                                $referer_id = $refmatrix->matrix_id;

                                $rmplacer = DB::table('matrix_placers')->where([
                                    ['matrix_id', '=', $referer_id],
                                    ['line', '=', 1],
                                    ['shoulder', '=', 0],
                                ])->orWhere([
                                    ['referer_id', '=', $referer_id],
                                    ['referer_line', '=', 1],
                                    ['referer_shoulder', '=', 0],
                                ])->get();


                                if( $rmplacer->count() >= 2 ){
                                    echo 'Тут нельзя';
                                    echo '<br>';
                                }else{

                                    $myRpos = $rmplacer->count() + 1;

                                    echo 'Можем разместиться';
                                    echo '<br>';
                                    echo 'Матрица вышестоящего: ' . $referer_id;
                                    echo '<br>';
                                    echo 'Наша в ней позиция: '.$myRpos;
                                    echo '<br>';

                                    $refposs = $myRpos;

                                    break;
                                }
                            }else{
                                // У вышестоящего ещё не активирована матрица

                                $newMatrixID = DB::table('matrix_placers')->count()+1;

                                DB::table('matrix')->insert([
                                    'user_id' => $ruser_id,
                                    'matrix_lvl' => $matrix_lvl,
                                    'matrix_active' => 1,
                                    'matrix_id' => $newMatrixID,
                                    // 'created_at' => Carbon::now(),
                                    // 'updated_at' => Carbon::now()
                                ]);

                                $refposs = 1;
                                $referer_id = $newMatrixID;

                                echo 'Создали матрицу вышестоящему';
                                echo '<br>';

                                break;
                            }

                        }

                    }else{
                        // Нет вышестоящего кроме спонсора
                        $uplace = $spmplacerCounter + 1;
                        $referer_id = null;
                        $refposs = $uplace;
                    }

                    break;

                }

            }

            // exit;

            $line_pay = 0;
            $line_reinv = 0;

            // Нужно ли двать деньги

            if( $uplace == $lineG[$current_line - 1] ){
                if( $matrix_lvl == 1 ){
                    switch ($current_line) {
                        case 1:
                            $line_pay = 4000;
                            $line_bonus = 0;
                            break;
                        case 2:
                            $line_pay = 3000;
                            $line_bonus = 5000;
                            break;
                        case 3:
                            $line_pay = 11000;
                            $line_bonus = 5000;
                            break;
                        case 4:
                            $line_pay = 27000;
                            $line_bonus = 5000;
                            break;
                        case 5:
                            $line_pay = 59000;
                            $line_bonus = 5000;
                            break;
                        case 6:
                            $line_pay = 123000;
                            $line_bonus = 5000;
                            break;
                        case 7:
                            $line_pay = 246000;
                            $line_bonus = 10000;
                            break;
                    }
                }elseif ( $matrix_lvl == 2 ) {
                    switch ($current_line) {
                        case 1:
                            $line_pay = 20000;
                            $line_bonus = 0;
                            break;
                        case 2:
                            $line_pay = 30000;
                            $line_bonus = 10000;
                            break;
                        case 3:
                            $line_pay = 70000;
                            $line_bonus = 10000;
                            break;
                        case 4:
                            $line_pay = 150000;
                            $line_bonus = 10000;
                            break;
                        case 5:
                            $line_pay = 310000;
                            $line_bonus = 10000;
                            break;
                        case 6:
                            $line_pay = 640000;
                            $line_bonus = 10000;
                            break;
                        case 7:
                            $line_pay = 1260000;
                            $line_bonus = 20000;
                            break;
                    }
                }elseif ( $matrix_lvl == 3 ) {
                    switch ($current_line) {
                        case 1:
                            $line_pay = 40000;
                            $line_bonus = 0;
                            break;
                        case 2:
                            $line_pay = 55000;
                            $line_bonus = 25000;
                            break;
                        case 3:
                            $line_pay = 135000;
                            $line_bonus = 25000;
                            break;
                        case 4:
                            $line_pay = 295000;
                            $line_bonus = 25000;
                            break;
                        case 5:
                            $line_pay = 615000;
                            $line_bonus = 25000;
                            break;
                        case 6:
                            $line_pay = 1255000;
                            $line_bonus = 25000;
                            break;
                        case 7:
                            $line_pay = 2510000;
                            $line_bonus = 50000;
                            break;
                    }
                }elseif ( $matrix_lvl == 4 ) {
                    switch ($current_line) {
                        case 1:
                            $line_pay = 50000;
                            $line_bonus = 50000;
                            break;
                        case 2:
                            $line_pay = 15000;
                            $line_bonus = 50000;
                            break;
                        case 3:
                            $line_pay = 350000;
                            $line_bonus = 50000;
                            break;
                        case 4:
                            $line_pay = 750000;
                            $line_bonus = 50000;
                            break;
                        case 5:
                            $line_pay = 1550000;
                            $line_bonus = 50000;
                            break;
                        case 6:
                            $line_pay = 3150000;
                            $line_bonus = 50000;
                            break;
                        case 7:
                            $line_pay = 6350000;
                            $line_bonus = 50000;
                            break;
                    }
                }elseif ( $matrix_lvl == 5 ) {
                    switch ($current_line) {
                        case 1:
                            $line_pay = 50000;
                            $line_bonus = 100000;
                            $line_reinv = 50000;
                            break;
                        case 2:
                            $line_pay = 250000;
                            $line_bonus = 100000;
                            $line_reinv = 50000;
                            break;
                        case 3:
                            $line_pay = 650000;
                            $line_bonus = 100000;
                            $line_reinv = 50000;
                            break;
                        case 4:
                            $line_pay = 1450000;
                            $line_bonus = 100000;
                            $line_reinv = 50000;
                            break;
                        case 5:
                            $line_pay = 3050000;
                            $line_bonus = 100000;
                            $line_reinv = 50000;
                            break;
                        case 6:
                            $line_pay = 6250000;
                            $line_bonus = 100000;
                            $line_reinv = 50000;
                            break;
                        case 7:
                            $line_pay = 12650000;
                            $line_bonus = 100000;
                            $line_reinv = 50000;
                            break;
                    }
                }elseif ( $matrix_lvl == 6 ) {
                    switch ($current_line) {
                        case 1:
                            $line_pay = 150000;
                            $line_bonus = 250000;
                            break;
                        case 2:
                            $line_pay = 350000;
                            $line_bonus = 250000;
                            $line_reinv = 200000;
                            break;
                        case 3:
                            $line_pay = 1250000;
                            $line_bonus = 250000;
                            $line_reinv = 100000;
                            break;
                        case 4:
                            $line_pay = 2850000;
                            $line_bonus = 250000;
                            $line_reinv = 100000;
                            break;
                        case 5:
                            $line_pay = 6050000;
                            $line_bonus = 250000;
                            $line_reinv = 100000;
                            break;
                        case 6:
                            $line_pay = 12450000;
                            $line_bonus = 250000;
                            $line_reinv = 100000;
                            break;
                        case 7:
                            $line_pay = 25250000;
                            $line_bonus = 250000;
                            $line_reinv = 100000;
                            break;
                    }
                }elseif ( $matrix_lvl == 7 ) {
                    switch ($current_line) {
                        case 1:
                            $line_pay = 500000;
                            $line_bonus = 500000;
                            $line_reinv = 250000;
                            break;
                        case 2:
                            $line_pay = 1250000;
                            $line_bonus = 500000;
                            $line_reinv = 250000;
                            break;
                        case 3:
                            $line_pay = 3250000;
                            $line_bonus = 500000;
                            $line_reinv = 250000;
                            break;
                        case 4:
                            $line_pay = 7250000;
                            $line_bonus = 500000;
                            $line_reinv = 250000;
                            break;
                        case 5:
                            $line_pay = 15250000;
                            $line_bonus = 500000;
                            $line_reinv = 250000;
                            break;
                        case 6:
                            $line_pay = 31250000;
                            $line_bonus = 500000;
                            $line_reinv = 250000;
                            break;
                        case 7:
                            $line_pay = 63250000;
                            $line_bonus = 500000;
                            $line_reinv = 250000;
                            break;
                    }
                }elseif ( $matrix_lvl == 8 ) {
                    switch ($current_line) {
                        case 1:
                            $line_pay = 500000;
                            $line_bonus = 1000000;
                            $line_reinv = 500000;
                            break;
                        case 2:
                            $line_pay = 2500000;
                            $line_bonus = 1000000;
                            $line_reinv = 500000;
                            break;
                        case 3:
                            $line_pay = 6500000;
                            $line_bonus = 1000000;
                            $line_reinv = 500000;
                            break;
                        case 4:
                            $line_pay = 14500000;
                            $line_bonus = 1000000;
                            $line_reinv = 500000;
                            break;
                        case 5:
                            $line_pay = 30500000;
                            $line_bonus = 1000000;
                            $line_reinv = 500000;
                            break;
                        case 6:
                            $line_pay = 62500000;
                            $line_bonus = 1000000;
                            $line_reinv = 500000;
                            break;
                        case 7:
                            $line_pay = 126500000;
                            $line_bonus = 1000000;
                            $line_reinv = 500000;
                            break;
                    }
                }elseif ( $matrix_lvl == 9 ) {
                    switch ($current_line) {
                        case 1:
                            $line_pay = 3000000;
                            $line_reinv = 1000000;
                            break;
                        case 2:
                            $line_pay = 7000000;
                            $line_reinv = 1000000;
                            break;
                        case 3:
                            $line_pay = 15000000;
                            $line_reinv = 1000000;
                            break;
                        case 4:
                            $line_pay = 31000000;
                            $line_reinv = 1000000;
                            break;
                        case 5:
                            $line_pay = 63000000;
                            $line_reinv = 1000000;
                            break;
                        case 6:
                            $line_pay = 127000000;
                            $line_reinv = 1000000;
                            break;
                        case 7:
                            $line_pay = 255000000;
                            $line_reinv = 1000000;
                            break;
                    }
                }
            }

            if( $line_pay != 0 ){
                // Тут даём деньги спонсору и открываем новую матрицу
                echo 'Даём деньги '. $sp .' в сумме '. $line_pay;

                // Деньги

                DB::table('user_infos')->where([
                    ['user_id', '=', $sp],
                ])->increment('balance', $line_pay);

                // Наши деньги

                DB::table('user_infos')->where([
                    ['user_id', '=', $sp],
                ])->increment('alter_balance', $line_bonus);

                // Всего заработанно

                DB::table('user_infos')->where([
                    ['user_id', '=', $sp],
                ])->increment('earned', $line_pay);

                if( $line_reinv == 0 ){

                    $spNewMatrix = DB::table('matrix')->where([
                        ['user_id', '=', $sp],
                        ['matrix_lvl', '=', $matrix_lvl+1],
                    ])->first();

                    if ( !$spNewMatrix ) {
                        DB::table('matrix')->insert([
                            'user_id' => $sp,
                            'matrix_lvl' => $matrix_lvl+1,
                            'matrix_active' => 1,
                            // 'created_at' => Carbon::now(),
                            // 'updated_at' => Carbon::now()
                        ]);
                    }

                }else{

                    $spNewMatrix = DB::table('matrix')->where([
                            ['user_id', '=', $sp],
                            ['matrix_lvl', '=', $matrix_lvl+0.5],
                        ])->first();

                    if ( !$spNewMatrix ) {
                        DB::table('matrix')->insert([
                            'user_id' => $sp,
                            'matrix_lvl' => $matrix_lvl+0.5,
                            'matrix_active' => 1,
                            // 'created_at' => Carbon::now(),
                            // 'updated_at' => Carbon::now()
                        ]);
                    }
                }

                // Ставим его снова под спонсора



            }

            $shoulderG = array(2, 4, 8, 16, 32, 64, 128);

            // $shoulderG = array(2, 8, 20, 44, 92, 188, 380);
            // $lineG = array(4, 12, 28, 60, 124, 252, 508);
            // echo $line;
            // exit();
            // $line = 0;
            $newPlace = $uplace;
            // $maxLine = 7;

            // if ($line == 0) {
            //     $crew = 0;
            // }else{
            //     $crew = $line - 1;
            // }

            // for ($l=0; $l <= $maxLine ; $l++) {
            //     if($newPlace <= $lineG[$crew]){
            //         $line = $l + 1;
            //         break;
            //     }
            //     $crew++;
            // }

            if ($newPlace > $shoulderG[$line-1/*$crew*/]) {
                $shoulder = 1;
            }else{
                $shoulder = 0;
            }

            $referer_shoulder = 0;
            $referer_line = 1;

            DB::table('matrix_placers')->insert([
                'matrix_id' => $matrix_id,
                'referer_id' => $referer_id,
                'shoulder' => $shoulder,
                'referer_shoulder' => $referer_shoulder,
                'line' => $current_line,
                'referer_line' => $referer_line,
                'user_id' => $user->id,
                'user_place' => $uplace,
                'referer_place' => $refposs,
                // 'created_at' => Carbon::now(),
                // 'updated_at' => Carbon::now()
            ]);

        }else{
            // У спонсора новая матрица, у которой нет ID
            // Встаём к нему первыми

            $newMatrixID = DB::table('matrix_placers')->count()+1;

            DB::table('matrix_placers')->insert([
                'matrix_id' => $newMatrixID,
                'referer_id' => null,
                'shoulder' => 0,
                'referer_shoulder' => 0,
                'line' => 1,
                'referer_line' => 1,
                'user_id' => $user->id,
                'user_place' => 1,
                'referer_place' => 1,
                // 'created_at' => Carbon::now(),
                // 'updated_at' => Carbon::now()
            ]);

            // Добавляем спонсору созданную матрицу

            DB::table('matrix')->where([
                ['user_id', '=', $sp],
                ['matrix_lvl', '=', $matrix_lvl],
            ])->update(['matrix_id' => $newMatrixID]);

            // После создаём свою матрицу

            $myMatrix = DB::table('matrix')->where([
                    ['user_id', '=', $user->id],
                    ['matrix_lvl', '=', $matrix_lvl],
                ])->first();

            if ( !$myMatrix ) {

                DB::table('matrix')->insert([
                    'user_id' => $user->id,
                    'matrix_lvl' => $matrix_lvl,
                    'matrix_active' => 1,
                    // 'created_at' => Carbon::now(),
                    // 'updated_at' => Carbon::now()
                ]);

                // Обновляем статус активации

                DB::table('user_infos')->where([
                    ['user_id', '=', $user->id],
                ])->update(['activated' => 1]);

            }

        }

    }else{
        // У спонсора нет активной матрицы
        $myMatrix = DB::table('matrix')->where([
                ['user_id', '=', $user->id],
                ['matrix_lvl', '=', $matrix_lvl],
            ])->first();

        if ( !$myMatrix ) {

            // У нас тоже нет активной матрицы этого уровня
            // Создаём матрицу и обновляем статус активации

            DB::table('matrix')->insert([
                'user_id' => $user->id,
                'matrix_lvl' => $matrix_lvl,
                'matrix_active' => 1,
                // 'created_at' => Carbon::now(),
                // 'updated_at' => Carbon::now()
            ]);

            DB::table('user_infos')->where([
                ['user_id', '=', $user->id],
            ])->update(['activated' => 1]);
        }
    }

@endphp
