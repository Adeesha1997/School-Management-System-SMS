<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\User;
use App\Mail\ForgetPasswordMail;
use Mail;
use Str;

class AuthController extends Controller
{
    public function login()
    {
      
       if(!empty(Auth::check()))
       {
        return redirect('admin/dashboard');
       }
       return view('auth.login');
    }


    public function authLogin(Request $request)
    {

        $remember = !empty($request->remember) ?true : false;
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], true))
        {
                if(Auth::user()->user_type ==1)
                {
                    return redirect('admin/dashboard');
                }
                else if(Auth::user()->user_type ==2)
                {
                    return redirect('teacher/dashboard');
                }
                else if(Auth::user()->user_type ==3)
                {
                    return redirect('student/dashboard');
                }
                else if(Auth::user()->user_type ==4)
                {
                    return redirect('parent/dashboard');
                }

        }
        else
        {
            return redirect()->back()->with('error', 'Please enter current email and password');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }

    public function forgotpassword()
    {
        $data['header_title'] = 'Forgot Password';
        return view('auth.forgot' , $data);
    }

    public function ChangeForgetPassword(Request $request)
    {
        $user = User::getEmailSingle($request->email);
        if(!empty($user))
        {
            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->email)->send(new ForgetPasswordMail($user));
            return redirect()->back()->with('success' , "Please Check your inbox !");

        }else{
            return redirect()->back()->with('error' , "Email not found in the system !");
        }
    }

    public function reset($remember_token)
    {
        $user = User::getTokenSingle($remember_token);
       if(!empty($user))
       {     $data1['header_title'] = 'Reset Password';
            $data['user'] = $user;
            return view('auth.reset' , $data , $data1);

       }
       else
       {
            abort(404);

       }
    }


    public function PostReset($token, Request $request)
    {
        if($request->password == $request->cpassword)
        {
            $user = User::getTokenSingle($token);
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();
            return redirect(url(''))->with('success' , "Password reset successfully !");
        }
        else
        {
            return redirect()->back()->with('error' , "Password and Confirm Password does not match !");

        }
    }

}
