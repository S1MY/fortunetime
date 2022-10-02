<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Reviews;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    /* Pages */

    public function index(){
        $userCount = count(User::get());

        $datetime1 = new DateTime('2022-08-02');
        $datetime2 = new DateTime('now');
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');

        $activeCount = count(UserInfo::where('activated', '1')->get());

        $getTopReferer = User::orderBy('sponsor_counter', 'DESC')->where('sponsor_counter','<>',null)->limit(6)->get();

        $getLastRegister = User::limit(6)->get();

        return view('pages.home', compact('userCount', 'days', 'activeCount', 'getTopReferer', 'getLastRegister'));
    }

    public function about(){
        return view('pages.about');
    }

    public function marketing(){
        return view('pages.marketing');
    }

    public function faq(){
        return view('pages.faq');
    }

    public function reviews(){
        $reviews = Reviews::orderBy('id', 'desc')->paginate(5);
        $revCount = count(Reviews::get());
        return view('pages.reviews', compact('reviews', 'revCount'));
    }

    public function news(){
        $news = News::orderBy('id', 'desc')->paginate(3);
        $newCount = count(News::get());
        return view('pages.news', compact('news', 'newCount'));
    }

    public function statistic(){
        return view('pages.statistic');
    }

    public function langchange(Request $request){
        session()->flash('warning', 'Пока что доступен только Русский язык!  Мы работаем над переводом.' );

        return route('main');
    }

    /* Documents */

    public function rules(){
        return view('pages.Documents.rules');
    }

    public function personal(){
        return view('pages.Documents.personal');
    }

    /* Account */

    public function account(){
        $user = User::where('id', 10)->first();
        $matrix_lvl = 1;
        if( $user['sponsor'] != 0 ){

            // Проверяем активировал ли спонсор свою матрицу

            $SMartix = DB::table('matrix')->where([
                ['user_id', '=', $user['sponsor']],
                ['matrix_lvl', '=', $matrix_lvl],
            ])->first();

            if( $SMartix ){

                if( $SMartix['matrix_id'] != null ){

                    // У спонсора уже есть активная матрица и приглашённые

                    DB::table('matrix')->insert([
                        'user_id' => $user['id'],
                        'matrix_lvl' => $matrix_lvl,
                        'matrix_active' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    DB::table('matrix')->where('user_id', $user['sponsor'])->update([
                        'matrix_id' => $_SERVER['REMOTE_ADDR'],
                    ]);

                }else{

                    // У спонсора уже есть активная матрица, но нет приглашённых ставим первого

                    DB::table('matrix_placers')->insert([
                        'user_id' => $user['id'],
                        'user_place' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $matrixID = DB::getPdo()->lastInsertId();

                    DB::table('matrix')->where('user_id', $user['sponsor'])->update([
                        'matrix_id' => $matrixID,
                    ]);

                }

            }

        }

        $matrix = DB::table('matrix')->where('user_id', Auth::user()->id)->first();

        $disabled = ' disabled';
        if($matrix != null){
            $disabled = '';
        }

        return view('account.main', compact('matrix', 'disabled'));
    }

    public function start(){
        return view('account.start');
    }

    public function automation(){
        return view('account.automation');
    }

    public function settings(){
        return view('account.settings');
    }

    public function setPincode(Request $request){
        UserInfo::update($request['pincode']);
    }

    public function referral($login){
        session(['sponsor' => $login]);
        return redirect()->route('main');
    }

}
