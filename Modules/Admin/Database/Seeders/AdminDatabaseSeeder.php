<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'NGS Kidsclub',
            'email' => 'admin@nsgkidsclub.com',
            'username' => 'admin_ngs_kidsclub',
            'password' => bcrypt('12345678'),
            'role_id' => 1,
            'status' => 'Enable'
        ]);
        // $this->call("OthersTableSeeder");
    }
}
