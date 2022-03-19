<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ForgotRequest;
use App\User;
use Illuminate\Support\Str;
use DB;
use Mail;

class ForgotController extends Controller
{
    public function forgot(ForgotRequest $request)
    {
        $email = $request -> input('email');
        if(User::where('email', $email)->doesntExist())
        {
            return response([
                'message' => 'user doesn\'t exists'
            ]);
        }
        $token = Str::random(10);
     try   {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
        ]);
           //send email
            Mail::send('Email.forgot',  [
            'token' => $token, 
            ], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Paythru: Reset Password');
            }); 
    
        //     return response([
        //     'message' => 'check your mail!'
        // ]);
         }catch (\Exception $exception){
        return response([
            'message' => $exception -> getMessage()
        ], 400);
    }
    }

    public function Reset(ResetRequest $request){

        $token = $request->input('token');

        if($passwordReset = DB::table('password_resets')->where('token', $token)->first())

        {
                return response ([
                    'message' => 'Invalid token !'
                ], 403);
    }


    /** @var User $user  */

    
      if(!$user = User::where('email', $passwordReset->email)->first())
        {
            return response([
                'message' => 'User doesn\'t exist'
            ], 403);
        }

        $user->password = Hash::make($request->input('password'));
            $user->save();

            return response([
                'message' => 'success'
            ]);
    }
}
