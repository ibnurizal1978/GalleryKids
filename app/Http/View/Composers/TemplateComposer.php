<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Modules\Order\Entities\Order;
use Modules\Setting\Entities\Setting;
use Auth;

class TemplateComposer
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
        $verticalMenuJson = file_get_contents(base_path('public/admin/json/verticalMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);
        $horizontalMenuJson = file_get_contents(base_path('public/admin/json/horizontalMenu.json'));
        $horizontalMenuData = json_decode($horizontalMenuJson);

        $menuData = [$verticalMenuData, $horizontalMenuData];

        $configData = [ 
          "theme" => "light",
          "sidebarCollapsed" => false,
          "navbarColor" => "",
          "menuType" => "menu-fixed",
          "navbarType" => "navbar-floating",
          "footerType" => "footer-static",
          "sidebarClass" => "menu-expanded",
          "bodyClass" => "",
          "pageHeader" => false,
          "blankPage" => false,
          "blankPageClass" => "",
          "contentLayout" => "",
          "sidebarPositionClass" => "",
          "contentsidebarClass" => "",
          "mainLayoutType" => "vertical",
          "direction" => "ltr",
          "navbarClass" => "floating-nav"
    ];
        
        $view->with('configData', $configData)->with('menuData', $menuData);
    }
}