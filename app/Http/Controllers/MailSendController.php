<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\isNull;

class MailSendController extends Controller
{
    public function sendMailContact(MailRequest $request){

        dd($request);

        // if( isNull($request->forwhat) )
        // {
        //     $name = $request->name;
        //     $email = $request->email;
        //     $question = $request->question;

        //     $supportMail = 'S1MY.PJ@yandex.ru';
        //     Mail::to($supportMail)->send(new SendMail($name, $email, $question));
        // }else{
        //     return 'fucking spammers';
        // }

        // return true;
    }

}
