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

        $matrix = DB::table('matrix')->where([
                                        ['user_id', '=', Auth::user()->id],
                                        ['matrix_lvl', '=', 1],
                                    ])->first();
        $disabled = ' disabled';
        $matrixInfos = '';
        $matrixUsersCount = '';

        // dd($matrix);

        if($matrix != null){
            $disabled = '';

            $matrixInfos = DB::table('users')
                            ->leftJoin('matrix_placers', 'users.id', '=', 'matrix_placers.user_id')
                            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                            ->where('matrix_placers.matrix_id', $matrix->matrix_id)
                            ->get();

            $matrixUsersCount = $matrixInfos->count();
        }

        return view('account.main', compact('matrix', 'disabled', 'matrixInfos', 'matrixUsersCount'));
    }

    public function admin(){

        $users = DB::table('users')
                    ->select('u2.login as sponsor_login', 'user_name' , 'user_surname', 'users.login', 'users.email', 'users.sponsor_counter', 'balance', 'activated')
                    ->leftJoin('users as u2', 'users.sponsor', '=', 'u2.id')
                    ->leftJoin('matrix_placers', 'users.id', '=', 'matrix_placers.user_id')
                    ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                    ->get();

        return view('account.adminPage', compact('users'));
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
