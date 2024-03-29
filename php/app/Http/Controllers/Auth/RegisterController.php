<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mail\EmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

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
    protected $redirectTo = '/home';

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
        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);


        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verify_token' => base64_encode($data['email']),
        ]);
        // logger($user);
        $email = new EmailVerification($user);
        Mail::to($user->email)->send($email);
        return $user;
    }


    public function pre_check(Request $request)
    {
        $this->validator($request->all())->validate();
        $request->flashOnly('email');
        $bridge_request = $request->all();
        $bridge_request['password_mask'] = '******';
        return view('auth.register_check')->with($bridge_request);
    }

    public function registered(Request $request)
    {
        logger($request);
        event(new Registered($user = $this->create($request->all())));
        return view('auth.registered');
    }

    public function showForm($token)
    {
        logger("token".$token);
        if (!User::where('email_verify_token', $token)->exists()) {
            return view('auth.main.register')->with('message', '無効なトークンです。');
        } else {
            $user = User::where('email_verify_token', $token)->first();
            // 本登録済みユーザーか
            if ($user->status == '1') //REGISTER = 1
            {
                logger("status" . $user->status);
                return view('auth.main.register')->with('message', '既に登録されています。ログインして利用してください。');
            }
            // ユーザーステータス更新
            $user->status = '2';
            if ($user->save()) {
                $email_token = $token;
                return view('auth.main.register', compact('email_token'));
            } else {
                return view('auth.main.register')->with('message', 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。');
            }
        }
    }


    public function mainCheck(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'name_pronunciation' => 'required|string',
            'birth_year' => 'required|numeric',
            'birth_month' => 'required|numeric',
            'birth_day' => 'required|numeric',
        ]);

        $email_token = $request->email_token;
        logger("Request" . $request);
        $user = new User();
        $user->name = $request->name;
        $user->name_pronunciation = $request->name_pronunciation;
        $user->birth_year = $request->birth_year;
        $user->month = $request->birth_month;
        $user->birth_day = $request->birth_day;
        

        return view('auth.main.register_check', compact('user', 'email_token'));
    }



    public function mainRegister(Request $request)
    {
        $user = User::where('email_verify_token', $request->email_token)->first();
        logger("Request_save" . $request);
        $user->status = '2';
        $user->name = $request->name;
        $user->name_pronunciation = $request->name_pronunciation;
        $user->birth_year = $request->birth_year;
        $user->birth_month = $request->birth_month;
        $user->birth_day = $request->birth_day;
        $user->save();

        return view('auth.main.registered');
    }
}
