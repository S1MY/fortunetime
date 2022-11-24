<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function show(UserInfo $userInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(UserInfo $userInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, $id)
    {
        if( Auth::user()->UserInfo->account_password == null ){
            UserInfo::where('user_id', $id)->update([
                'account_password' => Hash::make($request['pincode']),
            ]);
        }else{
            return 1;
        }

        return true;
    }

    public function output(Request $request){

        $pincode = $request['amount_pincode'];

        $codeVerify = DB::table('user_infos')->where([
            ['user_id', '=', Auth::user()->id],
        ])->first();

        if ( !Hash::check($pincode, $codeVerify->account_password)) {
            session()->flash('warning', 'Не правильно введён пинкод!');
        }else{
            if( $request['amount'] > $codeVerify->balance ){
                session()->flash('warning', 'Данная сумма больше вашего баланса!');
            }else{
                DB::table('outputs')->insert([
                    'user_id' =>  Auth::user()->id,
                    'status' => $request['amount'],
                    'amount' => $request['req'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::table('user_infos')->where([
                    ['user_id', '=', Auth::user()->id],
                ])->decrement('balance', $request['amount']);

                session()->flash('success', 'Заявка на вывод успешно поступила!');
            }
        }

        return 1;
    }

    public function updateAvatar(Request $request, $id)
    {

        // return $request;

        $user = User::where('id', $id)->first();

        $path = $request->file('img')->store('users/'.$user['login']);

        UserInfo::where('user_id', $id)->update([
            'avatar' => $path,
        ]);

        return true;
    }

    public function getMatrix($id, $lvl){

        $user = DB::table('users')->where('id', '=', $id)->first();

        $matrix = DB::table('matrix')->where([
            ['user_id', '=', $id],
            ['matrix_lvl', '=', $lvl],
        ])->first();

        dd($matrix);

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
                                ['matrix_lvl', '=', $lvl],
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

                        $usLine = $matrixInfosUs[$m]->line;

                        $UsMatrixLine = DB::table('matrix')->where([
                                        ['user_id', '=', $usID2],
                                        ['matrix_lvl', '=', $lvl],
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

        return view('account.layout.matrix', compact('matrix', 'matrixInfos', 'matrixUsersCount'));
    }

    public function updatePersonalInfo(Request $request, $id)
    {

        // return $request;

        $user = User::where('id', $id)->first();

        if( !$user ){
            return false;
        }

        UserInfo::where('user_id', $id)->update([
            'user_name' => $request->name,
            'user_surname' => $request->surname,
        ]);

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserInfo $userInfo)
    {
        //
    }
}
