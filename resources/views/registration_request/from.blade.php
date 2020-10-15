以下内容で研修サイトへユーザ登録代行依頼がありました。

----------------------
【発生している問題】：{{ $content['registration_type'] }}
----------------------
以下登録代行依頼の情報です。

【メールアドレス】：{{ $content['reg_email'] }}

【パスワード】：{{ $content['password'] }}

【氏名】：{{ $content['firstname'] }}　{{ $content['lastname'] }}

【フリガナ】：{{ $content['firstruby'] }}　{{ $content['lastruby'] }}

【電話番号】：{{ $content['phone'] }}

【住所】：{{ $content['zip'] }}　{{ $content['address'] }}

【生年月日】：{{ $content['birth_year'] }}年{{ $content['birth_month'] }}月{{ $content['birth_day'] }}日

【所属施設】：{{ $content['facility'] }}

@if($content['company_profile_id'] == "なし")
【所属施設所在地】：{{ $content['other_facility_pref'].$content['other_facility_address'] }}

@endif
【職種】：{{ $content['job'] }}

@if($content['job'] == "保育士・保育教諭")
【保育士番号所持状況】：{{ $content['childminder_status'] }}

@if($content['childminder_status'] == "保育士番号あり")
【保育士番号】：{{ $content['childminder_number_pref'] }}{{ $content['childminder_number_only'] }}

@endif
@endif
----------------------
