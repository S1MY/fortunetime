<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Reviews;
use App\Models\User;
use App\Models\UserInfo;
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
        $faqs = DB::table('faq')->get();
        return view('pages.faq', compact('faqs'));
    }

    public function reviews(){
        $reviews = Reviews::orderBy('id', 'desc')->where('published', '=', '1')->paginate(5);
        $revCount = count(Reviews::where('published', '=', '1')->get());
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

        $user = DB::table('users')->where('id', '=', Auth::user()->id)->first();

        $matrix = DB::table('matrix')->where([
                    ['user_id', '=', Auth::user()->id],
                    ['matrix_lvl', '=', 1],
                ])->first();

        // Переменные если матрицы не существует
        $disabled = ' disabled';
        $matrixInfos = '';
        $matrixUsersCount = '';

        if($matrix != null && $matrix->matrix_id != null){

            // Если матрица есть, показываем её

            $disabled = '';

            // Берём людей из нашей матрицы

            $matrixInfos = DB::table('users')
                            ->leftJoin('matrix_placers', 'users.id', '=', 'matrix_placers.user_id')
                            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                            ->where([
                                ['matrix_placers.matrix_id', $matrix->matrix_id],
                                ['matrix_placers.line', 1],
                            ])
                            ->get();

            // Берём наших переливов
            // И переименовываем поля, для слияния двух матриц

            $matrixInfosReferers = DB::table('users')
                            ->select('users.id',
                                        'users.login',
                                        'referer_id as matrix_id',
                                        'referer_shoulder as shoulder',
                                        'referer_line as line',
                                        'referer_place as user_place',
                                        'user_name',
                                        'user_surname',
                                        'avatar',
                                        'email',
                                        'matrix_placers.created_at')
                            ->leftJoin('matrix_placers', 'users.id', '=', 'matrix_placers.user_id')
                            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                            ->where([
                                ['matrix_placers.referer_id', $matrix->matrix_id],
                                ['matrix_placers.referer_line', 1]
                            ])
                            ->get();

            // Склеиваем две коллекции

            $matrixInfos = $matrixInfos->merge($matrixInfosReferers);
            // dd($matrixInfos);

            // Считаем кол-во людей в матрице на первом линии
            $countMatrixMember = $matrixInfos->count();

            // Берём людей, кого пригласили из первой линии

            for ($i=0; $i < $countMatrixMember; $i++) {
                // Берём айдишник и плечо в котором находится $i человек в нашей линии

                $usID = $matrixInfos[$i]->user_id;
                $usSholder = $matrixInfos[$i]->shoulder;

                $UsMatrix = DB::table('matrix')->where([
                                ['user_id', '=', $usID],
                                ['matrix_lvl', '=', 1],
                            ])->first();

                $matrixInfosUs = DB::table('users')
                            ->leftJoin('matrix_placers', 'users.id', '=', 'matrix_placers.user_id')
                            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                            ->where([
                                ['matrix_placers.matrix_id', $UsMatrix->matrix_id],
                                ['matrix_placers.line', 1],
                            ])
                            ->take(2)
                            ->get();

                $matrixInfosUs->map(function($info) use ($usSholder){
                    $info->line = $info->line + 1;
                    $info->shoulder = $usSholder;

                    return $info;
                });

                $countLineMatrixMebmer = $matrixInfosUs->count();



                for ($m=0; $m < $countLineMatrixMebmer; $m++) {

                    for ($d=1; $d < 8; $d++) {

                        $usID2 = $matrixInfosUs[$m]->user_id;

                        $usSholder = $matrixInfosUs[$m]->shoulder;

                        $usLine = $matrixInfosUs[$m]->line;

                        $UsMatrixLine = DB::table('matrix')->where([
                                        ['user_id', '=', $usID2],
                                        ['matrix_lvl', '=', 1],
                                    ])->first();


                        $matrixInfosUsLine = DB::table('users')
                                    ->leftJoin('matrix_placers', 'users.id', '=', 'matrix_placers.user_id')
                                    ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                                    ->where([
                                        ['matrix_placers.matrix_id', $UsMatrixLine->matrix_id],
                                        ['matrix_placers.line', $d],
                                    ])
                                    ->take(2)
                                    ->get();


                        $matrixInfosUsLine->map(function($info) use ($usSholder, $usLine){
                            $info->line = $usLine + 1;
                            $info->shoulder = $usSholder;
                            return $info;
                        });

                        $matrixInfosUs = $matrixInfosUs->merge($matrixInfosUsLine);
                        $countLineMatrixMebmer = $matrixInfosUs->count();
                    }

                }

                $matrixInfos = $matrixInfos->merge($matrixInfosUs);
            }


            // Берём наших людей и переливов по линиям

            for ($i=2; $i < 8; $i++) {

                $matrixID = $matrix->matrix_id;

                $matrixInfosNext = DB::table('users')
                            ->leftJoin('matrix_placers', 'users.id', '=', 'matrix_placers.user_id')
                            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                            ->where([
                                ['matrix_placers.matrix_id', $matrixID],
                                ['matrix_placers.line', $i],
                            ])
                            ->get();

                $matrixInfosReferersNext = DB::table('users')
                            ->select('users.id',
                                        'users.login',
                                        'referer_id as matrix_id',
                                        'referer_shoulder as shoulder',
                                        'referer_line as line',
                                        'referer_place as user_place',
                                        'user_name',
                                        'user_surname',
                                        'avatar',
                                        'email',
                                        'matrix_placers.created_at')
                            ->leftJoin('matrix_placers', 'users.id', '=', 'matrix_placers.user_id')
                            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                            ->where([
                                ['matrix_placers.referer_id', $matrixID],
                                ['matrix_placers.referer_line', $i]
                            ])
                            ->get();

                $matrixInfos = $matrixInfos->merge($matrixInfosNext);
                $matrixInfos = $matrixInfos->merge($matrixInfosReferersNext);

            }

            $matrixUsersCount = $matrixInfos->count();
        }

        $user_max_lvl = DB::table('matrix')->where([
            ['user_id', '=', $user->id],
        ])
        ->orderBy('matrix_lvl', 'DESC')
        ->first();

        return view('account.main', compact('matrix', 'disabled', 'matrixInfos', 'matrixUsersCount'));
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
