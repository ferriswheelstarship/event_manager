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

        DB::table('profiles')->insert([
            [
                'id' => 1,
                'job' => 1,
                'serial_number' => '12345678',
                'birth_year' => '1990',
                'birth_year' => '1',
                'birth_year' => '1',
            ],
            [
                'id' => 2,
                'job' => 2,
                'serial_number' => '345678912',
                'birth_year' => '1990',
                'birth_year' => '1',
                'birth_year' => '1',
            ],
            [
                'id' => 3,
                'job' => 3,
                'serial_number' => '567891234',
                'birth_year' => '1990',
                'birth_year' => '1',
                'birth_year' => '1',
            ],
            [
                'id' => 4,
                'job' => 1,
                'serial_number' => '123456789',
                'birth_year' => '1990',
                'birth_year' => '1',
                'birth_year' => '1',
            ],
            [
                'id' => 5,
                'job' => 1,
                'serial_number' => '123456789',
                'birth_year' => '1990',
                'birth_year' => '1',
                'birth_year' => '1',
            ],
            [
                'id' => 6,
                'job' => 1,
                'serial_number' => '123456789',
                'birth_year' => '1990',
                'birth_year' => '1',
                'birth_year' => '1',
            ],
            [
                'id' => 7,
                'job' => 1,
                'serial_number' => '123456789',
                'birth_year' => '1990',
                'birth_year' => '1',
                'birth_year' => '1',
            ],
        ]);

        DB::table('company_profiles')->insert([
            [
                'id' => 1,
                'area_name' => '丹波',
                'branch_name'  => '美方',
                'company_ruby' => 'かぶしきかいしゃえーえーえー'
            ],
            [
                'id' => 2,
                'company_name' => '但馬',
                'company_ruby' => 'かぶしきかいしゃびーびーびー'
            ],
            [
                'id' => 3,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 4,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 5,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 6,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 7,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 8,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 9,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 10,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 11,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 12,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 13,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 14,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
            [
                'id' => 15,
                'company_name' => '株式会社CCC',
                'company_ruby' => 'かぶしきかいしゃしーしーしー'
            ],
        ]);
    }
}
