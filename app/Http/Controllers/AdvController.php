<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvController extends Controller
{
    public function payed(Request $request){
        return view('account.adv.payed');
    }

    public function fail(Request $request){
        return view('account.adv.fail');
    }
}
