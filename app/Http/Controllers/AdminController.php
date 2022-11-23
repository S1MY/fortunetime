<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function tester(){
        return view('tester');
    }

    // Страницы

    public function admin(){

        $users = DB::table('users')
                    ->select('u2.login as sponsor_login', 'user_id', 'user_name' , 'user_surname', 'users.login', 'users.email', 'users.sponsor_counter', 'balance', 'activated', 'users.created_at')
                    ->leftJoin('users as u2', 'users.sponsor', '=', 'u2.id')
                    ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                    ->paginate(15);

        $title = 'Все пользователи ('.DB::table('users')
                                    ->select('u2.login as sponsor_login', 'user_name' , 'user_surname', 'users.login', 'users.email', 'users.sponsor_counter', 'balance', 'activated', 'users.created_at')
                                    ->leftJoin('users as u2', 'users.sponsor', '=', 'u2.id')
                                    ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                                    ->get()->count().')';

        return view('account.admin.main', compact('users', 'title'));
    }

    public function paied(){
        $paieds = DB::table('freekassas')
                    ->select('users.login', DB::raw("sum(amount) as amount"), DB::raw("date(freekassas.created_at) as created_at"))
                    ->leftJoin('users', 'freekassas.user_id', '=', 'users.id')
                    ->where('status','=',1)
                    ->groupBy('users.login', DB::raw("date(freekassas.created_at)"))
                    ->orderBy('created_at', 'DESC')
                    ->paginate(15);

        $title = 'Все пополнения';

        $paiedsum = DB::table('freekassas')
                    ->where('status','=',1)
                    ->sum('amount');

        return view('account.admin.payed', compact('paieds', 'title', 'paiedsum'));
    }

    public function faq(){
        $faqs = DB::table('faq')
                    ->orderBy('id', 'DESC')
                    ->paginate(5);

        return view('account.admin.faq', compact('faqs'));
    }

    public function reviews(){
        $reviews = DB::table('reviews')
                    ->select('users.id', 'reviews.user_id', 'avatar', 'review', 'reviews.id as revID', 'published', 'reviews.created_at', 'users.login', 'user_infos.user_name', 'user_infos.user_surname')
                    ->leftJoin('users', 'reviews.user_id', '=', 'users.id')
                    ->leftJoin('user_infos', 'reviews.user_id', '=', 'user_infos.user_id')
                    ->orderBy('reviews.id', 'DESC')
                    ->get();

        $rewCount = count($reviews);

        return view('account.admin.reviews', compact('reviews', 'rewCount'));

    }

    public function news(){
        $news = DB::table('news')
                    ->orderBy('news.id', 'DESC')
                    ->paginate(4);

        $newCount = DB::table('news')->orderBy('news.id', 'DESC')->count();

        return view('account.admin.news', compact('news', 'newCount'));
    }

    public function showMartix($login){

        $user = DB::table('users')->where('login', '=', $login)->first();

        $userInfo = DB::table('user_infos')->where('user_id', '=', $user->id)->first();

        $matrix = DB::table('matrix')->where([
            ['user_id', '=', $user->id],
            ['matrix_lvl', '=', 1],
        ])->first();

        // Переменные если матрицы не существует
        $disabled = ' disabled';
        $matrixInfos = '';
        $matrixUsersCount = '';

        if($matrix != null){

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

                $usID = $matrixInfos[$i]->id;
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

                        $usID2 = $matrixInfosUs[$m]->id;
                        $usSholder = $matrixInfosUs[$m]->shoulder;

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

                        // dd($matrixInfosUsLine);

                        $matrixInfosUsLine->map(function($info) use ($usSholder){
                            $info->line = $info->line + 2;
                            $info->shoulder = $usSholder;
                            return $info;
                        });
                        $matrixInfosUs = $matrixInfosUs->merge($matrixInfosUsLine);
                    }
                }

                $matrixInfos = $matrixInfos->merge($matrixInfosUs);
            }

            // dd($matrixInfos);

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

        // dd($matrixInfos);

        return view('account.admin.matrix', compact('user', 'userInfo' ,'matrix', 'disabled', 'matrixInfos', 'matrixUsersCount'));
    }

    // Управление

    public function changeUserReferal(Request $request){

        // return $request;

        $sponsor = DB::table('users')->where('login', '=', $request->newSponsor)->first();

        $sponsor = $sponsor->id;

        DB::table('users')
            ->where('id', $request->changeID)
            ->update([
                'sponsor' => $sponsor,
            ]);

        return 1;
    }

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

    public function faqDelete(Request $request){

        DB::table('faq')->where('id', '=', $request->removeid)->delete();

        return true;
    }

    public function reviewChanger(Request $request){

        DB::table('reviews')->where('id', $request->id)->update([
            'published' => $request->value,
        ]);

        return true;

    }

    public function adminSortingRewiew(Request $request){

        if( $request->value == 0 ){
            $reviews = DB::table('reviews')
                    ->select('users.id', 'reviews.user_id', 'avatar', 'review', 'reviews.id as revID', 'published', 'reviews.created_at', 'users.login', 'user_infos.user_name', 'user_infos.user_surname')
                    ->leftJoin('users', 'reviews.user_id', '=', 'users.id')
                    ->leftJoin('user_infos', 'reviews.user_id', '=', 'user_infos.user_id')
                    ->orderBy('reviews.id', 'DESC')
                    ->get();

            $rewCount = count($reviews);

            $rewTitle = 'Все отзывы ('.$rewCount.')';

            return view('account.admin.layout.usersReviews', compact('reviews', 'rewTitle'));
        }elseif( $request->value == 1 ){
            $reviews = DB::table('reviews')
                    ->select('users.id', 'reviews.user_id', 'avatar', 'review', 'reviews.id as revID', 'published', 'reviews.created_at', 'users.login', 'user_infos.user_name', 'user_infos.user_surname')
                    ->leftJoin('users', 'reviews.user_id', '=', 'users.id')
                    ->leftJoin('user_infos', 'reviews.user_id', '=', 'user_infos.user_id')
                    ->where('published', '=', 1)
                    ->orderBy('reviews.id', 'DESC')
                    ->get();

            $rewCount = count($reviews);

            $rewTitle = 'Опубликованные отзывы ('.$rewCount.')';

            return view('account.admin.layout.usersReviews', compact('reviews', 'rewTitle'));
        }else{
            $reviews = DB::table('reviews')
                    ->select('users.id', 'reviews.user_id', 'avatar', 'review', 'reviews.id as revID', 'published', 'reviews.created_at', 'users.login', 'user_infos.user_name', 'user_infos.user_surname')
                    ->leftJoin('users', 'reviews.user_id', '=', 'users.id')
                    ->leftJoin('user_infos', 'reviews.user_id', '=', 'user_infos.user_id')
                    ->where('published', '=', 0)
                    ->orderBy('reviews.id', 'DESC')
                    ->get();

            $rewCount = count($reviews);

            $rewTitle = 'Снятые с публикации ('.$rewCount.')';

            return view('account.admin.layout.usersReviews', compact('reviews', 'rewTitle'));
        }
    }

    public function adminAddNews(Request $request){

        // return $request;

        if ($request->hasFile('newsimg')) {
            $path = $request->file('newsimg')->store('news');
        }else{
            $path = '';
        }

        if( $request->edit == 0 ){
            DB::table('news')->insert([
                [
                    'title' => $request->title,
                    'content' => $request->content,
                    'image' => $path,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ]);
        }else{
            if ($request->hasFile('newsimg')) {
                DB::table('news')
                ->where('id', $request->edit)
                ->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'image' => $path,
                    'updated_at' => Carbon::now(),
                ]);
            }else{
                DB::table('news')
                ->where('id', $request->edit)
                ->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        return true;

    }

    public function newsDelete(Request $request){
        DB::table('news')->where('id', '=', $request->removeid)->delete();

        return true;
    }
}
