<?php

namespace App\Http\Controllers;

use App\Models\Freekassa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreekassaController extends Controller
{
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

        return 'https://pay.freekassa.ru/?m='.$merchant_id.'&'.$order_amount.'&'.$currency.'&'.$order_id.'&'.$s;
    }
}
