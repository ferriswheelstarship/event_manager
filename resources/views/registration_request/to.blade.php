【こちらのメールは自動返信用アドレスより送信しています。
返信してもメールは届きませんのでご注意ください。】


以下内容で「兵庫県保育協会　研修サイト」へのユーザ登録代行依頼を承りました。
登録が完了次第、ご入力頂いた電話番号へご連絡いたしますので今しばらくお待ち下さい。

----------------------
【発生している問題】：{{ $content['registration_type'] }}
----------------------
以下登録代行依頼の情報です。
訂正がある場合でも一旦こちらの情報でユーザ登録をさせていただきます。
登録完了のご連絡後に、ログインしていただき必要な項目の変更を行って下さい。

また、代行での登録はメールアドレスの認証をせず登録を行います。
登録後システムからのメール通知が届かない可能性がありますので予めご了承下さい。

----------------------

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

兵庫県保育協会　事務局