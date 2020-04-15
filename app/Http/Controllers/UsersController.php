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
            $users = User::withTrashed()
                            ->where('status',1)
                            ->orderBy('id', 'desc')
                            ->get();
        } elseif(Gate::allows('admin-only')){ // 法人ユーザのみ
            $users = User::where('status',1)
                            ->where('role_id',4)
                            ->where('company_profile_id',$user_self->company_profile_id)
                            ->orderBy('id', 'desc')
                            ->get();
        } else {
            return redirect('/account/edit/'.Auth::id());
        }
        $account_status = [1=>'有効',2=>'退会'];
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
        if(Gate::denies('system-only')) {
            return redirect('/account/edit/'.Auth::id());
        }

        $rules = [
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'not_in:0',
            'phone' => 'required|string',
            'zip' => 'required|string',
            'address' => 'required|string',
        ]; 

        if($request->role_id == 4) {
            $rules = [
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'firstruby' => 'required|string',
                'lastruby' => 'required|string',
            ];
        } else {
            $rules = [
                'name' => 'required|string',
                'ruby' => 'required|string',
            ];
        }
        $request->validate($rules);
        //$validator = Validator::make($request->all(), $rules);
        // if ($validator->fails()) {
        //     return redirect('/account/regist/new')
        //                 ->withErrors($validator)
        //                 ->withInput();    
        // }
        session()->put('firstPost', $request->all());

        if($request->role_id <= 2) {
            return $this->create($request);
        } else {
            return redirect()->route('account.registNext')->withInput();
        }

    }


    public function registNext()
    {
        if(Gate::denies('system-only')) {
            return redirect('/account/edit/'.Auth::id());
        }

        $postdata = session()->get('firstPost');
        $postdata['name'] = ($postdata['role_id'] == 4) ? $postdata['firstname'].'　'.$postdata['lastname'] : $postdata['name'];
        $postdata['ruby'] = ($postdata['role_id'] == 4) ? $postdata['firstruby'].'　'.$postdata['lastruby'] : $postdata['ruby'];

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
        // 都道府県
        $pref = config('const.PREF');
        // 職種
        $job = config('const.JOB');
        // 保育士番号所持状況
        $childminder_status = config('const.CHILDMINDER_STATUS');

        return view('account.registNext',
            compact('postdata','company','area_name','branch_name','company_variation','category','pref','job','childminder_status')
        );

    }

    public function create(Request $request)
    {

        if(Gate::denies('system-only')) {
            return redirect('/account/edit/'.Auth::id());
        }


        if($request->role_id == 4) { // 個人を選択時
            
            $rules = [
                'birth_year' => 'not_in:0',
                'birth_month' => 'not_in:0',
                'birth_day' => 'not_in:0',
                'company_profile_id' => 'not_in:0',
                'job' => 'not_in:0'
            ];

            if($request->company_profile_id == "なし") {
                $rules += [            
                    'other_facility_name' => 'required|string',
                    'other_facility_pref' => 'not_in:0',
                    'other_facility_address' => 'required|string',
                ];
            }
            if($request->job === config('const.JOB.0')) {//「保育士」の場合
                $rules += [
                    'childminder_status' => 'not_in:0'
                ];
                
                if($request->childminder_status == config('const.CHILDMINDER_STATUS.0')) {// 保育士番号ありの場合
                    $rules += [
                        'childminder_number_pref' => 'not_in:0',
                        'childminder_number_only' => 'required|alpha_num|digits:6'                    ];
                }
                        
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

            $company_profile_id = ($request->company_profile_id === "なし") ? null : $request->company_profile_id;
            $other_facility_name = ($company_profile_id) ? null : $request->other_facility_name;
            $other_facility_pref = ($company_profile_id) ? null : $request->other_facility_pref;
            $other_facility_address = ($company_profile_id) ? null : $request->other_facility_address;
            $childminder_status = ($request->job === config('const.JOB.0')) ? $request->childminder_status : null;
            $childminder_number = ($request->childminder_status === config('const.CHILDMINDER_STATUS.0')) ? $request->childminder_number_pref.'-'.$request->childminder_number_only : null;

            $profile = Profile::create([
                'birth_year' => $request['birth_year'],
                'birth_month' => $request['birth_month'],
                'birth_day' => $request['birth_day'],
                'job' => $request['job'],
                'other_facility_name' => $other_facility_name,
                'other_facility_address' => $other_facility_address,
                'childminder_status' => $childminder_status,
                'childminder_number' => $childminder_number,
                'other_facility_pref' => $other_facility_pref,
            ]);            
            $user->profile_id = $profile->id;
            $user->company_profile_id = $company_profile_id;
            
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
            $user->company_profile_id = $company_profile->id;

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

        if(Gate::denies('system-only')){ // 特権ユーザ以外は
            if (Auth::id() != $id) { // 認証済（自分の）IDのみ許可
                return redirect('/account/'.Auth::id());
            }
        }

        if($user->role_id == 4) {
            $profile = $user->profile()->first();
            //dd($profile);
            if($user->company_profile_id) {
                $companyUser = User::find($user->company_profile_id)->name;
            } else {
                $companyUser = $profile->other_facility_name;
            }
        } elseif($user->role_id == 3) {
            $profile = $user->company_profile()->first();
            $companyUser = null;
        } else {
            $companyUser = null;
        }

        return view('account.show', compact('user','profile','companyUser'));

    }
    
    public function edit($id)
    {
        if(Gate::denies('system-only')){ // 特権ユーザ以外は
            if (Auth::id() != $id) { // 認証済（自分の）IDのみ許可
                return redirect('/account/edit/'.Auth::id());
            }
        }

        $user = User::find($id);
        $userSelf = User::find(Auth::id());
        $userSelfRole = $userSelf->role->level;

        if($user->role_id == 4) { // 個人ユーザの場合
            list($user->firstname,$user->lastname) = explode('　',$user->name);
            list($user->firstruby,$user->lastruby) = explode('　',$user->ruby);
        }

        // 施設ユーザ
        $company = User::where('role_id','3')->get();
        foreach($company as $key => $item) {

            if(preg_match('/郡/',$item->address)){
                list($city,$etc) = explode("郡",$item->address);
                $city = $city."郡";
            } elseif(preg_match('/市/',$item->address)){
                list($city,$etc) = explode("市",$item->address);
                $city = $city."市";
            } elseif(preg_match('/郡/',$item->address)){
                list($city,$etc) = explode("郡",$item->address);
                $city = $city."郡";
            } else {
                $city = $item->address;
            }


            $facilites[] = [
                'company_profile_id' => $item['company_profile_id'],
                'name' => $item['name'],
                'city' => $city,
            ];
        }

        // 地区名
        $area_name = config('const.AREA_NAME');
        // 支部名
        $branch_name = config('const.BRANCH_NAME');
        // 設置主体
        $company_variation = config('const.COMPANY_VARIATION');
        // こども園類型
        $category = config('const.CATEGORY');
        // 都道府県
        $pref = config('const.PREF');
        // 職種
        $job = config('const.JOB');
        // 保育士番号所持状況
        $childminder_status = config('const.CHILDMINDER_STATUS');

        if($user->role_id == 4) {
            $profile = $user->profile()->first();
            if($profile->childminder_number) {
                list($profile->childminder_number_pref,$profile->childminder_number_only) = explode('-',$profile->childminder_number);
            }            
        } elseif($user->role_id == 3) {
            $profile = $user->company_profile()->first();
        } else {
            $profile = [];
        }


        return view('account.edit', 
            compact('user','profile','facilites','area_name','branch_name','company_variation','category','job','pref','childminder_status')
        );


    }

    public function update(Request $request, $id)
    {
        if(Gate::denies('system-only')){ // 特権ユーザ以外は
            if (Auth::id() != $id) { // 認証済（自分の）IDのみ許可
                return redirect('/account/edit/'.Auth::id());
            }
        }

        $user = User::find($id);

        $rules = [
            'phone' => 'required|string',
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
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'firstruby' => 'required|string',
                'lastruby' => 'required|string',
                'birth_year' => 'not_in:0',
                'birth_month' => 'not_in:0',
                'birth_day' => 'not_in:0',
                'company_profile_id' => 'not_in:0',
                'job' => 'not_in:0'
            ];

            if($request->company_profile_id === "なし") {
                $rules += [            
                    'other_facility_name' => 'required|string',
                    'other_facility_pref' => 'required|string',
                    'other_facility_address' => 'required|string',
                ];
            }
            if($request->job === config('const.JOB.0')) {//「保育士・保育教諭」の場合
                $rules += [
                    'childminder_status' => 'not_in:0'
                ];
                
                if($request->childminder_status == config('const.CHILDMINDER_STATUS.0')) {// 保育士番号ありの場合
                    $rules += [
                        'childminder_number_pref' => 'not_in:0',
                        'childminder_number_only' => 'required|alpha_num|digits:6'
                    ];
                }
                        
            }

        } else {
            $rules += [
                'name' => 'required|string',
                'ruby' => 'required|string',
            ];

            if($user->role_id == 3) { // 法人ユーザ
                $rules += [
                    'area_name' => 'not_in:0',
                    'branch_name' => 'not_in:0',
                    'company_variation' => 'not_in:0',
                    'category' => 'not_in:0',
                    'fax' => 'required|string',
                ];
            }
        }
        $request->validate($rules);
        
        if($user->role_id == 4) {
            $profile = $user->profile()->first();
            $profile->birth_year = $request->birth_year;
            $profile->birth_month = $request->birth_month;
            $profile->birth_day = $request->birth_day;
            $profile->job = $request->job;

            if($request->company_profile_id === "なし") {
                $user->company_profile_id = null;
                $profile->other_facility_name = $request->other_facility_name;
                $profile->other_facility_pref= $request->other_facility_pref;
                $profile->other_facility_address = $request->other_facility_address;
            } elseif($request->company_profile_id) {
                $user->company_profile_id = $request->company_profile_id;
                $profile->other_facility_name = null;
                $profile->other_facility_pref = null;
                $profile->other_facility_address = null;
            }
            if($profile->job === config('const.JOB.0')) {
                $profile->childminder_status = $request->childminder_status;
                if($profile->childminder_status === config('const.CHILDMINDER_STATUS.0')) {
                    $profile->childminder_number = $request->childminder_number_pref.'-'.$request->childminder_number_only;
                } else {
                    $profile->childminder_number = null;
                }
            } else {
                $profile->childminder_status = null;
            }

            $profile->save();

            $user->name = $request->firstname.'　'.$request->lastname;
            $user->ruby = $request->firstruby.'　'.$request->lastruby;

        } else {

            $user->name = $request->name;
            $user->ruby = $request->ruby;

            if($user->role_id == 3) {
                
                $public_or_private = ($request->company_variation === '市町村') ? '公' : '私';

                $profile = $user->company_profile()->first();
                $profile->area_name = $request->area_name;
                $profile->company_variation = $request->company_variation;
                $profile->public_or_private = $public_or_private;
                $profile->category = $request->category;
                $profile->fax = $request->fax;                
                $profile->kyokai_number = isset($request->kyokai_number) ? $request->kyokai_number : null;

                $profile->save();
            }
        }

        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->zip = $request->zip;
        $user->address = $request->address;
        $user->email_verify_token = base64_encode($request->email);
        $user->save();

        //session()->flash('status', 'ユーザ情報の変更が完了しました。'); 
        return redirect('/account/edit/'.$id)->with('status','ユーザ情報の変更が完了しました。');

    }

    public function trimcompany($id) {
        if(Gate::denies('admin-only')){
            return redirect('/account/edit/'.Auth::id());
        }
        $user = User::find($id);
        $user->company_profile_id = null;
        $user->save();
        return redirect()->route('account.index')->with('status','指定ユーザの所属施設設定を解除しました。');
    }

    public function destroy($id)
    {
        if(Gate::denies('system-only')) {
            return redirect('/account/edit/'.Auth::id());
        }
        $user = User::find($id);
        $user->delete();
        return redirect()->route('account.index')->with('status',"指定ユーザを退会にしました。");
    }

    public function withdrawalconfirm() {
        $user_self = User::find(Auth::id());
        if($user_self->role_id == 4) {
            return view('account.withdrawalconfirm',compact('user_self'));
        } else {
            return redirect()->route('account.index');
        }                
    }

    public function withdrawal(Request $request) {

        $rules = [
            'withdrawalreason' => 'required|string',
        ];
        $request->validate($rules);

        $user = User::find($request->id);
        $user->withdrawalreason = $request->withdrawalreason;
        $user->save();
        $user->delete();
        return redirect()->route('afterwithdrawal')->with('status',"退会が完了しました。");        
    }

    public function restore($id) {
        if(Gate::denies('system-only')) {
            return redirect('/account/edit/'.Auth::id());
        }
        $user = User::onlyTrashed()->find($id);
        $user->restore();
        return redirect()->route('account.index')->with('status','指定ユーザを復元しました。');
    }

    public function forceDelete($id) {
        if(Gate::denies('system-only')) {
            return redirect('/account/edit/'.Auth::id());
        }
        $user = User::onlyTrashed()->find($id);
        $user->forceDelete();
        return redirect()->route('account.index')->with('status','指定ユーザのアカウントを削除しました。削除したユーザは復元できません。');
    }
}
