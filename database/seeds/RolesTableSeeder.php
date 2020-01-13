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
                'level' => 5,
                'display_name' => 'company'
            ],
            [
                'id' => 3,
                'level' => 10,
                'display_name' => 'user'
            ],
        ]);

        DB::table('profiles')->insert([
            [
                'id' => 1,
                'job' => 1,
                'serial_number' => '12345678'
            ],
            [
                'id' => 2,
                'job' => 2,
                'serial_number' => '345678912'
            ],
            [
                'id' => 3,
                'job' => 3,
                'serial_number' => '567891234'
            ],
            [
                'id' => 4,
                'job' => 1,
                'serial_number' => '123456789'
            ],
            [
                'id' => 5,
                'job' => 1,
                'serial_number' => '123456789'
            ],
            [
                'id' => 6,
                'job' => 1,
                'serial_number' => '123456789'
            ],
            [
                'id' => 7,
                'job' => 1,
                'serial_number' => '123456789'
            ],
        ]);

        DB::table('company_profiles')->insert([
            [
                'id' => 1,
                'company_name' => '株式会社AAA',
                'company_ruby' => 'かぶしきかいしゃえーえーえー'
            ],
            [
                'id' => 2,
                'company_name' => '株式会社BBB',
                'company_ruby' => 'かぶしきかいしゃびーびーびー'
            ],
            [
                'id' => 3,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
        ]);
    }
}
