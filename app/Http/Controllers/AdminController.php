<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    // Страницы

    public function admin(){

        $users = DB::table('users')
                    ->select('u2.login as sponsor_login', 'user_name' , 'user_surname', 'users.login', 'users.email', 'users.sponsor_counter', 'balance', 'activated', 'users.created_at')
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
                    ->paginate(5);

        $newCount = DB::table('news')->orderBy('news.id', 'DESC')->count();

        return view('account.admin.news', compact('news', 'newCount'));
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

        $path = $request->file('newsimg')->store('news/');

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
            DB::table('news')
            ->where('id', $request->edit)
            ->update([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $path,
                'updated_at' => Carbon::now(),
            ]);
        }

        return true;

    }
}
