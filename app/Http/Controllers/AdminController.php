<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    // Страницы

    public function admin(){

        $users = DB::table('users')
                    ->select('u2.login as sponsor_login', 'user_name' , 'user_surname', 'users.login', 'users.email', 'users.sponsor_counter', 'balance', 'activated', 'users.created_at')
                    ->leftJoin('users as u2', 'users.sponsor', '=', 'u2.id')
                    ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                    ->get();

        $title = 'Все пользователи ('.$users->count().')';

        return view('account.admin.main', compact('users', 'title'));
    }

    public function paied(){
        $paieds = DB::table('freekassas')
                    ->select('users.login', DB::raw("sum(amount) as amount"), DB::raw("date(freekassas.created_at) as created_at"))
                    ->leftJoin('users', 'freekassas.user_id', '=', 'users.id')
                    ->where('status','=',1)
                    ->groupBy('users.login', DB::raw("date(freekassas.created_at)"))
                    ->orderBy('created_at', 'DESC')
                    ->get();

        $title = 'Все успешные пополнения ('.$paieds->count().')';

        return view('account.admin.payed', compact('paieds', 'title'));
    }

    public function faq(){
        $faqs = DB::table('faq')
                    ->orderBy('id', 'DESC')
                    ->get();

        return view('account.admin.faq', compact('faqs'));
    }

    // Управление

    public function adminSorting(Request $request){

        $all = 1;

        if( $request->activated == 1 ){
            $users = DB::table('users')
                    ->select('u2.login as sponsor_login', 'user_name' , 'user_surname', 'users.login', 'users.email', 'users.sponsor_counter', 'balance', 'activated', 'users.created_at')
                    ->leftJoin('users as u2', 'users.sponsor', '=', 'u2.id')
                    ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                    ->where('activated', $request->activated)
                    ->get();
            $title = 'Активированные пользователи ('.$users->count().')';
        }

        if( $request->sponsor_login == 1 ){
            $users = DB::table('users')
                    ->select('u2.login as sponsor_login', 'user_name' , 'user_surname', 'users.login', 'users.email', 'users.sponsor_counter', 'balance', 'activated', 'users.created_at')
                    ->leftJoin('users as u2', 'users.sponsor', '=', 'u2.id')
                    ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                    ->where([
                        ['activated', 0],
                        ['users.sponsor', NULL]
                        ])
                    ->get();
            $title = 'Пользователи которым можно сменить пригласившего ('.$users->count().')';
        }

        if( $request->sponsor_login == 1 OR $request->activated == 1 ){
            $all = 0;
        }

        if( $all == 1 ){
            $users = DB::table('users')
                    ->select('u2.login as sponsor_login', 'user_name' , 'user_surname', 'users.login', 'users.email', 'users.sponsor_counter', 'balance', 'activated', 'users.created_at')
                    ->leftJoin('users as u2', 'users.sponsor', '=', 'u2.id')
                    ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                    ->get();
            $title = 'Все пользователи ('.$users->count().')';
        }



        return view('account.admin.layout.usersTable', compact('users', 'title'));
    }

    public function adminAddFAQ(AdminRequest $request){

        if( $request->edit == 0 ){
            DB::table('faq')->insert([
                [
                    'qustion' => $request->question,
                    'answer' => $request->answer,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ]);
        }else{
            DB::table('faq')
            ->where('id', $request->edit)
            ->update([
                'qustion' => $request->question,
                'answer' => $request->answer,
                'updated_at' => Carbon::now(),
            ]);
        }

        return true;
    }
}
