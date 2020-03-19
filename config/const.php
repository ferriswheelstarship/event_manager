<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Const
    |--------------------------------------------------------------------------
    */


    // 0:仮登録 1:本登録 2:メール認証済 9:退会済
    'USER_STATUS' => ['PRE_REGISTER' => '0', 'REGISTER' => '1', 'MAIL_AUTHED' => '2', 'DEACTIVE' => '9'],
    
    // 権限レベル(数値低いほど高) 1:特権管理者 3:支部 5:法人 10:個人
    'AUTH_STATUS' => ['ADMIN' => '1','AREA' => '3','COMPANY'=> '5', 'USER' => '10'],
    
    // 権限表示view用（$user->role_id)
    'AUTH_STATUS_JP' => ['1'=>'特権','2'=>'支部','3'=>'法人','4'=>'個人'],

    // 地区名
    'AREA_NAME' => ['阪神','東播磨','西播磨','但馬','丹波','淡路'],

    // 支部名
    'BRANCH_NAME' => [
        '尼崎','芦屋','伊丹','宝塚','川西','三田','猪名川','明石','加古川','西脇',
        '三木','高砂','小野','加西','加東','東播磨','多可','たつの','宍粟','神崎',
        'はりま南西','豊岡','養父','朝来','美方','篠山','丹波','洲本','淡路','南あわじ'
    ],

    // 設置主体
    'COMPANY_VARIATION' => ['市町','社会福祉法人','学校法人','宗教法人','財団法人','株式会社','有限会社','NPO'],

    // こども園類型
    'CATEGORY' => ['幼保','保','特定認可外保育施設型'],


    // 職種
    'JOB' => ['保育士','調理師','施設長','看護師','事務員'],

    // 保育士番号所持状況
    'CHILDMINDER_STATUS' => ['保育士番号あり','保育士番号取得中',],

    // 都道府県
    'PREF' => [
        '北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県',
        '富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','奈良県','和歌山県','鳥取県',
        '島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県'],

    // 研修種別
    'TRAINING_VARIATION' => ['carrerup'=>'キャリアアップ研修','general'=>'一般研修',],
    
    'PARENT_CURRICULUM' => [
        '乳児保育','幼児教育','障害児保育','食育・アレルギー対応',
        '保健衛生・ 安全対策','保護者支援・子育て支援','マネジメント','保育実践',],

    'CHILD_CURRICULUM' => [
        '乳児保育の意義','乳児保育の環境','乳児への適切な関わり','乳児の発達に応じた保育内容','乳児保育の指導計画、記録及び評',
        '幼児教育の意義','幼児教育の環境','幼児の発達に応じた保育内容','幼児教育の指導計画、記録及び評価','小学校との接続',
        '障害の理解','障害児保育の環境','障害児の発達の援助','家庭及び関係機関との連携','障害児保育の指導計画、記録及び評価',
        '栄養に関する基礎知識','食育計画の作成と活用','アレルギー疾患の理解','保育所における食事の提供ガイドライン','保育所におけるアレルギー対応ガイドライン',
        '保健計画の作成と活用','事故防止及び健康安全管理','保育所における感染症対策ガイドライン','保育の場において血液を介して感染する 病気を防止するためのガイドライン','教育・保育施設等における事故防止及び 事故発生時の対応のためのガイドライン',
        '保護者支援・子育て支援の意義','保護者に対する相談援助','地域における子育て支援','虐待予防','関係機関との連携、地域資源の活用',
        'マネジメントの理解','リーダーシップ','組織目標の設内容定','人材育成','働きやすい環境づくり',
        '保育における環境構成','子どもとの関わり方','身体を使った遊び','言葉・音楽を使った遊び','物を使った遊び',
    ],
];