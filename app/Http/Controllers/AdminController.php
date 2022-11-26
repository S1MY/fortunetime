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
                    ->get();

        for ($i=0; $i < $paieds->count(); $i++) {
            $paieds[$i]->type = 'freekassa';
        }

        $paiedsPayeer = DB::table('payeer')
                    ->select('users.login', DB::raw("sum(amount) as amount"), DB::raw("date(payeer.created_at) as created_at"))
                    ->leftJoin('users', 'payeer.user_id', '=', 'users.id')
                    ->groupBy('users.login', DB::raw("date(payeer.created_at)"))
                    ->orderBy('created_at', 'DESC')
                    ->get();

        for ($i=0; $i < $paiedsPayeer->count(); $i++) {
            $paiedsPayeer[$i]->type = 'payeer';
        }


        $paieds = $paieds->merge($paiedsPayeer);

        $title = 'Все пополнения';

        $paiedsum = DB::table('freekassas')
                    ->where('status','=',1)
                    ->sum('amount');

        $paiedsumPayeer = DB::table('payeer')
                    ->sum('amount');

        return view('account.admin.payed', compact('paieds', 'title', 'paiedsum', 'paiedsumPayeer'));
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

            // Считаем кол-во людей в матрице на первом линии
            $countMatrixMember = $matrixInfos->count();

            // Берём людей, кого пригласили из первой линии

            for ($i=0; $i < $countMatrixMember; $i++) {
                // Берём айдишник и плечо в котором находится $i человек в нашей линии

                $usID = $matrixInfos[$i]->user_id;

                if( !$matrixInfos[$i]->user_id ){
                    $usID = $matrixInfos[$i]->id;
                }

                // echo $usID;

                $usSholder = $matrixInfos[$i]->shoulder;

                $UsMatrix = DB::table('matrix')->where([
                                ['user_id', '=', $usID],
                                ['matrix_lvl', '=', 1],
                            ])->first();

                // if( $usID == 44 ){
                //     dd($UsMatrix);
                // }

                $matrixInfosUs = DB::table('users')
                            ->leftJoin('matrix_placers', 'users.id', '=', 'matrix_placers.user_id')
                            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                            ->where([
                                ['matrix_placers.matrix_id', $UsMatrix->matrix_id],
                                ['matrix_placers.line', 1],
                            ])
                            ->orderBy('matrix_placers.id', 'ASC')
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
                                    ->orderBy('matrix_placers.id', 'ASC')
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

        // dd($matrixInfos);

        return view('account.admin.matrix', compact('user', 'userInfo' ,'matrix', 'disabled', 'matrixInfos', 'matrixUsersCount', 'user_max_lvl'));
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
                    ->select('u2.login as sponsor_login', 'user_id', 'user_name' , 'user_surname', 'users.login', 'users.email', 'users.sponsor_counter', 'balance', 'activated', 'users.created_at')
                    ->leftJoin('users as u2', 'users.sponsor', '=', 'u2.id')
                    ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
                    ->where('activated', $request->activated)
                    ->get();
            $title = 'Активированные пользователи ('.$users->count().')';
        }

        if( $request->sponsor_login == 1 ){
            $users = DB::table('users')
                    ->select('u2.login as sponsor_login', 'user_id', 'user_name' , 'user_surname', 'users.login', 'users.email', 'users.sponsor_counter', 'balance', 'activated', 'users.created_at')
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
                    ->select('u2.login as sponsor_login', 'user_id', 'user_name' , 'user_surname', 'users.login', 'users.email', 'users.sponsor_counter', 'balance', 'activated', 'users.created_at')
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

    public function activeNextLvl($id, $matrix_lvl){
        // Данные для проверки
        $matrix_lvl = $matrix_lvl;
        $referer_id = 0;
        $uplace = 0;
        $refposs = 0;
        $inLineCollect = 0;
        $pInLastLine = 0;

        $user = DB::table('users')->where('id', $id )->first();

        // Проверяем есть ли у нас матрица

        $myMatrix = DB::table('matrix')->where([
            ['user_id', '=', $user->id],
            ['matrix_lvl', '=', $matrix_lvl],
        ])->first();

        if ( !$myMatrix ) {

            DB::table('matrix')->insert([
            'user_id' => $user->id,
            'matrix_lvl' => $matrix_lvl,
            'matrix_active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
            ]);

            // Обновляем статус активации

            DB::table('user_infos')->where([
            ['user_id', '=', $user->id],
            ])->update(['activated' => 1]);

        }

        // Берём спонсора и проверяем есть ли у него матрица
        $sp = $user->sponsor;

        $lineG = array(4, 8, 16, 32, 64, 128, 256);

        $spmatrix = DB::table('matrix')->where([
            ['user_id', '=', $sp],
            ['matrix_lvl', '=', $matrix_lvl],
        ])->first();

        if( $spmatrix ){
            // Берём id активной матрицы
            $spmid = $spmatrix->matrix_id;

            if( $spmid ){
                $matrix_id = $spmid;

                for ($i=1; $i <= 7; $i++) {
                    $line = $i;
                    echo '----- Итерация # ' . $i . ' -----';
                    echo '<br>';

                    $current_line = $i;

                    $spmplacer = DB::table('matrix_placers')->where([
                        ['matrix_id', '=', $matrix_id],
                        ['line', '=', $i],
                    ])->orWhere([
                        ['referer_id', '=', $matrix_id],
                        ['referer_line', '=', $i],
                    ])->get();

                    $spmplacerCounter = $spmplacer->count();

                    if( $i > 1 ){
                        $spmplacerCounter = 0;

                        if( $i == 2 ){
                            $prevLine = DB::table('matrix_placers')->where([
                                ['matrix_id', '=', $matrix_id],
                                ['line', '=', $i - 1],
                            ])->orWhere([
                                ['referer_id', '=', $matrix_id],
                                ['referer_line', '=', $i - 1],
                            ])->get();
                        }else{
                            // Тут нужна сборная солянка с переливами

                            $prevLine = $inLineCollect;
                        }

                        echo 'Людей на прошлой линии: '.$pInLastLine;
                        echo '<br>';

                        $inLineCollect = collect();

                        for ($o=0; $o < $pInLastLine; $o++) {
                            $prevLineUser = $prevLine[$o];

                            $UsMatrix = DB::table('matrix')->where([
                                            ['user_id', '=', $prevLineUser->user_id],
                                            ['matrix_lvl', '=', $matrix_lvl],
                                        ])->first();

                            $prevMatrixId = $UsMatrix->matrix_id;

                            if( $prevMatrixId != null ){
                                $minus = 1;
                                if( $i >= 3 ){
                                    $minus = $i - 1;
                                }
                                $prevMatrixPlacer = DB::table('matrix_placers')->where([
                                    ['matrix_id', '=', $prevMatrixId],
                                    ['line', '=', $i-$minus],
                                    ['shoulder', '=', 0],
                                ])->orWhere([
                                    ['referer_id', '=', $prevMatrixId],
                                    ['referer_line', '=', $i-$minus],
                                    ['referer_shoulder', '=', 0],
                                ])->take(2)->get();

                                if( $prevMatrixPlacer->count() == 1 ){
                                    $spmplacerCounter = $spmplacerCounter + 1;

                                    echo 'У пользователя '. $prevLineUser->user_id . ' на линии ' . $prevMatrixPlacer->count() . ' человек';
                                    echo '<br>';

                                    $inLineCollect = $inLineCollect->merge($prevMatrixPlacer);

                                }elseif ( $prevMatrixPlacer->count() >= 2 ) {
                                    $spmplacerCounter = $spmplacerCounter + 2;

                                    echo 'У пользователя '. $prevLineUser->user_id . ' на линии более 2-ух человек';
                                    echo '<br>';

                                    $inLineCollect = $inLineCollect->merge($prevMatrixPlacer);
                                }

                            }

                        }

                    }


                    if( $spmplacerCounter == $lineG[$i-1] ){

                        echo 'Линяя ' . $i . ' занята';
                        echo '<br>';
                        $lastLineCounter = array(4, 8, 16, 32, 64, 128, 256);

                        $pInLastLine = $lastLineCounter[$i - 1];

                    }else{

                        echo 'Свободна '.$i.' линяя';
                        echo '<br>';
                        echo 'Людей на линии: ' . $spmplacerCounter;
                        echo '<br>';

                        if( $i != 1 ){

                            for ($uplace=($spmplacerCounter + 1); $uplace <= $lineG[$i-1]; $uplace++) {

                                echo '==== Проверка позиции: ' . $uplace . ' ====';
                                echo '<br>';

                                $rpos = 1;

                                for ($n=1; $n <= $uplace; $n++) {
                                    if ( ($n - 1) % 2 == 0  && $n-1 != 0 ){
                                        $rpos++;
                                    }
                                }

                                echo 'Позиция вышестоящего: ' . $rpos;
                                echo '<br>';

                                echo 'Матрица вышестоящего: ' . $matrix_id;
                                echo '<br>';

                                $refmplacer = DB::table('matrix_placers')->where([
                                    ['matrix_id', '=', $matrix_id],
                                    ['line', '=', $i-1],
                                    ['user_place', '=', $rpos],
                                ])->orWhere([
                                    ['referer_id', '=', $matrix_id],
                                    ['referer_line', '=', $i-1],
                                    ['referer_place', '=', $rpos],
                                ])->first();

                                if( $i >= 3 ){
                                    $refmplacer = $prevLine[$rpos-1];
                                }

                                $ruser_id = $refmplacer->user_id;


                                $refmatrix = DB::table('matrix')->where([
                                    ['user_id', '=', $ruser_id],
                                    ['matrix_lvl', '=', $matrix_lvl],
                                ])->first();

                                if( $refmatrix->matrix_id == null ){
                                    echo 'Обновили данные матрицы';
                                    echo '<br>';

                                    $newMatrixID = DB::table('matrix_placers')->count()+1;

                                    DB::table('matrix')->where([
                                        ['user_id', '=', $ruser_id],
                                        ['matrix_lvl', '=', $matrix_lvl],
                                    ])->update(['matrix_id' => $newMatrixID]);
                                }

                                if( $refmatrix ){
                                    $referer_id = $refmatrix->matrix_id;

                                    $rmplacer = DB::table('matrix_placers')->where([
                                        ['matrix_id', '=', $referer_id],
                                        ['line', '=', 1],
                                        ['shoulder', '=', 0],
                                    ])->orWhere([
                                        ['referer_id', '=', $referer_id],
                                        ['referer_line', '=', 1],
                                        ['referer_shoulder', '=', 0],
                                    ])->get();


                                    if( $rmplacer->count() >= 2 ){
                                        echo 'Тут нельзя';
                                        echo '<br>';
                                    }else{

                                        $myRpos = $rmplacer->count() + 1;

                                        echo 'Можем разместиться';
                                        echo '<br>';
                                        echo 'Матрица вышестоящего: ' . $referer_id;
                                        echo '<br>';
                                        echo 'Наша в ней позиция: '.$myRpos;
                                        echo '<br>';

                                        $refposs = $myRpos;

                                        break;
                                    }
                                }else{
                                    // У вышестоящего ещё не активирована матрица

                                    $newMatrixID = DB::table('matrix_placers')->count()+1;

                                    DB::table('matrix')->insert([
                                        'user_id' => $ruser_id,
                                        'matrix_lvl' => $matrix_lvl,
                                        'matrix_active' => 1,
                                        'matrix_id' => $newMatrixID,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);

                                    $refposs = 1;
                                    $referer_id = $newMatrixID;

                                    echo 'Создали матрицу вышестоящему';
                                    echo '<br>';

                                    break;
                                }

                            }

                        }else{
                            // Нет вышестоящего кроме спонсора
                            $uplace = $spmplacerCounter + 1;
                            $referer_id = null;
                            $refposs = $uplace;
                        }

                        break;

                    }

                }

                // exit;

                $line_pay = 0;
                $line_reinv = 0;

                // Нужно ли двать деньги

                if( $uplace == $lineG[$current_line - 1] ){
                    if( $matrix_lvl == 1 ){
                        switch ($current_line) {
                            case 1:
                                $line_pay = 4000;
                                $line_bonus = 0;
                                break;
                            case 2:
                                $line_pay = 3000;
                                $line_bonus = 5000;
                                break;
                            case 3:
                                $line_pay = 11000;
                                $line_bonus = 5000;
                                break;
                            case 4:
                                $line_pay = 27000;
                                $line_bonus = 5000;
                                break;
                            case 5:
                                $line_pay = 59000;
                                $line_bonus = 5000;
                                break;
                            case 6:
                                $line_pay = 123000;
                                $line_bonus = 5000;
                                break;
                            case 7:
                                $line_pay = 246000;
                                $line_bonus = 10000;
                                break;
                        }
                    }elseif ( $matrix_lvl == 2 ) {
                        switch ($current_line) {
                            case 1:
                                $line_pay = 20000;
                                $line_bonus = 0;
                                break;
                            case 2:
                                $line_pay = 30000;
                                $line_bonus = 10000;
                                break;
                            case 3:
                                $line_pay = 70000;
                                $line_bonus = 10000;
                                break;
                            case 4:
                                $line_pay = 150000;
                                $line_bonus = 10000;
                                break;
                            case 5:
                                $line_pay = 310000;
                                $line_bonus = 10000;
                                break;
                            case 6:
                                $line_pay = 640000;
                                $line_bonus = 10000;
                                break;
                            case 7:
                                $line_pay = 1260000;
                                $line_bonus = 20000;
                                break;
                        }
                    }elseif ( $matrix_lvl == 3 ) {
                        switch ($current_line) {
                            case 1:
                                $line_pay = 40000;
                                $line_bonus = 0;
                                break;
                            case 2:
                                $line_pay = 55000;
                                $line_bonus = 25000;
                                break;
                            case 3:
                                $line_pay = 135000;
                                $line_bonus = 25000;
                                break;
                            case 4:
                                $line_pay = 295000;
                                $line_bonus = 25000;
                                break;
                            case 5:
                                $line_pay = 615000;
                                $line_bonus = 25000;
                                break;
                            case 6:
                                $line_pay = 1255000;
                                $line_bonus = 25000;
                                break;
                            case 7:
                                $line_pay = 2510000;
                                $line_bonus = 50000;
                                break;
                        }
                    }elseif ( $matrix_lvl == 4 ) {
                        switch ($current_line) {
                            case 1:
                                $line_pay = 50000;
                                $line_bonus = 50000;
                                break;
                            case 2:
                                $line_pay = 15000;
                                $line_bonus = 50000;
                                break;
                            case 3:
                                $line_pay = 350000;
                                $line_bonus = 50000;
                                break;
                            case 4:
                                $line_pay = 750000;
                                $line_bonus = 50000;
                                break;
                            case 5:
                                $line_pay = 1550000;
                                $line_bonus = 50000;
                                break;
                            case 6:
                                $line_pay = 3150000;
                                $line_bonus = 50000;
                                break;
                            case 7:
                                $line_pay = 6350000;
                                $line_bonus = 50000;
                                break;
                        }
                    }elseif ( $matrix_lvl == 5 ) {
                        switch ($current_line) {
                            case 1:
                                $line_pay = 50000;
                                $line_bonus = 100000;
                                $line_reinv = 50000;
                                break;
                            case 2:
                                $line_pay = 250000;
                                $line_bonus = 100000;
                                $line_reinv = 50000;
                                break;
                            case 3:
                                $line_pay = 650000;
                                $line_bonus = 100000;
                                $line_reinv = 50000;
                                break;
                            case 4:
                                $line_pay = 1450000;
                                $line_bonus = 100000;
                                $line_reinv = 50000;
                                break;
                            case 5:
                                $line_pay = 3050000;
                                $line_bonus = 100000;
                                $line_reinv = 50000;
                                break;
                            case 6:
                                $line_pay = 6250000;
                                $line_bonus = 100000;
                                $line_reinv = 50000;
                                break;
                            case 7:
                                $line_pay = 12650000;
                                $line_bonus = 100000;
                                $line_reinv = 50000;
                                break;
                        }
                    }elseif ( $matrix_lvl == 6 ) {
                        switch ($current_line) {
                            case 1:
                                $line_pay = 150000;
                                $line_bonus = 250000;
                                break;
                            case 2:
                                $line_pay = 350000;
                                $line_bonus = 250000;
                                $line_reinv = 200000;
                                break;
                            case 3:
                                $line_pay = 1250000;
                                $line_bonus = 250000;
                                $line_reinv = 100000;
                                break;
                            case 4:
                                $line_pay = 2850000;
                                $line_bonus = 250000;
                                $line_reinv = 100000;
                                break;
                            case 5:
                                $line_pay = 6050000;
                                $line_bonus = 250000;
                                $line_reinv = 100000;
                                break;
                            case 6:
                                $line_pay = 12450000;
                                $line_bonus = 250000;
                                $line_reinv = 100000;
                                break;
                            case 7:
                                $line_pay = 25250000;
                                $line_bonus = 250000;
                                $line_reinv = 100000;
                                break;
                        }
                    }elseif ( $matrix_lvl == 7 ) {
                        switch ($current_line) {
                            case 1:
                                $line_pay = 500000;
                                $line_bonus = 500000;
                                $line_reinv = 250000;
                                break;
                            case 2:
                                $line_pay = 1250000;
                                $line_bonus = 500000;
                                $line_reinv = 250000;
                                break;
                            case 3:
                                $line_pay = 3250000;
                                $line_bonus = 500000;
                                $line_reinv = 250000;
                                break;
                            case 4:
                                $line_pay = 7250000;
                                $line_bonus = 500000;
                                $line_reinv = 250000;
                                break;
                            case 5:
                                $line_pay = 15250000;
                                $line_bonus = 500000;
                                $line_reinv = 250000;
                                break;
                            case 6:
                                $line_pay = 31250000;
                                $line_bonus = 500000;
                                $line_reinv = 250000;
                                break;
                            case 7:
                                $line_pay = 63250000;
                                $line_bonus = 500000;
                                $line_reinv = 250000;
                                break;
                        }
                    }elseif ( $matrix_lvl == 8 ) {
                        switch ($current_line) {
                            case 1:
                                $line_pay = 500000;
                                $line_bonus = 1000000;
                                $line_reinv = 500000;
                                break;
                            case 2:
                                $line_pay = 2500000;
                                $line_bonus = 1000000;
                                $line_reinv = 500000;
                                break;
                            case 3:
                                $line_pay = 6500000;
                                $line_bonus = 1000000;
                                $line_reinv = 500000;
                                break;
                            case 4:
                                $line_pay = 14500000;
                                $line_bonus = 1000000;
                                $line_reinv = 500000;
                                break;
                            case 5:
                                $line_pay = 30500000;
                                $line_bonus = 1000000;
                                $line_reinv = 500000;
                                break;
                            case 6:
                                $line_pay = 62500000;
                                $line_bonus = 1000000;
                                $line_reinv = 500000;
                                break;
                            case 7:
                                $line_pay = 126500000;
                                $line_bonus = 1000000;
                                $line_reinv = 500000;
                                break;
                        }
                    }elseif ( $matrix_lvl == 9 ) {
                        switch ($current_line) {
                            case 1:
                                $line_pay = 3000000;
                                $line_reinv = 1000000;
                                break;
                            case 2:
                                $line_pay = 7000000;
                                $line_reinv = 1000000;
                                break;
                            case 3:
                                $line_pay = 15000000;
                                $line_reinv = 1000000;
                                break;
                            case 4:
                                $line_pay = 31000000;
                                $line_reinv = 1000000;
                                break;
                            case 5:
                                $line_pay = 63000000;
                                $line_reinv = 1000000;
                                break;
                            case 6:
                                $line_pay = 127000000;
                                $line_reinv = 1000000;
                                break;
                            case 7:
                                $line_pay = 255000000;
                                $line_reinv = 1000000;
                                break;
                        }
                    }
                }

                if( $line_pay != 0 ){
                    // Тут даём деньги спонсору и открываем новую матрицу
                    echo 'Даём деньги '. $sp .' в сумме '. $line_pay;

                    // Деньги

                    DB::table('user_infos')->where([
                        ['user_id', '=', $sp],
                    ])->increment('balance', $line_pay);

                    // Наши деньги

                    DB::table('user_infos')->where([
                        ['user_id', '=', $sp],
                    ])->increment('alter_balance', $line_bonus);

                    // Всего заработанно

                    DB::table('user_infos')->where([
                        ['user_id', '=', $sp],
                    ])->increment('earned', $line_pay);

                    if( $line_reinv == 0 ){

                        $spNewMatrix = DB::table('matrix')->where([
                            ['user_id', '=', $sp],
                            ['matrix_lvl', '=', $matrix_lvl+1],
                        ])->first();

                        if ( !$spNewMatrix ) {

                            DB::table('matrix')->insert([
                                'user_id' => $sp,
                                'matrix_lvl' => $matrix_lvl+1,
                                'matrix_active' => 1,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);

                        }

                    }else{

                        $spNewMatrix = DB::table('matrix')->where([
                                ['user_id', '=', $sp],
                                ['matrix_lvl', '=', $matrix_lvl+0.5],
                            ])->first();

                        if ( !$spNewMatrix ) {

                            DB::table('matrix')->insert([
                                'user_id' => $sp,
                                'matrix_lvl' => $matrix_lvl+0.5,
                                'matrix_active' => 1,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);

                        }
                    }

                }

                $shoulderG = array(2, 4, 8, 16, 32, 64, 128);

                $newPlace = $uplace;

                if ($newPlace > $shoulderG[$line-1]) {
                    $shoulder = 1;
                }else{
                    $shoulder = 0;
                }

                $referer_shoulder = 0;
                $referer_line = 1;

                DB::table('matrix_placers')->insert([
                    'matrix_id' => $matrix_id,
                    'referer_id' => $referer_id,
                    'shoulder' => $shoulder,
                    'referer_shoulder' => $referer_shoulder,
                    'line' => $current_line,
                    'referer_line' => $referer_line,
                    'user_id' => $user->id,
                    'user_place' => $uplace,
                    'referer_place' => $refposs,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            }else{
                // У спонсора новая матрица, у которой нет ID
                // Встаём к нему первыми

                $newMatrixID = DB::table('matrix_placers')->count()+1;

                DB::table('matrix_placers')->insert([
                    'matrix_id' => $newMatrixID,
                    'referer_id' => null,
                    'shoulder' => 0,
                    'referer_shoulder' => 0,
                    'line' => 1,
                    'referer_line' => 1,
                    'user_id' => $user->id,
                    'user_place' => 1,
                    'referer_place' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                // Добавляем спонсору созданную матрицу

                DB::table('matrix')->where([
                    ['user_id', '=', $sp],
                    ['matrix_lvl', '=', $matrix_lvl],
                ])->update(['matrix_id' => $newMatrixID]);

                // После создаём свою матрицу

                $myMatrix = DB::table('matrix')->where([
                        ['user_id', '=', $user->id],
                        ['matrix_lvl', '=', $matrix_lvl],
                    ])->first();

                if ( !$myMatrix ) {

                    DB::table('matrix')->insert([
                        'user_id' => $user->id,
                        'matrix_lvl' => $matrix_lvl,
                        'matrix_active' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    // Обновляем статус активации

                    DB::table('user_infos')->where([
                        ['user_id', '=', $user->id],
                    ])->update(['activated' => 1]);

                }

            }

        }else{
            // У спонсора нет активной матрицы
            $myMatrix = DB::table('matrix')->where([
                ['user_id', '=', $user->id],
                ['matrix_lvl', '=', $matrix_lvl],
            ])->first();

            if ( !$myMatrix ) {

            // У нас тоже нет активной матрицы этого уровня
            // Создаём матрицу и обновляем статус активации

            DB::table('matrix')->insert([
                'user_id' => $user->id,
                'matrix_lvl' => $matrix_lvl,
                'matrix_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('user_infos')->where([
                ['user_id', '=', $user->id],
            ])->update(['activated' => 1]);
            }
        }

        if( $line_pay != 0 ){
            // открываем новую матрицу и ставим под спонсора

            if( $line_reinv == 0 ){

                $spNewMatrix = DB::table('matrix')->where([
                    ['user_id', '=', $sp],
                    ['matrix_lvl', '=', $matrix_lvl+1],
                ])->first();

                if ( !$spNewMatrix ) {

                    DB::table('matrix')->insert([
                        'user_id' => $sp,
                        'matrix_lvl' => $matrix_lvl+1,
                        'matrix_active' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    return $this->activeNextLvl($sp, $matrix_lvl+1);

                }

            }else{

                $spNewMatrix = DB::table('matrix')->where([
                        ['user_id', '=', $sp],
                        ['matrix_lvl', '=', $matrix_lvl+0.5],
                    ])->first();

                if ( !$spNewMatrix ) {

                    DB::table('matrix')->insert([
                        'user_id' => $sp,
                        'matrix_lvl' => $matrix_lvl+0.5,
                        'matrix_active' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    return $this->activeNextLvl($sp, $matrix_lvl+0.5);

                }
            }

        }

        return 1;
    }

    public function activation(Request $request){

        // Данные для проверки
        $matrix_lvl = $request->matrix_lvl;
        $referer_id = 0;
        $uplace = 0;
        $refposs = 0;
        $inLineCollect = 0;
        $pInLastLine = 0;
        $userIndetificator = $request->id;

        for ($matrixGo=0; $matrixGo < 2; $matrixGo++) {

            $user = DB::table('users')->where('id', $userIndetificator )->first();

            // Проверяем есть ли у нас матрица

            $myMatrix = DB::table('matrix')->where([
                ['user_id', '=', $user->id],
                ['matrix_lvl', '=', $matrix_lvl],
            ])->first();

            if ( !$myMatrix ) {

                DB::table('matrix')->insert([
                'user_id' => $user->id,
                'matrix_lvl' => $matrix_lvl,
                'matrix_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                ]);

                // Обновляем статус активации

                DB::table('user_infos')->where([
                ['user_id', '=', $user->id],
                ])->update(['activated' => 1]);

            }

            // Берём спонсора и проверяем есть ли у него матрица
            $sp = $user->sponsor;

            if( $sp == null ){
                $sp = 18;
            }

            $lineG = array(4, 8, 16, 32, 64, 128, 256);

            $spmatrix = DB::table('matrix')->where([
                ['user_id', '=', $sp],
                ['matrix_lvl', '=', $matrix_lvl],
            ])->first();

            if( $spmatrix ){
                // Берём id активной матрицы
                $spmid = $spmatrix->matrix_id;

                if( $spmid ){
                    $matrix_id = $spmid;

                    for ($i=1; $i <= 7; $i++) {
                        $line = $i;
                        echo '----- Итерация # ' . $i . ' -----';
                        echo '<br>';

                        $current_line = $i;

                        $spmplacer = DB::table('matrix_placers')->where([
                            ['matrix_id', '=', $matrix_id],
                            ['line', '=', $i],
                        ])->orWhere([
                            ['referer_id', '=', $matrix_id],
                            ['referer_line', '=', $i],
                        ])->get();

                        $spmplacerCounter = $spmplacer->count();

                        if( $i > 1 ){
                            $spmplacerCounter = 0;

                            if( $i == 2 ){
                                $prevLine = DB::table('matrix_placers')->where([
                                    ['matrix_id', '=', $matrix_id],
                                    ['line', '=', $i - 1],
                                ])->orWhere([
                                    ['referer_id', '=', $matrix_id],
                                    ['referer_line', '=', $i - 1],
                                ])->get();
                            }else{
                                // Тут нужна сборная солянка с переливами

                                $prevLine = $inLineCollect;
                            }

                            echo 'Людей на прошлой линии: '.$pInLastLine;
                            echo '<br>';

                            $inLineCollect = collect();

                            for ($o=0; $o < $pInLastLine; $o++) {
                                $prevLineUser = $prevLine[$o];

                                $UsMatrix = DB::table('matrix')->where([
                                                ['user_id', '=', $prevLineUser->user_id],
                                                ['matrix_lvl', '=', $matrix_lvl],
                                            ])->first();

                                $prevMatrixId = $UsMatrix->matrix_id;

                                if( $prevMatrixId != null ){
                                    $minus = 1;
                                    if( $i >= 3 ){
                                        $minus = $i - 1;
                                    }
                                    $prevMatrixPlacer = DB::table('matrix_placers')->where([
                                        ['matrix_id', '=', $prevMatrixId],
                                        ['line', '=', $i-$minus],
                                        ['shoulder', '=', 0],
                                    ])->orWhere([
                                        ['referer_id', '=', $prevMatrixId],
                                        ['referer_line', '=', $i-$minus],
                                        ['referer_shoulder', '=', 0],
                                    ])->take(2)->get();

                                    if( $prevMatrixPlacer->count() == 1 ){
                                        $spmplacerCounter = $spmplacerCounter + 1;

                                        echo 'У пользователя '. $prevLineUser->user_id . ' на линии ' . $prevMatrixPlacer->count() . ' человек';
                                        echo '<br>';

                                        $inLineCollect = $inLineCollect->merge($prevMatrixPlacer);

                                    }elseif ( $prevMatrixPlacer->count() >= 2 ) {
                                        $spmplacerCounter = $spmplacerCounter + 2;

                                        echo 'У пользователя '. $prevLineUser->user_id . ' на линии более 2-ух человек';
                                        echo '<br>';

                                        $inLineCollect = $inLineCollect->merge($prevMatrixPlacer);
                                    }

                                }

                            }

                        }


                        if( $spmplacerCounter == $lineG[$i-1] ){

                            echo 'Линяя ' . $i . ' занята';
                            echo '<br>';
                            $lastLineCounter = array(4, 8, 16, 32, 64, 128, 256);

                            $pInLastLine = $lastLineCounter[$i - 1];

                        }else{

                            echo 'Свободна '.$i.' линяя';
                            echo '<br>';
                            echo 'Людей на линии: ' . $spmplacerCounter;
                            echo '<br>';

                            if( $i != 1 ){

                                for ($uplace=($spmplacerCounter + 1); $uplace <= $lineG[$i-1]; $uplace++) {

                                    echo '==== Проверка позиции: ' . $uplace . ' ====';
                                    echo '<br>';

                                    $rpos = 1;

                                    for ($n=1; $n <= $uplace; $n++) {
                                        if ( ($n - 1) % 2 == 0  && $n-1 != 0 ){
                                            $rpos++;
                                        }
                                    }

                                    echo 'Позиция вышестоящего: ' . $rpos;
                                    echo '<br>';

                                    echo 'Матрица вышестоящего: ' . $matrix_id;
                                    echo '<br>';

                                    $refmplacer = DB::table('matrix_placers')->where([
                                        ['matrix_id', '=', $matrix_id],
                                        ['line', '=', $i-1],
                                        ['user_place', '=', $rpos],
                                    ])->orWhere([
                                        ['referer_id', '=', $matrix_id],
                                        ['referer_line', '=', $i-1],
                                        ['referer_place', '=', $rpos],
                                    ])->first();

                                    if( $i >= 3 ){
                                        $refmplacer = $prevLine[$rpos-1];
                                    }

                                    $ruser_id = $refmplacer->user_id;


                                    $refmatrix = DB::table('matrix')->where([
                                        ['user_id', '=', $ruser_id],
                                        ['matrix_lvl', '=', $matrix_lvl],
                                    ])->first();

                                    if( $refmatrix->matrix_id == null ){
                                        echo 'Обновили данные матрицы';
                                        echo '<br>';

                                        $newMatrixID = DB::table('matrix_placers')->count()+1;

                                        DB::table('matrix')->where([
                                            ['user_id', '=', $ruser_id],
                                            ['matrix_lvl', '=', $matrix_lvl],
                                        ])->update(['matrix_id' => $newMatrixID]);
                                    }

                                    if( $refmatrix ){
                                        $referer_id = $refmatrix->matrix_id;

                                        $rmplacer = DB::table('matrix_placers')->where([
                                            ['matrix_id', '=', $referer_id],
                                            ['line', '=', 1],
                                            ['shoulder', '=', 0],
                                        ])->orWhere([
                                            ['referer_id', '=', $referer_id],
                                            ['referer_line', '=', 1],
                                            ['referer_shoulder', '=', 0],
                                        ])->get();


                                        if( $rmplacer->count() >= 2 ){
                                            echo 'Тут нельзя';
                                            echo '<br>';
                                        }else{

                                            $myRpos = $rmplacer->count() + 1;

                                            echo 'Можем разместиться';
                                            echo '<br>';
                                            echo 'Матрица вышестоящего: ' . $referer_id;
                                            echo '<br>';
                                            echo 'Наша в ней позиция: '.$myRpos;
                                            echo '<br>';

                                            $refposs = $myRpos;

                                            break;
                                        }
                                    }else{
                                        // У вышестоящего ещё не активирована матрица

                                        $newMatrixID = DB::table('matrix_placers')->count()+1;

                                        DB::table('matrix')->insert([
                                            'user_id' => $ruser_id,
                                            'matrix_lvl' => $matrix_lvl,
                                            'matrix_active' => 1,
                                            'matrix_id' => $newMatrixID,
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now()
                                        ]);

                                        $refposs = 1;
                                        $referer_id = $newMatrixID;

                                        echo 'Создали матрицу вышестоящему';
                                        echo '<br>';

                                        break;
                                    }

                                }

                            }else{
                                // Нет вышестоящего кроме спонсора
                                $uplace = $spmplacerCounter + 1;
                                $referer_id = null;
                                $refposs = $uplace;
                            }

                            break;

                        }

                    }

                    // exit;

                    $line_pay = 0;
                    $line_reinv = 0;

                    // Нужно ли двать деньги

                    if( $uplace == $lineG[$current_line - 1] ){
                        if( $matrix_lvl == 1 ){
                            switch ($current_line) {
                                case 1:
                                    $line_pay = 4000;
                                    $line_bonus = 0;
                                    break;
                                case 2:
                                    $line_pay = 3000;
                                    $line_bonus = 5000;
                                    break;
                                case 3:
                                    $line_pay = 11000;
                                    $line_bonus = 5000;
                                    break;
                                case 4:
                                    $line_pay = 27000;
                                    $line_bonus = 5000;
                                    break;
                                case 5:
                                    $line_pay = 59000;
                                    $line_bonus = 5000;
                                    break;
                                case 6:
                                    $line_pay = 123000;
                                    $line_bonus = 5000;
                                    break;
                                case 7:
                                    $line_pay = 246000;
                                    $line_bonus = 10000;
                                    break;
                            }
                        }elseif ( $matrix_lvl == 2 ) {
                            switch ($current_line) {
                                case 1:
                                    $line_pay = 20000;
                                    $line_bonus = 0;
                                    break;
                                case 2:
                                    $line_pay = 30000;
                                    $line_bonus = 10000;
                                    break;
                                case 3:
                                    $line_pay = 70000;
                                    $line_bonus = 10000;
                                    break;
                                case 4:
                                    $line_pay = 150000;
                                    $line_bonus = 10000;
                                    break;
                                case 5:
                                    $line_pay = 310000;
                                    $line_bonus = 10000;
                                    break;
                                case 6:
                                    $line_pay = 640000;
                                    $line_bonus = 10000;
                                    break;
                                case 7:
                                    $line_pay = 1260000;
                                    $line_bonus = 20000;
                                    break;
                            }
                        }elseif ( $matrix_lvl == 3 ) {
                            switch ($current_line) {
                                case 1:
                                    $line_pay = 40000;
                                    $line_bonus = 0;
                                    break;
                                case 2:
                                    $line_pay = 55000;
                                    $line_bonus = 25000;
                                    break;
                                case 3:
                                    $line_pay = 135000;
                                    $line_bonus = 25000;
                                    break;
                                case 4:
                                    $line_pay = 295000;
                                    $line_bonus = 25000;
                                    break;
                                case 5:
                                    $line_pay = 615000;
                                    $line_bonus = 25000;
                                    break;
                                case 6:
                                    $line_pay = 1255000;
                                    $line_bonus = 25000;
                                    break;
                                case 7:
                                    $line_pay = 2510000;
                                    $line_bonus = 50000;
                                    break;
                            }
                        }elseif ( $matrix_lvl == 4 ) {
                            switch ($current_line) {
                                case 1:
                                    $line_pay = 50000;
                                    $line_bonus = 50000;
                                    break;
                                case 2:
                                    $line_pay = 15000;
                                    $line_bonus = 50000;
                                    break;
                                case 3:
                                    $line_pay = 350000;
                                    $line_bonus = 50000;
                                    break;
                                case 4:
                                    $line_pay = 750000;
                                    $line_bonus = 50000;
                                    break;
                                case 5:
                                    $line_pay = 1550000;
                                    $line_bonus = 50000;
                                    break;
                                case 6:
                                    $line_pay = 3150000;
                                    $line_bonus = 50000;
                                    break;
                                case 7:
                                    $line_pay = 6350000;
                                    $line_bonus = 50000;
                                    break;
                            }
                        }elseif ( $matrix_lvl == 5 ) {
                            switch ($current_line) {
                                case 1:
                                    $line_pay = 50000;
                                    $line_bonus = 100000;
                                    $line_reinv = 50000;
                                    break;
                                case 2:
                                    $line_pay = 250000;
                                    $line_bonus = 100000;
                                    $line_reinv = 50000;
                                    break;
                                case 3:
                                    $line_pay = 650000;
                                    $line_bonus = 100000;
                                    $line_reinv = 50000;
                                    break;
                                case 4:
                                    $line_pay = 1450000;
                                    $line_bonus = 100000;
                                    $line_reinv = 50000;
                                    break;
                                case 5:
                                    $line_pay = 3050000;
                                    $line_bonus = 100000;
                                    $line_reinv = 50000;
                                    break;
                                case 6:
                                    $line_pay = 6250000;
                                    $line_bonus = 100000;
                                    $line_reinv = 50000;
                                    break;
                                case 7:
                                    $line_pay = 12650000;
                                    $line_bonus = 100000;
                                    $line_reinv = 50000;
                                    break;
                            }
                        }elseif ( $matrix_lvl == 6 ) {
                            switch ($current_line) {
                                case 1:
                                    $line_pay = 150000;
                                    $line_bonus = 250000;
                                    break;
                                case 2:
                                    $line_pay = 350000;
                                    $line_bonus = 250000;
                                    $line_reinv = 200000;
                                    break;
                                case 3:
                                    $line_pay = 1250000;
                                    $line_bonus = 250000;
                                    $line_reinv = 100000;
                                    break;
                                case 4:
                                    $line_pay = 2850000;
                                    $line_bonus = 250000;
                                    $line_reinv = 100000;
                                    break;
                                case 5:
                                    $line_pay = 6050000;
                                    $line_bonus = 250000;
                                    $line_reinv = 100000;
                                    break;
                                case 6:
                                    $line_pay = 12450000;
                                    $line_bonus = 250000;
                                    $line_reinv = 100000;
                                    break;
                                case 7:
                                    $line_pay = 25250000;
                                    $line_bonus = 250000;
                                    $line_reinv = 100000;
                                    break;
                            }
                        }elseif ( $matrix_lvl == 7 ) {
                            switch ($current_line) {
                                case 1:
                                    $line_pay = 500000;
                                    $line_bonus = 500000;
                                    $line_reinv = 250000;
                                    break;
                                case 2:
                                    $line_pay = 1250000;
                                    $line_bonus = 500000;
                                    $line_reinv = 250000;
                                    break;
                                case 3:
                                    $line_pay = 3250000;
                                    $line_bonus = 500000;
                                    $line_reinv = 250000;
                                    break;
                                case 4:
                                    $line_pay = 7250000;
                                    $line_bonus = 500000;
                                    $line_reinv = 250000;
                                    break;
                                case 5:
                                    $line_pay = 15250000;
                                    $line_bonus = 500000;
                                    $line_reinv = 250000;
                                    break;
                                case 6:
                                    $line_pay = 31250000;
                                    $line_bonus = 500000;
                                    $line_reinv = 250000;
                                    break;
                                case 7:
                                    $line_pay = 63250000;
                                    $line_bonus = 500000;
                                    $line_reinv = 250000;
                                    break;
                            }
                        }elseif ( $matrix_lvl == 8 ) {
                            switch ($current_line) {
                                case 1:
                                    $line_pay = 500000;
                                    $line_bonus = 1000000;
                                    $line_reinv = 500000;
                                    break;
                                case 2:
                                    $line_pay = 2500000;
                                    $line_bonus = 1000000;
                                    $line_reinv = 500000;
                                    break;
                                case 3:
                                    $line_pay = 6500000;
                                    $line_bonus = 1000000;
                                    $line_reinv = 500000;
                                    break;
                                case 4:
                                    $line_pay = 14500000;
                                    $line_bonus = 1000000;
                                    $line_reinv = 500000;
                                    break;
                                case 5:
                                    $line_pay = 30500000;
                                    $line_bonus = 1000000;
                                    $line_reinv = 500000;
                                    break;
                                case 6:
                                    $line_pay = 62500000;
                                    $line_bonus = 1000000;
                                    $line_reinv = 500000;
                                    break;
                                case 7:
                                    $line_pay = 126500000;
                                    $line_bonus = 1000000;
                                    $line_reinv = 500000;
                                    break;
                            }
                        }elseif ( $matrix_lvl == 9 ) {
                            switch ($current_line) {
                                case 1:
                                    $line_pay = 3000000;
                                    $line_reinv = 1000000;
                                    break;
                                case 2:
                                    $line_pay = 7000000;
                                    $line_reinv = 1000000;
                                    break;
                                case 3:
                                    $line_pay = 15000000;
                                    $line_reinv = 1000000;
                                    break;
                                case 4:
                                    $line_pay = 31000000;
                                    $line_reinv = 1000000;
                                    break;
                                case 5:
                                    $line_pay = 63000000;
                                    $line_reinv = 1000000;
                                    break;
                                case 6:
                                    $line_pay = 127000000;
                                    $line_reinv = 1000000;
                                    break;
                                case 7:
                                    $line_pay = 255000000;
                                    $line_reinv = 1000000;
                                    break;
                            }
                        }
                    }


                    $shoulderG = array(2, 4, 8, 16, 32, 64, 128);

                    $newPlace = $uplace;

                    if ($newPlace > $shoulderG[$line-1]) {
                        $shoulder = 1;
                    }else{
                        $shoulder = 0;
                    }

                    $referer_shoulder = 0;
                    $referer_line = 1;

                    DB::table('matrix_placers')->insert([
                        'matrix_id' => $matrix_id,
                        'referer_id' => $referer_id,
                        'shoulder' => $shoulder,
                        'referer_shoulder' => $referer_shoulder,
                        'line' => $current_line,
                        'referer_line' => $referer_line,
                        'user_id' => $user->id,
                        'user_place' => $uplace,
                        'referer_place' => $refposs,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    // Даём деньги если нужно и указываем данные для новой итерации
                    if( $line_pay != 0 ){
                        // Тут даём деньги спонсору и открываем новую матрицу
                        echo 'Даём деньги '. $sp .' в сумме '. $line_pay;

                        // Деньги

                        DB::table('user_infos')->where([
                            ['user_id', '=', $sp],
                        ])->increment('balance', $line_pay);

                        // Наши деньги

                        DB::table('user_infos')->where([
                            ['user_id', '=', $sp],
                        ])->increment('alter_balance', $line_bonus);

                        // Всего заработанно

                        DB::table('user_infos')->where([
                            ['user_id', '=', $sp],
                        ])->increment('earned', $line_pay);

                        if( $line_reinv == 0 ){

                            $spNewMatrix = DB::table('matrix')->where([
                                ['user_id', '=', $sp],
                                ['matrix_lvl', '=', $matrix_lvl+1],
                            ])->first();

                            if ( !$spNewMatrix ) {

                                DB::table('matrix')->insert([
                                    'user_id' => $sp,
                                    'matrix_lvl' => $matrix_lvl+1,
                                    'matrix_active' => 1,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);

                                $userIndetificator = $sp;
                                $matrix_lvl = $matrix_lvl+1;

                            }

                        }else{

                            $spNewMatrix = DB::table('matrix')->where([
                                    ['user_id', '=', $sp],
                                    ['matrix_lvl', '=', $matrix_lvl+0.5],
                                ])->first();

                            if ( !$spNewMatrix ) {

                                DB::table('matrix')->insert([
                                    'user_id' => $sp,
                                    'matrix_lvl' => $matrix_lvl+0.5,
                                    'matrix_active' => 1,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);

                                $userIndetificator = $sp;
                                $matrix_lvl = $matrix_lvl+0.5;

                            }
                        }

                    }else{
                        break;
                    }

                }else{
                    // У спонсора новая матрица, у которой нет ID
                    // Встаём к нему первыми

                    $newMatrixID = DB::table('matrix_placers')->count()+1;

                    DB::table('matrix_placers')->insert([
                        'matrix_id' => $newMatrixID,
                        'referer_id' => null,
                        'shoulder' => 0,
                        'referer_shoulder' => 0,
                        'line' => 1,
                        'referer_line' => 1,
                        'user_id' => $user->id,
                        'user_place' => 1,
                        'referer_place' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    // Добавляем спонсору созданную матрицу

                    DB::table('matrix')->where([
                        ['user_id', '=', $sp],
                        ['matrix_lvl', '=', $matrix_lvl],
                    ])->update(['matrix_id' => $newMatrixID]);

                    // После создаём свою матрицу

                    $myMatrix = DB::table('matrix')->where([
                            ['user_id', '=', $user->id],
                            ['matrix_lvl', '=', $matrix_lvl],
                        ])->first();

                    if ( !$myMatrix ) {

                        DB::table('matrix')->insert([
                            'user_id' => $user->id,
                            'matrix_lvl' => $matrix_lvl,
                            'matrix_active' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);

                        // Обновляем статус активации

                        DB::table('user_infos')->where([
                            ['user_id', '=', $user->id],
                        ])->update(['activated' => 1]);

                    }

                    break;

                }

            }else{
                // У спонсора нет активной матрицы
                $myMatrix = DB::table('matrix')->where([
                    ['user_id', '=', $user->id],
                    ['matrix_lvl', '=', $matrix_lvl],
                ])->first();

                if ( !$myMatrix ) {

                    // У нас тоже нет активной матрицы этого уровня
                    // Создаём матрицу и обновляем статус активации

                    DB::table('matrix')->insert([
                        'user_id' => $user->id,
                        'matrix_lvl' => $matrix_lvl,
                        'matrix_active' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    DB::table('user_infos')->where([
                        ['user_id', '=', $user->id],
                    ])->update(['activated' => 1]);

                }

                break;
            }

        }

        return 1;
    }
}
