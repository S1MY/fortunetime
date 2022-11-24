<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayeerController extends Controller
{
    public function payeer(Request $request){
        if (!in_array($_SERVER['REMOTE_ADDR'], array('185.71.65.92', '185.71.65.189', '149.202.17.210'))) return;

        if (isset($request->m_operation_id) && isset($request->m_sign))
        {
            $m_key = 'DAJ12VfyfWmzQ5mu';

            $arHash = array(
                $request->m_operation_id,
                $request->m_operation_ps,
                $request->m_operation_date,
                $request->m_operation_pay_date,
                $request->m_shop,
                $request->m_orderid,
                $request->m_amount,
                $request->m_curr,
                $request->m_desc,
                $request->m_status
            );

            if (isset($request->m_params))
            {
                $arHash[] = $request->m_params;
            }

            $arHash[] = $m_key;

            $sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

            if ($request->m_sign == $sign_hash && $request->m_status == 'success')
            {
                DB::table('payeer')->insert([
                    'user_id' => $request->m_orderid,
                    'amount' => explode('.', $request->m_amount)[0],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                ob_end_clean(); exit($_POST['m_orderid'].'|success');

            }

            ob_end_clean(); exit($_POST['m_orderid'].'|error');
        }
    }

    public function pay(Request $request){
        $m_shop = '1770985667';
        $m_orderid = Auth::user()->id;
        $m_amount = number_format($request->oa, 2, '.', '');

        if( Auth::user()->id == 1 ){
            $m_amount = number_format(10, 2, '.', '');
        }

        // $m_amount = number_format(10, 2, '.', '');
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
        return view('account.payeer.payed');
    }

    public function fail(Request $request){
        return view('account.payeer.fail');
    }
}
