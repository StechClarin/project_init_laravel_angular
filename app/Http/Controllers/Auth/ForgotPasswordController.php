<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\{User};
use App\Notifications\PasswordReset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendPasswordResetToken(Request $request)
    {
        $user = User::where('email', $request->email)->first();
       
        if (!$user) return redirect()->back()->withInput($request->all())->with('error', 'Adresse email introuvable !');
        
        if(isset($request->password, $request->password_confirmation, $request->token))
        {
            $tokenData = DB::table('password_resets')->where('email', $request->email)->where('token', $request->token)->first();
            
            if (!isset($tokenData))
            {
                return redirect()->back()->with('error', 'Impossible de modifier le mot de passe');
            }

            if($request->password != $request->password_confirmation)
            {
                return redirect()->back()->withInput($request->all())->with('error', 'Les deux mots de passe ne correspondent pas !');
            }
            else
            {
                if (isset($request->password) || isset($request->password_confirmation))
                {
                    if(strlen($request->password) <=6)
                    {
                        return redirect()->back()->withInput($request->all())->with('error', "Mot de passse trop court");
                    }
                    else if($request->password !=$request->password_confirmation)
                    {
                        return redirect()->back()->withInput($request->all())->with('error', "Les mots de passe ne correspondent pas");
                    }
                }
                $user->password = $request->password;
                $user->save();
                return redirect('login');
            }
        }

        $token=csrf_token();

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token, //change 60 to any length you want
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')->where('email', $request->email)->where('token',$token)->first();
        $token = $tokenData->token;
        $user->notify(new PasswordReset($token));
        return redirect()->back()->with('success', 'Un lien de reinitialisation vous a été envoyé dans votre boite email');
    }

    public function showPasswordResetForm($token)
    {
        $tokenData = DB::table('password_resets')->where('token', $token)->first();
        if (isset($tokenData))
        {
            $token = $tokenData->token;
            return view('auth.reset-password', ['email' => $tokenData->email, 'token' => $token]);
        }
        else
        {
            return redirect('login')->with('error', 'Token invalide');
        }
    }

}
