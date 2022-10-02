<?php

namespace App\Http\Controllers;

use App\Models\Freekassa;
use App\Models\User;
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
            'created_at' => Carbon::now()
        ]);

        // Простановка в матрицу партнёра

        if( $user['sponsor'] != 0 ){

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

        session()->flash('success', 'Вы успешно активировалли первый уровень матрицы! На вашу почту была отправленна система!' );

        return redirect()->route('account');
    }
}
