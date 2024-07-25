<?php

namespace Modules\AdminShare\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\AdminShare\Entities\AdminShare;
use Modules\AdminShare\Http\Requests\AdminShareStoreRequest;
use Modules\AdminShare\Http\Requests\AdminShareUpdateRequest;
use Modules\Category\Entities\Category;

class AdminShareController extends Controller
{

    /**
     * This is piction api controller.
     */

    /**
     * get all piction share data
     */

    public function index()
    {
        $shares = AdminShare::with( 'category' )->orderBy( 'id', 'DESC' )->get();

        return view( 'adminshare::index', compact( 'shares' ) );
    }

    /**
     * Sync Function for piction API data in admin ]
     * when admin click this function will retrive all new data
     */
//    03-Dec-20 Share api fixed Request parameter missing in allUpdate Function

    public function allUpdate( Request $request )
    {
        try {
            $client   = new \GuzzleHttp\Client();
            $response = $client->request( 'GET', 'https://dmz.nationalgallery.sg/r/st/Piction_login/USERNAME/TRINAX/PASSWORD/TRINAX/JSON/T', [
                'headers' => [
                    'Accept'  => 'application/json',
                    'SvcAuth' => 'VFJJTkFY,VkEyOFloSjlDd3lCWmRLVA==',
                ],
            ] );
            $data     = json_decode( (string) $response->getBody()->getContents() );
            $SURL     = $data->SURL;


            try {
                $response = $client->request( 'GET', 'https://dmz.nationalgallery.sg/r/st/IQ/surl/' . $SURL . '/OUTPUT_STYLE/COMPACT/RETURN/DIRECT/INCLUDE_DERIVS/2345/URL_PREFIX/https:$PICTIONSLASH$$PICTIONSLASH$dmz.nationalgallery.sg$PICTIONSLASH$piction$PICTIONSLASH$/SHOW_FULLTAG/TRUE/DISABLE_ATTRIBS/category,date_created/METATAG_VIEW/GROUP/METATAGS/ARTWORK%20DATA,KIDS_GALLERY/search/HIER_CATEGORY:%22National%20Collections%20Artworks%20%22%20AND%20META:%22KIDS_GALLERY.PUBLISH_TO_KIDS_CLUB,YES%22', [
                    'headers' => [
                        'Accept'  => 'application/json',
                        'SvcAuth' => 'VFJJTkFY,VkEyOFloSjlDd3lCWmRLVA==',
                    ],
                ] );
                $data     = json_decode( (string) $response->getBody()->getContents() );


//                    foreach($data[''])
            } catch ( \Exception $e ) {
                echo $e->getMessage();
            }


//                    foreach($data[''])
        } catch ( \Exception $e ) {
            echo $e->getMessage();
        }
        unset( $data[0] );

        $image     = '';
        $newARTIST = '';
        $testTitle = '';
        foreach ( $data as $da ) {
            if ( count( AdminShare::whereUid( $da->umo_id )->get() ) ) {

            } else {
                $ARTIST              = $da->metadata->{'ARTWORK DATA.ARTIST'};
                $id                  = $da->umo_id;
                $TITLE               = $da->metadata->{'ARTWORK DATA.TITLE'};
                $CLASSIFICATION      = $da->metadata->{'ARTWORK DATA.CLASSIFICATION'};
                $CREDITLINE          = $da->metadata->{'ARTWORK DATA.CREDITLINE'};
                $DATE_OF_ART_CREATED = $da->metadata->{'ARTWORK DATA.DATE_OF_ART_CREATED'};
                $images              = $da->derivs;
                foreach ( $images as $img ) {
                    $image = $img->url;
                }
                if ( $DATE_OF_ART_CREATED ) {
                    $ART_CREATED = $DATE_OF_ART_CREATED;
                } else {
                    $ART_CREATED = '';
                }
                foreach ( $ARTIST as $Ar ) {

                    $newARTIST = $Ar->{'ARTWORK DATA.ARTIST:ARTIST_DOB'};
                }


                foreach ( $TITLE as $ti ) {
                    $testTitle = $ti;
                }


                $adminShare                       = new AdminShare();
                $dataShare                        = $request->only( [
                    'image',
                    'TITLE',
                    'ARTIST',
                    'DATE_OF_ART_CREATED',
                    'CLASSIFICATION',
                    'CREDITLINE',
                    'status'
                ] );
                $dataShare['image']               = $image;
                $dataShare['uid']                 = $id;
                $dataShare['TITLE']               = $testTitle;
                $dataShare['ARTIST']              = $newARTIST;
                $dataShare['DATE_OF_ART_CREATED'] = $ART_CREATED;
                $dataShare['CLASSIFICATION']      = $CLASSIFICATION;
                $dataShare['CREDITLINE']          = $CREDITLINE;
                $dataShare['status']              = 'Disable';
                //dd($dataShare);
                $adminShare = $adminShare->create( $dataShare );

            }
        }
        session()->flash( 'success', 'success' );

        return redirect()->back();
    }

    /**
     * change status piction share data
     */

    public function changeStatus( $id )
    {

        try {

            $create = AdminShare::findOrFail( $id );
            $status = 'Disable';
            if ( $create->status == 'Disable' ) {
                $status = 'Enable';
            }
            $create->status = $status;
            $create->save();
        } catch ( \Exception $e ) {

            session()->flash( 'error', $e->getMessage() );

            return redirect()->back();
        }

        session()->flash( 'success', "Create status changed to {$create->status} successfully" );

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view( 'adminshare::create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminShareStoreRequest $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store( AdminShareStoreRequest $request )
    {
        $data = $request->validated();
        $uid  = $data['uid'] ?? time();

        AdminShare::create( [
            'uid'                 => $uid,
            'image'               => $this->uploadImage( $request, $uid ),
            'TITLE'               => $data['title'],
            'category_id'         => $data['category_id'],
            'ARTIST'              => $data['artist'],
            'DATE_OF_ART_CREATED' => $data['created'],
            'medium'              => $data['classification'],
            'dimension'           => $data['dimension'],
            'CREDITLINE'          => $data['creditline'],
            'status'              => 'Enable',
        ] );

        session()->flash( 'success', 'Added Successfully!' );

        return redirect( '/adminShare/list' );
    }

    /**
     * Add category view load.
     * @return Response
     */
    public function show( $id )
    {
        $share      = AdminShare::orderBy( 'id', 'DESC' )->find( $id );
        $categories = Category::whereType( 'pictionShare' )->get();

        return view( 'adminshare::addCategory', compact( 'categories', 'share' ) );
    }


    /**
     * Add category .
     * @return Response
     */
    public function update( Request $request, $id )
    {
        $data = $request->except( '_token' );
        try {

            $category = AdminShare::findOrFail( $id );

            $category->update( $data );

        } catch ( \Exception $e ) {

            session()->flash( 'error', $e->getMessage() );

            return redirect()->back();

        }

        session()->flash( 'success', 'updated successfully' );

        return redirect( '/adminShare/list' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AdminShare $share
     *
     * @return RedirectResponse
     */
    public function destroy( AdminShare $share )
    {
        $share->delete();

        session()->flash( 'success', 'Deleted successfully!' );

        return redirect()->back();
    }

    public function sync()
    {
        $command = Artisan::call( 'piction:sync' );
        if ( $command ) {
            session()->flash( 'success', 'All artworks from piction API synced successfully' );
        } else {
            session()->flash( 'error', 'Couldn\'t sync artworks. Please try again later' );
        }

        return redirect( '/adminShare/list' );
    }

    public function add()
    {
        $categories = Category::whereType( 'pictionShare' )->get();

        return view( 'adminshare::add', compact( 'categories' ) );
    }

    public function edit( AdminShare $share )
    {
        $categories = Category::whereType( 'pictionShare' )->get();

        return view( 'adminshare::edit', compact( 'categories', 'share' ) );
    }

    public function updateShare( AdminShareUpdateRequest $request, AdminShare $share )
    {
        $share->TITLE               = $request->input( 'title' );
        $share->ARTIST              = $request->input( 'artist' );
        $share->DATE_OF_ART_CREATED = $request->input( 'created' );
        $share->medium              = $request->input( 'classification' );
        $share->dimension           = $request->input( 'dimension' );
        $share->CREDITLINE          = $request->input( 'creditline' );
        $share->category_id         = $request->input( 'category_id' );

        if ( $request->hasFile( 'image' ) ) {
            $share->image = $this->uploadImage( $request, $share->uid );
        }

        if ( $share->isDirty() ) {
            $share->save();
        }

        session()->flash( 'success', 'Updated Successfully!' );

        return redirect( '/adminShare/list' );
    }

    protected function uploadImage( Request $request, $uid, $key = 'image' )
    {
        if ( $request->hasFile( $key ) ) {
            $image = $request->file( $key );
            $name  = Str::slug( $request->get( 'title' ) ?? $uid ) . '.' . $image->getClientOriginalExtension();
            $path  = AdminShare::IMAGES_UPLOADS_FOLDER . $uid;
            $disk  = get_publicly_accessible_disk();

            if ( Storage::disk( $disk )->has( $path ) ) {
                Storage::disk( $disk )->delete( $path );
            }

            $image->storeAs( $path, $name, $disk );

            return $name;
        }

        return null;
    }
}
