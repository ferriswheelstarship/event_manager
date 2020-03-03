<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'level' => 1,
                'display_name' => 'admin'
            ],
            [
                'id' => 2,
                'level' => 3,
                'display_name' => 'area'
            ],
            [
                'id' => 3,
                'level' => 5,
                'display_name' => 'company'
            ],
            [
                'id' => 4,
                'level' => 10,
                'display_name' => 'user'
            ],
        ]);
        
        // 特権、支部ユーザマスターデータ
        DB::table('users')->insert([
            ['name' => 'MJ管理用', 'email' => 'fujita@mj-inc.jp', 'password' => '$2y$10$X95aX09/JG8vvSg6OZkgRuBt3p/Kyk8blkfguSvhNQdiE.8sl3/bu', 'role_id' => '1', ],
            ['name' => '兵庫県保育園協会事務局', 'email' => 'hokyo@fancy.ocn.ne.jp', 'password' => '$2y$10$cItu.B.OU2tls8fvYI47Fe8HnCb6uu7swKbKLmVqFJopaMYtgtns.', 'role_id' => '1', ],
            ['name' => '糸田川', 'email' => 'ito@mj-inc.jp', 'password' => '$2y$10$OBMQeSRsQ8i4acJmIkHPKuqu8wuqIWeNOC0o8D9Oq.snCiyE.cnu.', 'role_id' => '1', ],
            ['name' => '尼崎', 'email' => 'dammy1@example.com', 'password' => '$2y$10$0X3.0yvO7lOv49Swetnvj.PlHUuvLc4cIcKGY7EpGshiwW4rOOcp.', 'role_id' => '2', ],
            ['name' => '芦屋', 'email' => 'dammy2@example.com', 'password' => '$2y$10$VTLBrzviz0uUSEC/XyDQUOF1qbPCG8O4OARs43DVlSwOO6JJxinVu', 'role_id' => '2', ],
            ['name' => '伊丹', 'email' => 'dammy3@example.com', 'password' => '$2y$10$fIc3pdF2q.Uz5K7HWRG20O812ICnKwcFwopolX14XJhICZ.vd0OW.', 'role_id' => '2', ],
            ['name' => '宝塚', 'email' => 'dammy4@example.com', 'password' => '$2y$10$EHUe1rvppDAytk92xZqdZuSkECL6s3ohIGlVMctjox78jLNRlU1AG', 'role_id' => '2', ],
            ['name' => '川西', 'email' => 'dammy5@example.com', 'password' => '$2y$10$ij71PcMTWdD1XpmzOEcLUeH5q/mQEWOq6lKNImtLBgta6gZoGukJe', 'role_id' => '2', ],
            ['name' => '三田', 'email' => 'dammy6@example.com', 'password' => '$2y$10$rBt9EKjPOaQUOp2lMPhGMeXr5xTiRaGCgHrjxhLTWOZC7Gwbxdye.', 'role_id' => '2', ],
            ['name' => '猪名川', 'email' => 'dammy7@example.com', 'password' => '$2y$10$S2fqOQSyVP8vYJEzQ.9WfON004U5caqD1QRm9R8JcB2UAs.fXLsJW', 'role_id' => '2', ],
            ['name' => '明石', 'email' => 'dammy8@example.com', 'password' => '$2y$10$.DKs6j6shdM4vVqtN1dDdOPSjcpPMuwIWssPaeFtsja/A9PEDDlNe', 'role_id' => '2', ],
            ['name' => '加古川', 'email' => 'dammy9@example.com', 'password' => '$2y$10$kPHP8ifZtifBZQV2l401KOHPWf6fibw8sQcbV2iQ.zdPuvi7aPsLq', 'role_id' => '2', ],
            ['name' => '西脇', 'email' => 'dammy10@example.com', 'password' => '$2y$10$diUyBHToC5htrZng/GR7XOOHPwtsmzV/CNnd9bcifFJmi62OD8deu', 'role_id' => '2', ],
            ['name' => '三木', 'email' => 'dammy11@example.com', 'password' => '$2y$10$r.iEGGtXz.6L/3ob5kDau.lYWE8b2hhYZda.QEuF4Jx.Uhh0lhPLu', 'role_id' => '2', ],
            ['name' => '高砂', 'email' => 'dammy12@example.com', 'password' => '$2y$10$wWBiWMv1o/KzhHiMghcmcOGcQkqKgT4u4vKAReKVnozGzYZTlPdfy', 'role_id' => '2', ],
            ['name' => '小野', 'email' => 'dammy13@example.com', 'password' => '$2y$10$I1YonZZMcQo9JfiR9gPCZ.OcxSlCtbZGQQ4FFcu4D3Gqh8N5MtVp2', 'role_id' => '2', ],
            ['name' => '加西', 'email' => 'dammy14@example.com', 'password' => '$2y$10$4ooUU.5lmicL6ixtihxzYuOgvT4k8eWKep2W7xGKf/2Cu.ejpjf/.', 'role_id' => '2', ],
            ['name' => '加東', 'email' => 'dammy15@example.com', 'password' => '$2y$10$pXPju6Oc8DT02D8OtYBJ1ehsZPfZicahBU5XA1sigxB2dR75ExsOy', 'role_id' => '2', ],
            ['name' => '東播磨', 'email' => 'dammy16@example.com', 'password' => '$2y$10$YWAjp15cTznKKYqdzsfXH.ABj8TKSIX.Kwgr8jt6AmaeCErXhHmoO', 'role_id' => '2', ],
            ['name' => '多可', 'email' => 'dammy17@example.com', 'password' => '$2y$10$2.GNwscurDEBoaFP9D4BLO5UKWx..tFOXo1D9pPubASQtiSu9gqbe', 'role_id' => '2', ],
            ['name' => 'たつの', 'email' => 'dammy18@example.com', 'password' => '$2y$10$BS2D4LKtwoZZX8tQ/ID1ZeObvZMlotUF5eEsM68QYNdjTjxJVSpcG', 'role_id' => '2', ],
            ['name' => '宍粟', 'email' => 'dammy19@example.com', 'password' => '$2y$10$5TTrQo/PzScN/Ig2EkAhLueU/.lP6J8AaKSvM3Nnxq923P9Axme.y', 'role_id' => '2', ],
            ['name' => '神崎', 'email' => 'dammy20@example.com', 'password' => '$2y$10$6Rvbip.Drrr9DUHuhfGIOupp0uxVwy80RRrv0z9itekUB2QYnkm0O', 'role_id' => '2', ],
            ['name' => 'はりま南西', 'email' => 'dammy21@example.com', 'password' => '$2y$10$a1YZce68BzrMhFGcTtl/huzucRiN/dw2bthQCT.Vwl4CqngWhpFbW', 'role_id' => '2', ],
            ['name' => '豊岡', 'email' => 'dammy22@example.com', 'password' => '$2y$10$0lgPPoPNHlnxo0cvgn9TS.A87lgIEZa/ShR9HyKKV2sGHbkGGaqNK', 'role_id' => '2', ],
            ['name' => '養父', 'email' => 'dammy23@example.com', 'password' => '$2y$10$1Ji2e5DccPWE/oawFw.Yne4OOo1e1V45gDj128rHpLA1pQBBH7X6m', 'role_id' => '2', ],
            ['name' => '朝来', 'email' => 'dammy24@example.com', 'password' => '$2y$10$.YQ2BNWfJuM64m11drCHpuGUg7jwwQsiJHIZ3d7w2et7jTSZAgHv.', 'role_id' => '2', ],
            ['name' => '美方', 'email' => 'dammy25@example.com', 'password' => '$2y$10$rHTHIhIIR/xooa6mxTDoNO6FmZeLmNzEBOPRo/bQKE/hlc02.o676', 'role_id' => '2', ],
            ['name' => '篠山', 'email' => 'dammy26@example.com', 'password' => '$2y$10$sDLCZkgAwi5W6eALILbpse5ZY/q9rwtP6PcG/cfpeCoGTWSWj.tfu', 'role_id' => '2', ],
            ['name' => '丹波', 'email' => 'dammy27@example.com', 'password' => '$2y$10$qiMaXFX0.PkY6NgLS/6LzOtstllw9HqOCTIfriQtfJtFnesXTCcqS', 'role_id' => '2', ],
            ['name' => '洲本', 'email' => 'dammy28@example.com', 'password' => '$2y$10$SWT3wmtpOwKHUyXQ8XNi9O.Yh1ZKabvmXJglxpwip3UBhol0NObvC', 'role_id' => '2', ],
            ['name' => '淡路', 'email' => 'dammy29@example.com', 'password' => '$2y$10$30AVa6yh6RDHiBi9dcvqquWisxWDXkPeuSvB2hni/Q/pniVfjQwzy', 'role_id' => '2', ],
            ['name' => '南あわじ', 'email' => 'dammy30@example.com', 'password' => '$2y$10$hPmhzvRNq9oQTTW49SkJBOJEGjQMzky1zSBNTWXLk6Vod1tmDS73e', 'role_id' => '2', ],
        ]);
    }
}
