<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Models\User;
use App\Models\UserInfo;
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

        $matrix = DB::table('matrix')->where([
            ['user_id', '=', $id],
            ['matrix_lvl', '=', $lvl],
        ])->first();

        $matrixInfos = '';
        $matrixUsersCount = '';

        if($matrix != null){

            $matrixInfos = DB::table('users')
            ->leftJoin('matrix_placers', 'users.id', '=', 'matrix_placers.user_id')
            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->where('matrix_placers.matrix_id', $matrix->matrix_id)
            ->get();

            $matrixUsersCount = $matrixInfos->count();

        }

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
