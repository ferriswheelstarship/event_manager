<?php

namespace App\Http\Controllers\Auth;

use App\Mail\EmailVerification;
use App\User;
use App\Profile;
use App\Company_profile;
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
    protected $redirectTo = '/dashboard';

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
        // 施設ユーザ
        $company = User::where('role_id','3')->get();

        // 都道府県
        $pref = config('const.PREF');
        // 職種
        $job = config('const.JOB');
        // 保育士番号所持状況
        $childminder_status = config('const.CHILDMINDER_STATUS');

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
                return view('auth.main.register')->with('message', 'すでに本登録されています。ログインしてご利用ください。');
            }
            // ユーザーステータス更新
            $user->status = config('const.USER_STATUS.MAIL_AUTHED');
            //$user->verify_at = Carbon::now();
            if($user->save()) {
                return view('auth.main.register', compact('email_token','company','pref','job','childminder_status'));
            } else{
                return view('auth.main.register')->with('message', 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。');
            }
        }
    }
    
    public function mainCheck(Request $request)
    {
        $rules = [
            'password' => 'required|string|min:6|confirmed',
            'name' => 'required|string',
            'ruby' => 'required|string',
            'phone' => 'required|string',
            'zip' => 'required|string',
            'address' => 'required|string',
            'ruby' => 'required|string',
            'birth_year' => 'not_in:0',
            'birth_month' => 'not_in:0',
            'birth_day' => 'not_in:0',
            'company_profile_id' => 'not_in:0',
            'job' => 'not_in:0'
        ];

        if($request->company_profile_id === "なし") {
            $rules += [            
                'other_facility_name' => 'required|string',
                'other_facility_pref' => 'not_in:0',
                'other_facility_address' => 'required|string'
            ];
        }

        if($request->job === config('const.JOB.0')) {//「保育士」の場合
            $rules += [
                'childminder_status' => 'not_in:0'
            ];
            
            if($request->childminder_status == config('const.CHILDMINDER_STATUS.0')) {// 保育士番号ありの場合
                $rules += [
                    'childminder_number' => 'required|string'
                ];
            }
                    
        }
        $request->validate($rules);


        //データ保持用
        $email_token = $request->email_token;
    
        $profile = new Profile();
        $user = new User();
        
        $user->password = $request->password;
        $user->name = $request->name;
        $user->ruby = $request->ruby;
        $user->phone = $request->phone;
        $user->zip = $request->zip;
        $user->address = $request->address;
        $user->birth_year = $request->birth_year;
        $user->birth_month = $request->birth_month;
        $user->birth_day = $request->birth_day;
        $user->company_profile_id = $request->company_profile_id;
        if($user->company_profile_id === "なし") {
            $profile->other_facility_name = $request->other_facility_name;
            $profile->other_facility_pref = $request->other_facility_pref;
            $profile->other_facility_address = $request->other_facility_address;
            $user->company_profile_name = '兵庫県下に所属なし';
        } else {
            $profile->other_facility_name = null;
            $profile->other_facility_pref = null;
            $profile->other_facility_address = null;
            $user->company_profile_name = User::where('role_id','3')->where('company_profile_id',$user->company_profile_id)->value('name');
        }
        $profile->job = $request->job;
        if($profile->job == config('const.JOB.0')){
            $profile->childminder_status = $request->childminder_status;
            if($request->childminder_status == config('const.CHILDMINDER_STATUS.0')) {
                $profile->childminder_number = $request->childminder_number;
            } else {
                $profile->childminder_number = null;
            }
        } else {
            $profile->childminder_status = null;
        }
        
        // password マスキング
        $password_mask = '******';
        
        return view('auth.main.register_check', compact('profile','user','email_token','password_mask'));
    }
    
    public function mainRegister(Request $request)
    {
        $action = $request->get('action','入力へ戻る');
        $input = $request->except('action');
        $email_token = $request->email_token;

        if($action === '本登録') {

            $profile = new Profile();
            $profile->birth_year = $request->birth_year;
            $profile->birth_month = $request->birth_month;
            $profile->birth_day = $request->birth_day;
            if($request->company_profile_id === "なし") {
                $profile->other_facility_name = $request->other_facility_name;
                $profile->other_facility_pref = $request->other_facility_pref;
                $profile->other_facility_address = $request->other_facility_address;
            } else {
                $profile->other_facility_name = null;
                $profile->other_facility_pref = null;
                $profile->other_facility_address = null;
            }
            $profile->job = $request->job;
            if($profile->job == config('const.JOB.0')){
                $profile->childminder_status = $request->childminder_status;
                if($request->childminder_status == config('const.CHILDMINDER_STATUS.0')) {
                    $profile->childminder_number = $request->childminder_number;
                }
            } else {
                $profile->childminder_status = null;
            }
            $profile->save();

            $user = User::whereNotNull('email_verify_token')
                        ->where('email_verify_token',$request->email_token)
                        ->first();
            $user->profile_id = $profile->id;
            $user->company_profile_id = ($request->company_profile_id === "なし") ? null : $request->company_profile_id;
            $user->password = bcrypt($request->password);
            $user->status = config('const.USER_STATUS.REGISTER');
            $user->name = $request->name;
            $user->ruby = $request->ruby;
            $user->phone = $request->phone;
            $user->zip = $request->zip;
            $user->address = $request->address;
            $user->role_id = 4;
            $user->save();
            
            return view('auth.main.registered');
        } else {
             return redirect('register/verify/'.$email_token)
                ->withInput($input);
        } 
    }
}
