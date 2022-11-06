<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayeerController extends Controller
{
    public function pay(Request $request){
        $m_shop = '1770985667';
        $m_orderid = '1';
        $m_amount = number_format($request->oa, 2, '.', '');
        $m_curr = 'RUB';
        $m_desc = base64_encode('Test');
        $m_key = 'DAJ12VfyfWmzQ5mu';

        $arHash = array(
            $m_shop,
            $m_orderid,
            $m_amount,
            $m_curr,
            $m_desc
        );

        /*
        $arParams = array(
            'success_url' => 'http://fortune-time.ru/new_success_url',
            'fail_url' => 'http://fortune-time.ru/new_fail_url',
            'status_url' => 'http://fortune-time.ru/new_status_url',
        );

        $key = md5('Ключ для шифрования дополнительных параметров'.$m_orderid);

        $m_params = @urlencode(base64_encode(openssl_encrypt(json_encode($arParams), 'AES-256-CBC', $key, OPENSSL_RAW_DATA)));

        $arHash[] = $m_params;
        */

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
}
