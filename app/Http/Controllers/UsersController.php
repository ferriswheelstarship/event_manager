<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Gate;
use Session;
use App\User;
use App\Role;
use App\Profile;
use App\Company_profile;


class UsersController extends Controller
{
    public function index()
    {
        $user_self = User::find(Auth::id());
        $areaRolePossible = [3,4];

        if(Gate::allows('system-only')){ // 特権ユーザのみ
            $users = User::orderBy('id', 'desc')->paginate(10);
        } elseif(Gate::allows('area-higher')){ // 支部ユーザ以上
            //$aaa = User::whereIn('role_id',$areaRolePossible)->orderBy('id', 'desc')->toSql();
            $users = User::whereIn('role_id',$areaRolePossible)->orderBy('id', 'desc')->paginate(10);
        } else { // 法人ユーザ
            $users = User::where('company_profile_id',$user_self->id)->orderBy('id', 'desc')->paginate(10);
        }

        return view('account.index', [
            'users' => $users,
        ]);
    }

    public function regist() {

        if(Gate::allows('area-higher')){
            if(Gate::allows('system-only')) {// 特権の選択可能ロール（支部・法人・個人）
                $role_array = [2=>'支部',3=>'法人',4=>'個人'];
            } else { // 支部権限の選択可能ロールは法人・個人。
                $role_array = [3=>'法人',4=>'個人'];
                return redirect('/account/edit/'.Auth::id());
            } 
            return view('account.regist',compact('role_array'));
        } else {
            return redirect('/account/edit/'.Auth::id());
        }
    }

    public function firstPost(Request $request)
    {

        $rules = [
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'name' => 'required|string',
            'ruby' => 'required|string',
            'role_id' => 'required|numeric',
            'phone' => 'required|string',
            'zip' => 'required|string',
            'address' => 'required|string',
        ]; 
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('/account/regist/new')
                        ->withErrors($validator)
                        ->withInput();    
        }
        return redirect()->route('account.registNext')->withInput();
    }


    public function registNext()
    {
        $postdata = Session::get('_old_input');
        //dd($postdata);

        // 施設ユーザ名
        $company = User::where('role_id','3')->get();

        if($postdata["role_id"] == 2) {
            return redirect()->route('account.create')->withInput();
        } else {
            return view('account.registNext',compact('postdata'));
        }

    }

    public function create(Request $request)
    {

        if($request->role_id == 4) { // 個人ユーザを選択時のルール追加
            $rules = [
                'birth_year' => 'required|numeric',
                'birth_month' => 'required|numeric',
                'birth_day' => 'required|numeric',
                'job' => 'required',
                'serial_number' => 'required|string',
            ];
        } elseif($request->role_id == 3) { // 法人ユーザを選択時のルール追加
            $rules = [
                'area_name' => 'required|string',
                'branch_name' => 'required|string',
                'company_variation' => 'required|string',
                'public_or_private' => 'required|string',
                'category' => 'required|string',
                'fax' => 'required|string',
                'kyokai_number' => 'required',
            ];
        }
        $request->validate($rules);


        $user = new User;
        if($request->role_id == 4) { // 個人ユーザを選択時profiles生成

            $profile = Profile::create([
                'birth_year' => $request['birth_year'],
                'birth_month' => $request['birth_month'],
                'birth_day' => $request['birth_day'],
            ]);
            
            $user->profile_id = $profile->id;
            if($request['company_profile_id']){
                $user->company_profile_id = $request['company_profile_id'];
            }
            
        } elseif($request->role_id == 3) { // 法人ユーザを選択時company_profiles生成

            $company_profile = Company_profile::create([
                'area_name' => $request['area_name'],
                'branch_name' => $request['branch_name'],
                'company_variation' => $request['company_variation'],
                'public_or_private' => $request['public_or_private'],
                'category' => $request['category'],
                'fax' => $request['fax'],
                'kyokai_number' => $request['kyokai_number'],
            ]);

        } 

        $user->email = $request->email;
        $user->email_verify_token = base64_encode($request->email);
        $user->password = bcrypt($request->password);
        $user->name = $request->name;
        $user->ruby = $request->ruby;
        $user->phone = $request->phone;
        $user->zip = $request->zip;
        $user->address = $request->address;
        $user->role_id = $request->role_id;
        $user->status = 1;

        dd($user);

        $user->save();
        
        session()->flash('status', 'ユーザ情報の登録が完了しました。'); 
        return redirect('account');
    }

    public function show($id)
    {
        $user = User::find($id);
        $userSelf = User::find(Auth::id());
        $userSelfRole = $userSelf->role->level;

        if(Gate::allows('user-hihger')){ // 個人ユーザ
            if (Auth::id() != $id) { // 認証済ID（自分）のみ許可
                return redirect('/account/edit/'.Auth::id());
            }
        } elseif(Gate::allows('area-higher')) { // 支部ユーザ以上
            if($user->role->level < $userSelfRole){
                return redirect('/account/edit/'.Auth::id());
            }
        }

        return view('account.show', [
            'user' => $user,
        ]);        

    }
    
    public function edit($id)
    {
        $user = User::find($id);

        $profile = Profile::find($user->id);
        $user->birth_year = $profile->birth_year;
        $user->birth_month = $profile->birth_month;
        $user->birth_day = $profile->birth_day;

        return view('account.edit', ['user' => $user]); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
          'name' => 'required|string',
          'ruby' => 'required|string',
          'birth_year' => 'required|numeric',
          'birth_month' => 'required|numeric',
          'birth_day' => 'required|numeric',
        ]);

        $user = User::find($id);
        $profile = Profile::find($user->id);
        
        $user->name = $request->name;
        $user->ruby = $request->ruby;
        $user->save();

        $profile->birth_year = $request->birth_year;
        $profile->birth_month = $request->birth_month;
        $profile->birth_day = $request->birth_day;
        $profile->save();

        session()->flash('status', 'ユーザ情報の変更が完了しました。'); 
        return redirect('/account/edit/'.$id);

    }

    public function destroy($id)
    {
        //
    }
}
