<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class MailSendController extends Controller
{
    public function sendMailContact(MailRequest $request){

        $name = $request->name;
        $email = $request->email;
        $question = $request->question;

        $supportMail = 'S1MY.PJ@mail.ru';
        Mail::to($supportMail)->send(new SendMail($name, $email, $question));
        return true;
    }
}
