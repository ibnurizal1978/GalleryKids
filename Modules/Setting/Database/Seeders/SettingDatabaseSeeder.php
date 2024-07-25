<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Entities\Tab;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Setting::create(['type' => 'banner', 'image' => 'dummy']);
        // $this->call("OthersTableSeeder");
        Tab::create(['name' => 'create', 'slug' => 'create', 'display_name' => 'Create']);
        Tab::create(['name' => 'share', 'slug' => 'share','display_name' => 'Share']);
        Tab::create(['name' => 'play', 'slug' => 'play', 'display_name' => 'Play']);
        Tab::create(['name' => 'discover', 'slug' => 'discover','display_name' => 'Discover']);
        Tab::create(['name' => 'special_exhibition','slug' => 'special_exhibition', 'display_name' => 'Special Exhibition']);
        Tab::create(['name' => 'festival', 'slug' => 'festival','display_name' => 'Festival']);
    }
}
