<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Traits\Email;
use App\Http\Traits\Api;
class AdminController extends Controller
{
    use Email,Api;
   
    /**
     * Display admin dashboard.
     * @return Response
     */
    
    
     
    public function dashboard()
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
        return view('admin::dashboard',compact('configData','menuData'));
    }
    
    
}
