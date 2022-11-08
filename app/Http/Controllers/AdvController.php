<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvController extends Controller
{
    public function payed(Request $request){
        return view('account.adv.payed');
    }

    public function fail(Request $request){
        return view('account.adv.fail');
    }

    public function pay(Request $request){
        $m_orderid = Auth::user()->id;

        $form = '<form method="post" action="https://wallet.advcash.com/sci/">
                    <input type="hidden" name="ac_account_email" value="fortune-time@yandex.ru" />
                    <input type="hidden" name="ac_sci_name" value="Fortune-time" />
                    <input type="text" name="ac_amount" value="'.$request->oa.'" />
                    <input type="text" name="ac_currency" value="RUB" />
                    <input type="text" name="ac_order_id" value="'.$m_orderid.'" />
                    <input type="text" name="ac_sign" value="a45b20f2c8dd5bde1a43a9aa5806a1fe939257cb6d68949bd0eba617ce72e65f" />
                    <input type="submit" />
                </form>';

        return $form;
    }

}
