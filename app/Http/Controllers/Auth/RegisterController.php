<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailConfirm;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if( $data['mailConfirm'] == '' ){
            $code = rand(00000, 99999);
            session('code', $code);
            $code = session('code');
            Mail::to($data['email'])->send(new MailConfirm($code));
        }
        return Validator::make($data, [
            'mailConfirm' => ['required', 'in:'.session()->get('code').''],
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'sponsor' => ['string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ],
        [
            'mailConfirm.required' => 'Введите код для подтверждения почты.',
            'mailConfirm.in' => 'Код для подтверждения почты введён не правильно.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if( $data['referer'] == '' ){
            $sponsor = 1;
        }else{
            $sponsor = User::where('login', $data['referer'])->first();
            $sponsor = $sponsor->id;
        }

        $user = User::create([
            'login' => $data['login'],
            'email' => $data['email'],
            'sponsor' => $sponsor,
            'password' => Hash::make($data['password']),
        ]);

        User::where('id', $sponsor)->update([
            'sponsor_counter' => `sponsor_counter`+1,
        ]);

        $userId = $user->id;

        UserInfo::create([
            'user_id' => $userId,
        ]);

        return $user;

    }
}
