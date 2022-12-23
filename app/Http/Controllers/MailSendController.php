<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Mail\SendMail;
use App\Models\User;
use App\Mail\SendPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\isNull;

class MailSendController extends Controller
{
    public function sendMailContact(MailRequest $request){

        if( $request->surname == '' ){
            $name = $request->name;
            $email = $request->email;
            $question = $request->question;

            $supportMail = 'S1MY.PJ@yandex.ru';
            Mail::to($supportMail)->send(new SendMail($name, $email, $question));
        }else{
            return 'fucking spammers';
        }

        return true;

    }

    public function changePassword(Request $request){

        $user = User::where('email', '=', $request->email)->count();

        if( $user > 0 ){

            $code = rand(00000, 9999999);

            Mail::to($request->email)->send(new SendPassword($code));

            $user = User::where('email', '=', $request->email)->update([
                'password' => Hash::make($code),
            ]);

            return response()->json([
                'error' => 0,
                'message' => 'На вашу почту отправлен новый пароль, вы можете его изменить в личном кабинете.'
            ]);
        }else{
            return response()->json([
                'error' => 1,
                'message' => 'Пользователя с данным E-Mail адрессом не существует.'
            ]);
        }

        return $request;

    }

}
