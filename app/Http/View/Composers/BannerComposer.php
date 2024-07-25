<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Entities\Tab;

class BannerComposer
{

    /**
     * Create a new notification composer.
     *
     */
    public function __construct()
    {
       
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {   
        $banner = Setting::where('type','banner')->first();
        $tabs = Tab::get(['name','slug','display_name'])->toArray();
        
        $view->with('banner', $banner)->with('tabs',$tabs);
    }
}