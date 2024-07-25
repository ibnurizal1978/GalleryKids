<?php

namespace Modules\AgeGroup\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\AgeGroup\Entities\AgeGroup;

class AgeGroupDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $age_groups = ['Less than 7 years old', '7-10 years old','11-13 years old','14-15 years old','More than 15 years old'];

        foreach ($age_groups as $key => $value) {
            AgeGroup::create(['age_group' => $value]);
        }
        

        // $this->call("OthersTableSeeder");
    }
}
