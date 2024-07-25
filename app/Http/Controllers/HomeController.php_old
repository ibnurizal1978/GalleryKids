<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Create\Entities\Create;
use Modules\Discover\Entities\Discover;
use Modules\Share\Entities\Share;
use Modules\Play\Entities\Play;
use Modules\Setting\Entities\Tab;
use Modules\Exhibition\Entities\Exhibition;
use Artisan;
use Auth;
use DB;
use Modules\Campaign\Entities\Campaign;
use Modules\AdminShare\Entities\AdminShare;
use \Cache;

class HomeController extends Controller
{


    /**
     * Displays main page.
     *
     * @return \Illuminate\Http\Response
     */

    public function home( Request $request )
    {
        $plays = Play::enable()->orderBy( 'id', 'DESC' )->take( 3 )->get();
//        $admin_shares = AdminShare::enable()->orderBy('id', 'DESC')->get();
//        dd($admin_shares);
        $admin_shares = Cache::remember( 'admin_shares', 60, function () {
            return AdminShare::enable()->orderBy( 'id', 'DESC' )->get();
        } );

        $campaigns = Campaign::get();
        $tabs      = Tab::get( [ 'name', 'slug', 'display_name' ] )->toArray();

        if ( Auth::check() ) {
            if ( Auth::user()->isStudent() ) {
                $creates     = Create::enable()
//                                     ->agegroup()
                                     ->valid()
                                     ->with( [
                                         'thumbnails',
                                         'age_groups'
                                     ] )->orderBy( 'id', 'DESC' )
                                     ->take( 3 )
                                     ->get();
                $discovers   = Discover::enable()
//                                       ->agegroup()
                                       ->valid()
                                       ->with( [
                                           'thumbnails',
                                           'reactions'
                                       ] )->orderBy( 'id', 'DESC' )
                                       ->take( 3 )
                                       ->get();
                $my_shares   = Share::enable()->orderBy( 'id', 'DESC' )->where( 'creator', '!=', 'admin' )->take( 5 )->get();
                $plays       = Play::enable()
//                                   ->agegroup()
                                   ->orderBy( 'id', 'DESC' )
                                   ->take( 3 )
                                   ->get();
                $exhibitions = Exhibition::enable()
//                                         ->agegroup()
                                         ->valid()
                                         ->with( [ 'thumbnails' ] )
                                         ->orderBy( 'id', 'DESC' )
                                         ->take( 3 )
                                         ->get();
            } else {
                $creates     = Create::enable()->valid()->with( [ 'thumbnails' ] )->orderBy( 'id', 'DESC' )->take( 3 )->get();
                $discovers   = Discover::enable()->valid()->with( [
                    'thumbnails',
                    'reactions'
                ] )->orderBy( 'id', 'DESC' )->take( 3 )->get();
                $my_shares   = Share::enable()->orderBy( 'id', 'DESC' )->where( 'creator', '!=', 'admin' )->take( 5 )->get();
                $exhibitions = Exhibition::enable()->valid()->with( [ 'thumbnails' ] )->orderBy( 'id', 'DESC' )->take( 3 )->get();
            }
        } else {
            $creates     = Create::enable()->valid()->nonmembers()->with( [ 'thumbnails' ] )->orderBy( 'id', 'DESC' )->take( 3 )->get();
            $discovers   = Discover::enable()->valid()->nonmembers()->with( [
                'thumbnails',
                'reactions'
            ] )->orderBy( 'id', 'DESC' )->take( 3 )->get();
            $my_shares   = Share::enable()->orderBy( 'id', 'DESC' )->where( 'creator', '!=', 'admin' )->take( 5 )->get();
            $exhibitions = Exhibition::enable()->valid()->nonmembers()->with( [ 'thumbnails' ] )->orderBy( 'id', 'DESC' )->take( 3 )->get();
        }
//        04-dec-20 This function is no more in use so we have commented it out
//        This is working from AdminShareController
//        try {
//            $client = new \GuzzleHttp\Client();
//            $response = $client->request('GET', 'https://pictiontestdmz.nationalgallery.sg/r/st/Piction_login/USERNAME/TRINAX/PASSWORD/TRINAX/JSON/T', ['headers' => [
//                    'Accept' => 'application/json',
//                    'SvcAuth' => 'VFJJTkFY,VkEyOFloSjlDd3lCWmRLVA==',
//                ],
//            ]);
//            $data = json_decode((string) $response->getBody()->getContents());
//            $SURL = $data->SURL;
//
//
//            try {
//                $response = $client->request('GET', 'https://pictiontestdmz.nationalgallery.sg/r/st/IQ/surl/' . $SURL . '/OUTPUT_STYLE/COMPACT/RETURN/DIRECT/INCLUDE_DERIVS/2345/URL_PREFIX/https:$PICTIONSLASH$$PICTIONSLASH$pictiontestdmz.nationalgallery.sg$PICTIONSLASH$piction$PICTIONSLASH$/SHOW_FULLTAG/TRUE/DISABLE_ATTRIBS/category,date_created/METATAG_VIEW/GROUP/METATAGS/ARTWORK%20DATA,KIDS_GALLERY/search/HIER_CATEGORY:%22National%20Collections%20Artworks%20%22%20AND%20META:%22KIDS_GALLERY.PUBLISH_TO_KIDS_CLUB,YES%22', ['headers' => [
//                        'Accept' => 'application/json',
//                        'SvcAuth' => 'VFJJTkFY,VkEyOFloSjlDd3lCWmRLVA==',
//                    ],
//                ]);
//                $data = json_decode((string) $response->getBody()->getContents());
//
//
////                    foreach($data[''])
//            } catch (\Exception $e) {
//                echo $e->getMessage();
//            }
//
//
////                    foreach($data[''])
//        } catch (\Exception $e) {
//            echo $e->getMessage();
//        }
//        unset($data[0]);
//
//                $image = '';
//                $newARTIST = '';
//                $testTitle = '';
//                foreach ($data as $da) {
//                    if (count(AdminShare::whereUid($da->umo_id)->get())) {
//
//                    } else {
//                        $ARTIST = $da->metadata->{'ARTWORK DATA.ARTIST'};
//                         $id = $da->umo_id;
//                        $TITLE = $da->metadata->{'ARTWORK DATA.TITLE'};
//                        $CLASSIFICATION = $da->metadata->{'ARTWORK DATA.CLASSIFICATION'};
//                        $CREDITLINE = $da->metadata->{'ARTWORK DATA.CREDITLINE'};
//                        $DATE_OF_ART_CREATED = $da->metadata->{'ARTWORK DATA.DATE_OF_ART_CREATED'};
//                        $images = $da->derivs;
//                        foreach ($images as $img) {
//                            $image = $img->url;
//                        }
//                        if ($DATE_OF_ART_CREATED) {
//                            $ART_CREATED = $DATE_OF_ART_CREATED;
//                        } else {
//                            $ART_CREATED = '';
//                        }
//                        foreach ($ARTIST as $Ar) {
//
//                            $newARTIST = $Ar->{'ARTWORK DATA.ARTIST:ARTIST_DOB'};
//
//                        }
//
//
//                        foreach ($TITLE as $ti) {
//                            $testTitle = $ti;
//                        }
//
//
//                        $adminShare = new AdminShare();
//                        $dataShare = $request->only(['image', 'TITLE', 'ARTIST', 'DATE_OF_ART_CREATED',
//                            'CLASSIFICATION', 'CREDITLINE', 'status']);
//                        $dataShare['image'] = $image;
//                        $dataShare['uid'] = $id;
//                        $dataShare['TITLE'] = $testTitle;
//                        $dataShare['ARTIST'] = $newARTIST;
//                        $dataShare['DATE_OF_ART_CREATED'] = $ART_CREATED;
//                        $dataShare['CLASSIFICATION'] = $CLASSIFICATION;
//                        $dataShare['CREDITLINE'] = $CREDITLINE;
//                        $dataShare['status'] = 'Disable';
//                        //dd($dataShare);
//                        $adminShare = $adminShare->create($dataShare);
//                    }
//                }


        return view( 'welcome', compact(
            'creates',
            'campaigns',
            'discovers',
            'admin_shares',
            'my_shares',
            'plays',
            'tabs',
            'exhibitions'
        ) );
    }

    public function dbsetup()
    {

        /*
          Artisan::call('migrate');
          Artisan::call('db:seed');
          Artisan::call('module:seed Admin');
          Artisan::call('module:seed Category');
          Artisan::call('module:seed Setting');

          return "Import Successful";
         */
    }

}
