<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        Category::create(['name' => 'Art tutorial','type' => 'create']);
        Category::create(['name' => 'Storytelling','type' => 'create']);
        Category::create(['name' => 'Downloadable Videos','type' => 'create']);
        Category::create(['name' => 'Activities','type' => 'create']);
        Category::create(['name' => 'Family Art Competition','type' => 'create']);
        Category::create(['name' => 'Parenting Articles','type' => 'create']);
        
        Category::create(['name' => 'Stories in Art (YouTube)','type' => 'explore']);
        Category::create(['name' => 'Ask Anything Art (YouTube)','type' => 'explore']);
        Category::create(['name' => 'Parents Toolkit (PDFs)','type' => 'explore']);
        Category::create(['name' => 'Kids’ Article (PDFs)','type' => 'explore']);
        Category::create(['name' => 'Questions','type' => 'explore']);
        Category::create(['name' => 'Others','type' => 'explore']);
        
        Category::create(['name' => 'Art tutorial','type' => 'exhibition']);
        Category::create(['name' => 'Storytelling','type' => 'exhibition']);
        Category::create(['name' => 'Downloadable Videos','type' => 'exhibition']);
        Category::create(['name' => 'Activities','type' => 'exhibition']);
        Category::create(['name' => 'Family Art Competition','type' => 'exhibition']);
        Category::create(['name' => 'Parenting Articles','type' => 'exhibition']);

        Category::create(['name' => 'Art tutorial','type' => 'play']);
        Category::create(['name' => 'Storytelling','type' => 'play']);
        Category::create(['name' => 'Downloadable Videos','type' => 'play']);
        Category::create(['name' => 'Activities','type' => 'play']);
        Category::create(['name' => 'Family Art Competition','type' => 'play']);
        Category::create(['name' => 'Parenting Articles','type' => 'play']);
  
        // $this->call("OthersTableSeeder");
    }
}
