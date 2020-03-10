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
            ['name' => 'MJ管理用', 'email' => 'fujita@mj-inc.jp', 'password' => '$2y$10$Mnim6miR/o.J9FjerERD7O6uGt973ioa29Mu9AVdEYD1CipE.yF1W', 'role_id' => '1', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '兵庫県保育園協会事務局', 'email' => 'hokyo@fancy.ocn.ne.jp', 'password' => '$2y$10$meyTLmysP.Qncmq.vh7VCuoNWAq2WHgU/..ykJJQMHrX5yNZqW0gq', 'role_id' => '1', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '糸田川', 'email' => 'ito@mj-inc.jp', 'password' => '$2y$10$0Tas4AndA5G1ym8c1ExjnODTQ6j1B73GUaGaKqgmeJy/fxt.4wR.y', 'role_id' => '1', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '尼崎', 'email' => 'dammy1@example.com', 'password' => '$2y$10$rsRrwhXSgJC5Q02RHKkjmeIbyq8rJ/N4senBlZGxQ7B5eHO.53EwC', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '芦屋', 'email' => 'dammy2@example.com', 'password' => '$2y$10$Vriv.pdnlKsyQwzjI/ruiexB89IcYmRQnkIpFj2M46ZqZZyZOAZHe', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '伊丹', 'email' => 'dammy3@example.com', 'password' => '$2y$10$j0pHwlawLHMGP8HE5oj0S.g/YoSex4/AeaKWyOT7g2wS4qBocXPWW', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '宝塚', 'email' => 'dammy4@example.com', 'password' => '$2y$10$N3f3uIPlJtR1F1E35kvoxeF1rHxsKnIi5uxPVeHuMb27i6hoX0cPi', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '川西', 'email' => 'dammy5@example.com', 'password' => '$2y$10$mR5vDJryAxM7WATKEqqBeO/ysfvj3Qpstak8LdMJSyulRgwlxDgtm', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '三田', 'email' => 'dammy6@example.com', 'password' => '$2y$10$lnwHbowu4NdaqtROZsJ6VO7qoN.uFk/Lm3PIzocjbKHN8Jh88Zkne', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '猪名川', 'email' => 'dammy7@example.com', 'password' => '$2y$10$i/knXfUD2JMt/LL85SJjouN0WtSNrTVmlP/bPOlYq6JgQKstzhyxK', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '明石', 'email' => 'dammy8@example.com', 'password' => '$2y$10$A8wDqK30UU1jVD/v2K8RH.KXfHTLa2EHQwSr8k7/bRkPfC7Qrcsw.', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '加古川', 'email' => 'dammy9@example.com', 'password' => '$2y$10$vkqbqvFQQA7B1rw3IbLqluVDm2JOYzkWbN1DJ291G6RtTDrEJBsRa', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '西脇', 'email' => 'dammy10@example.com', 'password' => '$2y$10$Gh7vmRKtldfGH6oOWMBB6OJ6gD7AWpErzqh.dRgR/ozYmU.QVpYNG', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '三木', 'email' => 'dammy11@example.com', 'password' => '$2y$10$HFclba12Le0i5.JU0n7/XOBb7yxyzrg8m9mhln5XN1U30rKdL0LH2', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '高砂', 'email' => 'dammy12@example.com', 'password' => '$2y$10$x1KfVThczqQHyBZCgB6YH.GrWZdbPpr01/se3mT12p9oyfwdr2qdq', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '小野', 'email' => 'dammy13@example.com', 'password' => '$2y$10$7LKoXt7oG/d.HJ3bZNfyVe.rrBmEPcKqhFDFSQ1qfxuEJemSV6iAq', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '加西', 'email' => 'dammy14@example.com', 'password' => '$2y$10$91Z8TnuMQDu.lc8LMEMOhOg7gWwUZRPyoqL6qA4KucuREGGmXS27O', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '加東', 'email' => 'dammy15@example.com', 'password' => '$2y$10$oyfjO65lERn9rSsnCLjJuuaT.r/8jMsR9kJlMksmVPbaJAHHaH/pW', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '東播磨', 'email' => 'dammy16@example.com', 'password' => '$2y$10$YOD2/JRTLD9Jgb7hU2jicOceEZoEKCAdI4Q77qbN0n1a7bRUfW2RG', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '多可', 'email' => 'dammy17@example.com', 'password' => '$2y$10$y.lr07KiGqEcewEVeKoTyOv9jPwe9iLN463gbUOzTefsfON91nkO2', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => 'たつの', 'email' => 'dammy18@example.com', 'password' => '$2y$10$j3eFuKzzEp1cDPLCSWOIGOXVVxEFV4mjpZRdubs5Z72xy7pVZKYbe', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '宍粟', 'email' => 'dammy19@example.com', 'password' => '$2y$10$CXxx7W1TIbeFKdoQKCCgteec5S.rF3PGeIEKocK2A504OloSZE3tG', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '神崎', 'email' => 'dammy20@example.com', 'password' => '$2y$10$p/qqi..nfcjAUihPz/243OJs3MqMbKlZEVAKp.WnwPRYAwLyiZMmm', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => 'はりま南西', 'email' => 'dammy21@example.com', 'password' => '$2y$10$YllVw/gohTWFCwNkPMR7s.8SvUkGMGGah9lFPfQKS7YXa.rb3Jl7a', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '豊岡', 'email' => 'dammy22@example.com', 'password' => '$2y$10$25PKnPnKMbmNIkS4b97GIeIEEt/mW5MMOYkkrqaorAQfmTvsvS50.', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '養父', 'email' => 'dammy23@example.com', 'password' => '$2y$10$1GZmkwYfp8qHTeLOJOiCIOI2mX/usKJ4UImgbjr3R8OM83Ejhf6sC', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '朝来', 'email' => 'dammy24@example.com', 'password' => '$2y$10$GvnGJgPmsI2RweRc4IkqyeLRCWR2EGtF/6TqOphmfn3VQkGuaXg2.', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '美方', 'email' => 'dammy25@example.com', 'password' => '$2y$10$MKh5I3QfznEQtyvs.4PXceKuyw.klLhx.coFqaaXewk/rCIomzwWm', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '篠山', 'email' => 'dammy26@example.com', 'password' => '$2y$10$DIEvUsgAcbY1puClwrYjs.9Zac4yv8HhZd1Km1Zr8P4q/tguDOk06', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '丹波', 'email' => 'dammy27@example.com', 'password' => '$2y$10$k8i6IL3L1PX1OM2JhRy7Z.49Ss8fkXPBd.uTJAv0.3ZK.YGULAjdi', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '洲本', 'email' => 'dammy28@example.com', 'password' => '$2y$10$507tt7QJzk0ImmYAxnx04e9YDAI5MpDw0ZC29zHAWAfIOqUFRVGma', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '淡路', 'email' => 'dammy29@example.com', 'password' => '$2y$10$Kt2FnvTKai2QMBK06kRoE.R4SvihwL3pTlQ4jjJEzRJVKplqaTNK2', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
            ['name' => '南あわじ', 'email' => 'dammy30@example.com', 'password' => '$2y$10$K0crRY8H4r3ydRnJW/HJ0O4B4kReOHNhx5xzmtUNUtIbylejrM96W', 'role_id' => '2', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), ],
        ]);

    }
}
