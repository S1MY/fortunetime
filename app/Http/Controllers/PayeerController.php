<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayeerController extends Controller
{
    public function pay(Request $request){
        $m_shop = '1770985667';
        $m_orderid = Auth::user()->id;
        $m_amount = number_format($request->oa, 2, '.', '');
        $m_curr = 'RUB';
        $m_desc = base64_encode('Оплата одного из уровня маркетинга на проекте Fortune Time!');
        $m_key = 'DAJ12VfyfWmzQ5mu';

        $arHash = array(
            $m_shop,
            $m_orderid,
            $m_amount,
            $m_curr,
            $m_desc
        );

        $arHash[] = $m_key;

        $sign = strtoupper(hash('sha256', implode(':', $arHash)));
        $form = '<form method="post" action="https://payeer.com/merchant/">
                    <input type="hidden" name="m_shop" value="'.$m_shop.'">
                    <input type="hidden" name="m_orderid" value="'.$m_orderid.'">
                    <input type="hidden" name="m_amount" value="'.$m_amount.'">
                    <input type="hidden" name="m_curr" value="'.$m_curr.'">
                    <input type="hidden" name="m_desc" value="'.$m_desc.'">
                    <input type="hidden" name="m_sign" value="'.$sign.'">
                    <input type="submit" name="m_process" value="send" />
                </form>';

        return $form;
    }

    public function payed(Request $request){
        return view('account.payeer.fail');
    }
    public function fail(Request $request){
        return view('account.payeer.fail');
    }
}
