@php
    // Данные для проверки
    $matrix_lvl = 1;


    // Заменить 10 на $user['id']
    $user = DB::table('users')->where('id', 18)->first();

    // Берём спонсора и проверяем есть ли у него матрица
    $sp = $user->sponsor;

    $lineG = array(4, 12, 28, 60, 124, 252, 508);

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

                if( $spmplacer->count() == $lineG[$i-1] ){
                    echo 'Линяя ' . $i . ' занята';
                    echo '<br>';
                }else{

                    echo 'Свободна '.$i.' линяя';
                    echo '<br>';
                    echo 'Людей на линии: ' . $spmplacer->count();
                    echo '<br>';

                    for ($uplace=($spmplacer->count() + 1); $uplace < $lineG[$i-1]; $uplace++) {

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

                        $ruser_id = $refmplacer->user_id;

                        $refmatrix = DB::table('matrix')->where([
                            ['user_id', '=', $ruser_id],
                            ['matrix_lvl', '=', $matrix_lvl],
                        ])->first();

                        if( $refmatrix ){
                            $referer_id = $refmatrix->matrix_id;

                            $rmplacer = DB::table('matrix_placers')->where([
                                ['matrix_id', '=', $referer_id],
                                ['line', '=', 1],
                                ['shoulder', '=', 0],
                            ])->orWhere([
                                ['referer_id', '=', $referer_id],
                                ['referer_line', '=', 1],
                                ['shoulder', '=', 0],
                            ])->get();


                            if( $rmplacer->count() >= 2 ){
                                echo 'Тут нельзя';
                                echo '<br>';
                            }else{
                                echo 'Можем разместиться';
                                echo '<br>';
                                echo 'Матрица вышестоящего: ' . $referer_id;
                                break;
                            }
                        }

                    }

                    break;

                }

            }

            $line_pay = 0;
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

            echo '<br>';
            echo $line_pay;
            // echo $current_line;

        }else{
            // У спонсора новая матрица, у которой нет ID
            // Встаём к нему первыми

            $countMatrixPlacerLines = DB::table('matrix_placers')->count();

            echo $countMatrixPlacerLines;

            exit();

            DB::table('matrix_placers')->insert([
                'matrix_id' => $user->id,
                'referer_id' => $matrix_lvl,
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
            // Создаём матрицу

            DB::table('matrix')->insert([
                'user_id' => $user->id,
                'matrix_lvl' => $matrix_lvl,
                'matrix_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }

@endphp