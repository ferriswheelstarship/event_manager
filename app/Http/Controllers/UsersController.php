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

        if(Gate::allows('system-only')){ // 特権ユーザのみ
            $users = User::withTrashed()->orderBy('id', 'desc')->paginate(10);            
        } elseif(Gate::allows('admin-only')){ // 法人ユーザのみ
            $users = User::where('company_profile_id',$user_self->id)->orderBy('id', 'desc')->paginate(10);
        } else {
            return redirect('/account/edit/'.Auth::id());
        }
        $account_status = [1=>'有効',2=>'休止中'];
        $role_array = config('const.AUTH_STATUS_JP');
        return view('account.index',compact('users','role_array','account_status'));
    }

    public function regist() 
    {

        if(Gate::denies('system-only')) {
            return redirect('/account/edit/'.Auth::id());
        }

        $role_array = config('const.AUTH_STATUS_JP');
        return view('account.regist',compact('role_array'));

    }

    public function firstPost(Request $request)
    {

        $rules = [
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'name' => 'required|string',
            'ruby' => 'required|string',
            'role_id' => 'not_in:0',
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
        session()->put('firstPost', $request->all());

        if($request->role_id <= 2) {
            return $this->create($request);
        } else {
            return redirect()->route('account.registNext')->withInput();
        }

    }


    public function registNext()
    {
        $postdata = session()->get('firstPost');

        // 施設ユーザ
        $company = User::where('role_id','3')->get();

        // 地区名
        $area_name = config('const.AREA_NAME');

        // 支部名
        $branch_name = config('const.BRANCH_NAME');

        // 設置主体
        $company_variation = config('const.COMPANY_VARIATION');

        // こども園類型
        $category = config('const.CATEGORY');

        // 保育士番号所持状況
        $childminder_status = config('const.CHILDMINDER_STATUS');

        return view('account.registNext',
            compact('postdata','company','area_name','branch_name','company_variation','category','childminder_status')
        );

    }

    public function create(Request $request)
    {
        if($request->role_id == 4) { // 個人を選択時
            
            $rules = [
                'birth_year' => 'not_in:0',
                'birth_month' => 'not_in:0',
                'birth_day' => 'not_in:0',
                'company_profile_id' => 'not_in:0',
                'childminder_status' => 'not_in:0',
            ];

            if($request->company_profile_id == "なし") {
                $rules += [            
                    'other_facility_name' => 'required|string',
                    'other_facility_zip' => 'required|string',
                    'other_facility_address' => 'required|string',
                ];
            }

            if($request->childminder_status == config('const.CHILDMINDER_STATUS.0')) {
                $rules += [
                    'childminder_number' => 'required|string',
                ];
            }


        } elseif($request->role_id == 3) { // 法人を選択時
            $rules = [
                'area_name' => 'not_in:0',
                'branch_name' => 'not_in:0',
                'company_variation' => 'not_in:0',
                'category' => 'not_in:0',
                'fax' => 'required|string',
                'kyokai_number' => 'required|string',
            ];
        } else {
            $rules = [];
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
            if($request['company_profile_id'] && $request['company_profile_id'] != ""){
                $user->company_profile_id = $request['company_profile_id'];
            }
            
        } elseif($request->role_id == 3) { // 法人ユーザを選択時company_profiles生成
            
            $public_or_private = ($request['company_variation'] === '市町村') ? '公' : '私';

            $company_profile = Company_profile::create([
                'area_name' => $request['area_name'],
                'branch_name' => $request['branch_name'],
                'company_variation' => $request['company_variation'],
                'public_or_private' => $public_or_private,
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
        $user->save();
        
        return redirect()->route('account.index')->with('status','ユーザ情報の登録が完了しました。');
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

        if($user->role_id == 4) {
            $profile = Profile::find($user->id);
            if($user->company_profile_id) {
                $companyUser = User::find($user->company_profile_id)->name;
            } else {
                $companyUser = $profile->other_facility_name;
            }
        } elseif($user->role_id == 3) {
            $profile = Company_profile::find($user->id);
            $companyUser = null;
        } else {
            $companyUser = null;
        }

        return view('account.show', compact('user','profile','companyUser'));

    }
    
    public function edit($id)
    {
        $user = User::find($id);

        // 施設ユーザ
        $company = User::where('role_id','3')->get();
        // 地区名
        $area_name = config('const.AREA_NAME');
        // 支部名
        $branch_name = config('const.BRANCH_NAME');
        // 設置主体
        $company_variation = config('const.COMPANY_VARIATION');
        // こども園類型
        $category = config('const.CATEGORY');
        // 保育士番号所持状況
        $childminder_status = config('const.CHILDMINDER_STATUS');

        if($user->role_id == 4) {
            $profile = Profile::find($user->id);
        } elseif($user->role_id == 3) {
            $profile = Company_profile::find($user->id);
        } else {
            $profile = [];
        }

        return view('account.edit', 
            compact('user','profile','company','area_name','branch_name','company_variation','category','childminder_status')
        ); 
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $rules = [
            'name' => 'required|string',
            'ruby' => 'required|string',
            'phone' => 'required|string',
            'zip' => 'required|string',
            'address' => 'required|string',
        ];
        if($user->email != $request->email) {
            $rules += [
                'email' => 'required|string|email|max:191|unique:users',
            ];
        }

        if($user->role_id == 4) { // 個人ユーザ
            
            $rules += [
                'birth_year' => 'not_in:0',
                'birth_month' => 'not_in:0',
                'birth_day' => 'not_in:0',
                'company_profile_id' => 'not_in:0',
                'childminder_status' => 'not_in:0',
            ];

            if($request->company_profile_id === "なし") {
                $rules += [            
                    'other_facility_name' => 'required|string',
                    'other_facility_zip' => 'required|string',
                    'other_facility_address' => 'required|string',
                ];
            }

            if($request->childminder_status == config('const.CHILDMINDER_STATUS.0')) {
                $rules += [
                    'childminder_number' => 'required|string',
                ];
            }

        } elseif($user->role_id == 3) { // 法人ユーザ
            $rules += [
                'area_name' => 'not_in:0',
                'branch_name' => 'not_in:0',
                'company_variation' => 'not_in:0',
                'category' => 'not_in:0',
                'fax' => 'required|string',
                'kyokai_number' => 'required|string',
            ];
        }
        $request->validate($rules);
        
        if($user->role_id == 4) {
            $profile = Profile::find($user->id);
            $profile->birth_year = $request->birth_year;
            $profile->birth_month = $request->birth_month;
            $profile->birth_day = $request->birth_day;
            $profile->childminder_status = $request->childminder_status;

            if($request->company_profile_id === "なし") {
                $user->company_profile_id = null;
                $profile->other_facility_name = $request->other_facility_name;
                $profile->other_facility_zip = $request->other_facility_zip;
                $profile->other_facility_address = $request->other_facility_address;
            } elseif($request->company_profile_id) {
                $user->company_profile_id = $request->company_profile_id;
                $profile->other_facility_name = null;
                $profile->other_facility_zip = null;
                $profile->other_facility_address = null;
            }

            if($profile->childminder_status === config('const.CHILDMINDER_STATUS.0')) {
                $profile->childminder_number = $request->childminder_number;
            } else {
                $profile->childminder_number = null;
            }

            $profile->save();

        } elseif($user->role_id == 3) {
            
            $public_or_private = ($request->company_variation === '市町村') ? '公' : '私';

            $profile = Company_profile::find($user->id);
            $profile->area_name = $request->area_name;
            $profile->company_variation = $request->company_variation;
            $profile->public_or_private = $public_or_private;
            $profile->category = $request->category;
            $profile->fax = $request->fax;
            $profile->kyokai_number = $request->kyokai_number;

            $profile->save();
        }

        $user->name = $request->name;
        $user->ruby = $request->ruby;
        $user->phone = $request->phone;
        $user->zip = $request->zip;
        $user->address = $request->address;
        $user->save();

        //session()->flash('status', 'ユーザ情報の変更が完了しました。'); 
        return redirect('/account/edit/'.$id)->with('status','ユーザ情報の変更が完了しました。');

    }

    public function trimcompany($id) {
        $user = User::find($id);
        $user->company_profile_id = null;
        $user->save();
        return redirect()->route('account.index')->with('status','指定ユーザの所属施設設定を解除しました。');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('account.index')->with('status','指定ユーザのアカウントを休止しました。');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->restore();
        return redirect()->route('account.index')->with('status','指定ユーザのアカウントを復元しました。');
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->forceDelete();
        return redirect()->route('account.index')->with('status','指定ユーザのアカウントを削除しました。削除したユーザは復元できません。');
    }
}