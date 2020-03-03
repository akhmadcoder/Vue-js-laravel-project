<?php

use Illuminate\Database\Seeder;

class RoleUserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'role_id' => 1,
                'user_id' => 1,
            ],
            [
                'role_id' => 2,
                'user_id' => 2,
            ],
            
        ];

        foreach ($data as $key => $value) {
            DB::table('role_user')->insert([
                'role_id' => $value['role_id'],
                'user_id' => $value['user_id'],
            ]);
        }
    }
}
