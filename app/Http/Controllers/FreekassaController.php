<?php

namespace App\Http\Controllers;

use App\Models\Freekassa;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FreekassaController extends Controller
{
    public function freekassa(Request $request){

        function getIP() {
            if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
            return $_SERVER['REMOTE_ADDR'];
        }

        if (!in_array(getIP(), array('168.119.157.136', '168.119.60.227', '138.201.88.124', '178.154.197.79'))) die("hacking attempt!");

        // Меняем статус оплаты

        Freekassa::where('id', $request->MERCHANT_ORDER_ID)->update([
            'remoteADDR' => $_SERVER['REMOTE_ADDR'],
            'status' => 1,
        ]);

        // Берём пользователя и создаём запись в связующей таблице

        $fk_order = Freekassa::where('id', $request->MERCHANT_ORDER_ID)->first();
        $user = User::where('id', $fk_order['user_id'])->first();
        $userInfo = UserInfo::where('user_id', $fk_order['user_id'])->first();

        $amount = $fk_order['amount'];

        if( $amount == 1000 ){
            $matrix_lvl = 1;
        }else if( $amount == 5000 ){
            $matrix_lvl = 2;
        }else if( $amount == 10000 ){
            $matrix_lvl = 3;
        }else if( $amount == 25000 ){
            $matrix_lvl = 4;
        }else if( $amount == 50000 ){
            $matrix_lvl = 5;
        }else if( $amount == 100000 ){
            $matrix_lvl = 6;
        }else if( $amount == 250000 ){
            $matrix_lvl = 7;
        }else if( $amount == 500000 ){
            $matrix_lvl = 8;
        }else if( $amount == 1000000 ){
            $matrix_lvl = 9;
        }

        DB::table('matrix')->insert([
            'user_id' => $user['id'],
            'matrix_lvl' => $matrix_lvl,
            'matrix_active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if( $userInfo->activated == 0 ){
            UserInfo::where('user_id', $user['id'])->update([
                'activated' => 1,
            ]);
        }

                    // У спонсора уже есть активная матрица и приглашённые

                    // $lastUserInMatrix = DB::table('matrix_placers')->where('matrix_id', $SMartix->matrix_id)->orderByDesc('id')->first();

                    // $LUPlace = $lastUserInMatrix->user_place;

        // Простановка в матрицу партнёра

        if( $user['sponsor'] != 0 ){

            // Проверяем активировал ли спонсор свою матрицу
            $user = DB::table('users')->where('id', $user['id'])->first();

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

                    $uplace = 0;
                    $referer_id = 0;
                    $refposs = 0;

                    for ($i=1; $i <= 7; $i++) {

                        $current_line = $i;

                        $spmplacer = DB::table('matrix_placers')->where([
                            ['matrix_id', '=', $matrix_id],
                            ['line', '=', $i],
                        ])->orWhere([
                            ['referer_id', '=', $matrix_id],
                            ['referer_line', '=', $i],
                        ])->get();

                        if( $spmplacer->count() != $lineG[$i-1] ){

                            for ($uplace=($spmplacer->count() + 1); $uplace < $lineG[$i-1]; $uplace++) {

                                $rpos = 1;

                                for ($n=1; $n <= $uplace; $n++) {
                                    if ( ($n - 1) % 2 == 0  && $n-1 != 0 ){
                                        $rpos++;
                                    }
                                }

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


                                    if( $rmplacer->count() < 2 ){
                                        $refposs = $rmplacer->count() + 1;
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

                    $shoulderG = array(2, 8, 20, 44, 92, 188, 380);
                    $lineG = array(4, 12, 28, 60, 124, 252, 508);

                    $line = 0;
                    $newPlace = $uplace;
                    $maxLine = 7;

                    if ($line == 0) {
                        $crew = 0;
                    }else{
                        $crew = $line - 1;
                    }

                    for ($l=0; $l <= $maxLine ; $l++) {
                        if($newPlace <= $lineG[$crew]){
                            $line = $l + 1;
                            break;
                        }
                        $crew++;
                    }

                    if ($newPlace > $shoulderG[$crew]) {
                        $shoulder = 1;
                    }else{
                        $shoulder = 0;
                    }

                    $referer_shoulder = 0;
                    $referer_line = 1;

                    // $matrix_id - матрица спонсора
                    // $referer_id - матрица реферала
                    // $shoulder - плечо
                    // $referer_shoulder - плечо в  матрице реферала
                    // $current_line - линяя
                    // $referer_line - линяя в матрице реферала
                    // $uplace - позиция в матрице спонсора
                    // $refposs - позиция в матрице реферала

                    // $line_pay - нужно ли платить
                    // $line_reinv - будет ли реинвест
                    // $line_bonus - стоимость покупки некст пакета

                    DB::table('matrix_placers')->insert([
                        'matrix_id' => $matrix_id,
                        'referer_id' => $referer_id,
                        'shoulder' => $shoulder,
                        'referer_shoulder' => $referer_shoulder,
                        'line' => $current_line,
                        'referer_line' => $referer_line,
                        'user_id' => $user['id'],
                        'user_place' => $uplace,
                        'referer_place' => $refposs,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                }else{

                    // У спонсора уже есть активная матрица, но нет приглашённых ставим первого

                    DB::table('matrix_placers')->insert([
                        'user_id' => $user['id'],
                        'user_place' => 1,
                        'shoulder' => 0,
                        'line' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $matrixID = DB::getPdo()->lastInsertId();

                    DB::table('matrix_placers')->where('id', DB::getPdo()->lastInsertId())->update([
                        'matrix_id' => DB::getPdo()->lastInsertId(),
                    ]);

                    DB::table('matrix')->where([
                            ['user_id', $user['sponsor']],
                            ['matrix_lvl', $matrix_lvl],
                        ])->update([
                            'matrix_id' => $matrixID,
                        ]);

                }

            }else{
                echo 'Нет активной матрицы';
                echo '<br>';
            }

        }

    }

    public function pay(Request $request){
        $userID = Auth::user()->id;

        $merchant_id = '20918';
        $order_amount = $request['oa'];
        $secret_word = 'ONC^acH*>LRz>%Z';
        $currency = 'RUB';

        $order = Freekassa::create([
            'user_id' => $userID,
            'status' => 0,
            'amount' => $order_amount,
        ]);

        $order_id = $order->id;

        $s = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$currency.':'.$order_id);

        return 'https://pay.freekassa.ru/?m='.$merchant_id.'&oa='.$order_amount.'&currency='.$currency.'&o='.$order_id.'&s='.$s;
    }
    public function successful(Request $request){

        $fk_order = Freekassa::where('id', $request->MERCHANT_ORDER_ID)->first();
        $user = User::where('id', $fk_order['user_id'])->first();

        Auth::login($user);

        // Какой уровень активен

        $matrix = DB::table('matrix')->where([
            ['user_id', '=', $fk_order['user_id']],
        ])->orderBy('id', 'desc')->first();

        $arrayNamesMatrix = array('первый', 'второй', 'третий', 'четвёртый', 'пятый', 'шестой', 'седьмой', 'восьмой', 'девятый');
        $titleMatrix = $arrayNamesMatrix[$matrix->matrix_lvl - 1];

        if( $matrix->matrix_lvl != 1 ){
            session()->flash('success', 'Вы успешно активировали '.$titleMatrix.' уровень матрицы!');
        }else{
            session()->flash('success', 'Вы успешно активировали первый уровень матрицы! Теперь можете скачать систему на странице "Быстрый старт"!');
        }



        return redirect()->route('account');
    }
}
