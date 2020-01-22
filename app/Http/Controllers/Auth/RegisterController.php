<?php

namespace App\Http\Controllers\Auth;

use App\Mail\EmailVerification;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

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
            'email' => 'required|string|email|max:191|unique:users',
        ]);
    }

    protected function validator_except_unique(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:191',
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
        if(User::where('email',$data['email'])->exists()) {
            $user = User::where('email',$data['email'])->first();
            if($user->name) {
                $this->validator($data)->validate();
            } else {
                $this->validator_except_unique($data)->validate();
                $email = new EmailVerification($user);
                Mail::to($user->email)->send($email);
            }
        } else {
            $this->validator($data)->validate();
            $user = User::create([
                    'email' => $data['email'],
                    'email_verify_token' => base64_encode($data['email'])
            ]);
                
            $email = new EmailVerification($user);
            Mail::to($user->email)->send($email);

        }

        return $user;
    }
    
    public function register(Request $request)
    {
        event(new Registered($user = $this->create( $request->all() )));

        return view('auth.registered');
    }
    
    public function showForm($email_token)
    {
        // 使用可能なトークンか
        if ( !User::where('email_verify_token',$email_token)->exists() )
        {
            return view('auth.main.register')->with('message', '無効なトークンです。');
        } else {
            $user = User::where('email_verify_token', $email_token)->first();
            // 本登録済みユーザーか
            if ($user->status == config('const.USER_STATUS.REGISTER')) //REGISTER=1
            {
                logger("status". $user->status );
                return view('auth.main.register')->with('message', 'すでに本登録されています。ログインして利用してください。');
            }
            // ユーザーステータス更新
            $user->status = config('const.USER_STATUS.MAIL_AUTHED');
            //$user->verify_at = Carbon::now();
            if($user->save()) {
                return view('auth.main.register', compact('email_token'));
            } else{
                return view('auth.main.register')->with('message', 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。');
            }
        }
    }
    
    public function mainCheck(Request $request)
    {
        $request->validate([
          'password' => 'required|string|min:6|confirmed',
          'name' => 'required|string',
          'ruby' => 'required|string',
          'birth_year' => 'required|numeric',
          'birth_month' => 'required|numeric',
          'birth_day' => 'required|numeric',
        ]);
        
        //データ保持用
        $email_token = $request->email_token;
    
        $user = new User();
        $user->password = $request->password;
        $user->name = $request->name;
        $user->ruby = $request->ruby;
        $user->birth_year = $request->birth_year;
        $user->birth_month = $request->birth_month;
        $user->birth_day = $request->birth_day;
        
        // password マスキング
        $password_mask = '******';
    
        return view('auth.main.register_check', compact('user','email_token','password_mask'));
    }
    
    public function mainRegister(Request $request)
    {
        $action = $request->get('action','入力へ戻る');

        $input = $request->except('action');
        $email_token = $request->email_token;
        

        if($action === '本登録') {
            $user = User::whereNotNull('email_verify_token')
                        ->where('email_verify_token',$request->email_token)
                        ->first();
            $user->password = bcrypt($request->password);
            $user->status = config('const.USER_STATUS.REGISTER');
            $user->name = $request->name;
            $user->ruby = $request->ruby;
            $user->birth_year = $request->birth_year;
            $user->birth_month = $request->birth_month;
            $user->birth_day = $request->birth_day;
            $user->role_id = 3;
            $user->save();
            
            return view('auth.main.registered');
        } else {
             return redirect('register/verify/'.$email_token)
                ->withInput($input);
        } 
    }
}
