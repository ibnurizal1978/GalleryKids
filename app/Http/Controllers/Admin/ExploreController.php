<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KCAEContentEditRequest;
use App\Http\Requests\Admin\KCAESpacesCategoryStoreRequest;
use App\Http\Requests\Admin\KCAESpacesCategoryUpdateRequest;
use App\Http\Requests\Admin\KCAESpaceSlideStoreRequest;
use App\Http\Requests\Admin\KCAESpaceSlideUpdateRequest;
use App\Http\Requests\Admin\KCAESpaceStoreRequest;
use App\Http\Requests\Admin\KCAESpaceUpdateRequest;
use App\KcaeSpaceSlide;
use App\Models\KcaeContent;
use App\Models\KcaeSpace;
use App\Models\KcaeSpacesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Modules\Discover\Entities\Discover;
use Session;
use Auth;

class ExploreController extends Controller
{
    /*------------------------FRONT PAGE--------------------------*/
    public function frontExplore()
    {
        
        $contents = DB::table('explore_contents')
        ->get();
        //dd(Auth::user()->id);
        //$reactions = Discover::with('reactions')->get();

        $categories = DB::table('discover_spaces_categories')
        ->where('status', 'Enable')
        ->orderBy('serial')
        ->orderBy('name')
        ->get();
        
        foreach($categories as $category) {
            
            $datas = DB::select(
                DB::raw("SELECT * FROM discovers where (content_start_date IS NULL OR DATE_FORMAT(content_start_date, '%Y-%m-%d') <= CURDATE()) AND (content_expiry_date IS NULL OR DATE_FORMAT(content_expiry_date, '%Y-%m-%d') >= CURDATE()) AND category_id = $category->id AND status = 'Enable' ORDER BY id DESC")
            );
            /*DB::enableQueryLog();
            $datas = DB::table('explore_spaces')
            ->where('status','Enable') //SELECT * FROM `explore_spaces` where (content_start_date IS NULL OR DATE_FORMAT(content_start_date, '%Y-%m-%d') <= CURDATE()) AND (content_expiry_date IS NULL OR DATE_FORMAT(content_expiry_date, '%Y-%m-%d') >= CURDATE()) ORDER BY `content_start_date` DESC
            ->where('category_id',$category->id)
            ->where("(content_start_date IS NULL OR DATE_FORMAT(content_start_date, '%Y-%m-%d') <= CURDATE())")
            ->where("(content_expiry_date IS NULL OR DATE_FORMAT(content_expiry_date, '%Y-%m-%d') >= CURDATE())")
            ->get();
            dd(DB::showQueryLog());
            dd($datas);*/

            foreach($datas as $data) {

                if (!preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $data->url, $match ))
                { 
                    $thumbnail = DB::table('discover_thumbnails')
                    ->where('discover_id',$data->id)
                    ->orderby('id','DESC')
                    ->first();
                    $data->thumbnail = $thumbnail;
                }else{
                    $thumbnail = '';
                }

                DB::enableQueryLog();
                if(Auth::user())
                {
                    DB::enableQueryLog();
                    $id = Auth::user()->id;
                    $reactions = DB::table('reactions')
                    ->where('reactionable_type','Modules\Discover\Entities\Discover')
                    ->where('user_id',$id)
                    ->where('reactionable_id',$data->id)
                    ->first();
                    //dd(DB::getQueryLog());
                    $data->reactions = $reactions;
                }else{
                    $data->reactions = '';
                    $reactions = '';
                }
                
                $data->thumbnail = $thumbnail;
                
            }
           // dd(DB::getQueryLog());
           // dd('tai');
        $category->datas = $datas;
        //$category->reactions = $reactions; 
        //$category->thumbnail = $thumbnail;
        //dd($category->reactions);
        //if (!preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $data->url, $match )) { $category->thumbnail = $thumbnail; }else{ $category->thumbnail = ''; }
        if(Auth::user()) 
        { 
           // $category->reactions = $reactions; 
        } else {  
           // $category->reactions = ''; 
        }
        }
        //return view('/explore/explore', ['categories' => $categories, 'data' => $data, 'thumbnail' => $thumbnail]);
        return view('/explore/explore', ['categories' => $categories, 'datas' => $datas, 'thumbnail' => $thumbnail, 'contents' => $contents, 'reactions' => $reactions]);
    }
    /*------------------------END FRONT PAGE--------------------------*/



    public function frontExplore1()
    {
        
        $contents = DB::table('explore_contents')
        ->get();
        $categories = DB::table('discover_spaces_categories')
        ->where('status', 'Enable')
        ->orderBy('serial')
        ->orderBy('name')
        ->get();
        
        foreach($categories as $category) {
            
            $datas = DB::select(
                DB::raw("SELECT * FROM discovers where (content_start_date IS NULL OR DATE_FORMAT(content_start_date, '%Y-%m-%d') <= CURDATE()) AND (content_expiry_date IS NULL OR DATE_FORMAT(content_expiry_date, '%Y-%m-%d') >= CURDATE()) AND category_id = $category->id AND status = 'Enable' ORDER BY id DESC LIMIT 3")
            );

            foreach($datas as $data) {

                if (!preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $data->url, $match ))
                { 
                    $thumbnail = DB::table('discover_thumbnails')
                    ->where('discover_id',$data->id)
                    ->orderby('id','DESC')
                    ->first();
                    $data->thumbnail = $thumbnail;
                }else{
                    $thumbnail = '';
                }

                DB::enableQueryLog();
                if(Auth::user())
                {
                    DB::enableQueryLog();
                    $id = Auth::user()->id;
                    $reactions = DB::table('reactions')
                    ->where('reactionable_type','Modules\Discover\Entities\Discover')
                    ->where('user_id',$id)
                    ->where('reactionable_id',$data->id)
                    ->first();
                    //dd(DB::getQueryLog());
                    $data->reactions = $reactions;
                }else{
                    $data->reactions = '';
                    $reactions = '';
                }
                
                $data->thumbnail = $thumbnail;
                
            }
        $category->datas = $datas;
        }
        return view('/explore/explore1', ['categories' => $categories, 'datas' => $datas, 'thumbnail' => $thumbnail, 'contents' => $contents, 'reactions' => $reactions]);
    }

    public function frontExploreDetail(Request $r)
    {
        
        $contents = DB::table('explore_contents')
        ->get();
        DB::enableQueryLog();
        $categories = DB::table('discover_spaces_categories')
        ->where('id','=',$r->id)
        ->where('status', 'Enable')
        ->orderBy('serial')
        ->orderBy('name')
        ->get();
        //dd(DB::getQueryLog());
        //dd($categories);
        
        foreach($categories as $category) {
            
            $datas = DB::select(
                DB::raw("SELECT * FROM discovers where (content_start_date IS NULL OR DATE_FORMAT(content_start_date, '%Y-%m-%d') <= CURDATE()) AND (content_expiry_date IS NULL OR DATE_FORMAT(content_expiry_date, '%Y-%m-%d') >= CURDATE()) AND category_id = $category->id AND status = 'Enable' ORDER BY id DESC")
            );

            foreach($datas as $data) {

                if (!preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $data->url, $match ))
                { 
                    $thumbnail = DB::table('discover_thumbnails')
                    ->where('discover_id',$data->id)
                    ->orderby('id','DESC')
                    ->first();
                    $data->thumbnail = $thumbnail;
                }else{
                    $thumbnail = '';
                }

                DB::enableQueryLog();
                if(Auth::user())
                {
                    DB::enableQueryLog();
                    $id = Auth::user()->id;
                    $reactions = DB::table('reactions')
                    ->where('reactionable_type','Modules\Discover\Entities\Discover')
                    ->where('user_id',$id)
                    ->where('reactionable_id',$data->id)
                    ->first();
                    //dd(DB::getQueryLog());
                    $data->reactions = $reactions;
                }else{
                    $data->reactions = '';
                    $reactions = '';
                }
                
                $data->thumbnail = $thumbnail;
                
            }
        $category->datas = $datas;
        }
        return view('/explore/explore_detail', ['categories' => $categories, 'datas' => $datas, 'thumbnail' => $thumbnail, 'contents' => $contents, 'reactions' => $reactions]);
    }



    public function pageContent()
    {   
        $data = DB::table('explore_contents')
        ->get();
        return view('/admin/explore/pageContent', ['data' => $data]);
       /* return view( 'admin.explore.pageContent', [
            'pageContent' => KcaeContent::first(),
        ] );*/
    }

    public function updatePageContent( Request $r )
    {

        DB::table('explore_contents')
                ->update([
                    'title'                 => $r->input('title'),
                    'description'           => $r->input('description'),
                    'hero_slider_title'     => $r->input('hero_slider_title'),
                    'mid-section'           => $r->input('mid-section'),
                    'mid-section'           => $r->input('mid-section'),
                    'last-section-top'      => $r->input('last-section-top'),
                    'last-section-box1'     => $r->input('last-section-box1'),
                    'last-section-box2'     => $r->input('last-section-box2'),
                    'last-section-box3'     => $r->input('last-section-box3'),
                    'last-section-bottom'   => $r->input('last-section-bottom')
                ]);
        /*
        $content = KcaeContent::firstOrNew();
        $content->fill( $request->only( [
            'title',
            'description',
            'hero_slider_title',
            'mid-section',
            'last-section-top',
            'last-section-box1',
            'last-section-box2',
            'last-section-box3',
            'last-section-bottom'
        ] ) );

        if ( $content->isDirty() ) {
            $content->save();
        }
        */

        session()->flash( 'success', 'Content updated successfully!' );

        return back();
    }

    public function categories()
    {
        $data = DB::table('discover_spaces_categories')
        ->orderBy('serial')
        ->orderBy('name')
        ->get();

        return view('/admin/explore/spaces/categories/index', ['data' => $data]);
        /*return view( 'admin.explore.spaces.categories.index', [
            'categories' => KcaeSpacesCategory::orderBy( 'serial' )
                                              ->orderBy( 'name' )
                                              ->get()
        ] );*/
    }

    public function addCategory()
    {
        return view( 'admin.explore.spaces.categories.add' );
    }

    public function insertCategory( Request $r )
    {
        DB::table('discover_spaces_categories')
                ->insert([
                    'name'       => $r->input('name'),
                    'serial'     => $r->input('serial'),
                    'status'     => $r->input('status')
                ]);
       /* KcaeSpacesCategory::create(
            $request->only( [
                'name',
                'serial',
                'status'
            ] )
        );*/

        session()->flash( 'success', 'Category added successfully' );

        return Redirect::route( 'admin.explore.spaces.categories.index' );
    }

    public function editCategory($id)
    {
        $data = DB::table('discover_spaces_categories')
        ->where('id', '=', $id)
        ->get();
        return view( 'admin.explore.spaces.categories.edit', ['data' => $data]);
    }

    public function updateCategory( Request $r )
    {
        DB::table('discover_spaces_categories')
                ->where('id','=', $r->id)
                ->update([
                    'name'      => $r->input('name'),
                    'serial'    => $r->input('serial'),
                    'status'    => $r->input('status')
                ]);

        DB::table('discovers')
                ->where('category_id','=', $r->id)
                ->update([
                    'status'    => $r->input('status')
                ]);


        /*        
        $category->fill(
            $request->only( [ 'name', 'serial', 'status' ] )
        );

        if ( $category->isDirty() ) {
            $category->save();
        }*/

        session()->flash( 'success', 'Category updated successfully' );

        return Redirect::route( 'admin.explore.spaces.categories.index' );
    }

    public function deleteCategory($id )
    {
        DB::table('discover_spaces_categories')
                ->where('id','=', $id)
                ->delete();
       // optional( $category )->delete();

        session()->flash( 'success', 'Category deleted successfully' );

        return Redirect::route( 'admin.explore.spaces.categories.index' );
    }

    public function spaces()
    {
        $data = DB::table('discovers as a')
                ->select('a.id as id', 'b.id as category_id', 'title', 'url', 'content_start_date', 'content_expiry_date', 'a.status as status', 'a.synopsis', 'b.name as name' )
                ->join('discover_spaces_categories as b','a.category_id','b.id')
                ->get();

        return view('admin.explore.spaces.index', ['data' => $data]);
    }

    public function addSpace()
    {
        $age_groups = DB::table('age_groups')
        ->get();

        $categories = DB::table('discover_spaces_categories')
        ->where('status','Enable')
        ->get();

        return view('admin.explore.spaces.add', ['age_groups' => $age_groups, 'categories' => $categories ]);

        /*return view( 'admin.explore.spaces.add', [
            'categories' => KcaeSpacesCategory::where( 'status', '=', 'enabled' )
                                              ->orderBy( 'serial' )
                                              ->get()
        ] );*/
    }

    public function insertSpace(Request $r )
    {
        if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $r->url, $match ) ) 
        {

            if($r->input('members_only')=='') { $members_only = 'No'; }else{ $members_only = 'Yes'; } 
            
            $data = DB::table('discovers')
                    ->insert([
                        'title'                 => $r->input('title'),
                        'synopsis'              => $r->input('synopsis'),
                        'url'                   => $r->input('url'),
                        'content_start_date'    => $r->input('content_start_date'),
                        'content_expiry_date'   => $r->input('content_expiry_date'),
                        'status'                => 'Enable',
                        'members_only'          => $members_only,
                        'category_id'           => $r->input('category_id'),
                        'created_at'            => now(),
                        'updated_at'            => now()
                    ]);
            $last_id = DB::getPdo()->lastInsertId();

            DB::table('discover_thumbnails')
            ->insert([
                'image'                 => 'NO_IMAGE',
                'discover_id'           => $last_id,
                'created_at'            => now(),
                'updated_at'            => now()
            ]);

        }else{
            
            if($r->file('thumbnails') == '')
            {
                return redirect()->back()->withInput()->withErrors('please upload thumbnail');
            }        

            $image     = $r->file('thumbnails');
            $file_name  = $image->getClientOriginalName();
            $file_ext   = $image->getClientOriginalExtension();
            $destinationPath = 'public/uploads/thumbnails/';
            $image->move($destinationPath,$image->getClientOriginalName());

            if($r->input('members_only')=='') { $members_only = 'No'; }else{ $members_only = 'Yes'; } 
            
            $data = DB::table('discovers')
                    ->insert([
                        'title'                 => $r->input('title'),
                        'synopsis'              => $r->input('synopsis'),
                        'url'                   => $r->input('url'),
                        'content_start_date'    => $r->input('content_start_date'),
                        'content_expiry_date'   => $r->input('content_expiry_date'),
                        'status'                => 'Enable',
                        'members_only'          => $members_only,
                        'category_id'           => $r->input('category_id'),
                        'created_at'            => now(),
                        'updated_at'            => now()
                    ]);
            $last_id = DB::getPdo()->lastInsertId();

            DB::table('discover_thumbnails')
            ->insert([
                'image'                 => 'uploads/thumbnails/'.$image->getClientOriginalName(),
                'discover_id'           => $last_id,
                'created_at'            => now(),
                'updated_at'            => now()
            ]);

        }
               
        session()->flash( 'success', 'Space added successfully' );
        return Redirect::route( 'admin.explore.spaces.index' );
    }

    public function editSpace($id)
    {
        $data = DB::table('discovers')
        ->where('id',$id)
        ->get();

        $age_groups = DB::table('age_groups')
        ->get();

        $categories = DB::table('discover_spaces_categories')
        ->where('status','Enable')
        ->get();

        return view('admin.explore.spaces.edit', ['data' => $data, 'age_groups' => $age_groups, 'categories' => $categories]);
       /* $categories = KcaeSpacesCategory::where( 'status', '=', 'enabled' )
            ->orderBy( 'serial' )
            ->get();

                                        
            //return view( 'admin.kcae.spaces.edit', compact( 'space', 'categories' ) );*/
    }

    //public function updateSpace( KcaeSpace $space, KCAESpaceUpdateRequest $request )
    public function updateSpace( Request $r)
    {
        if (preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $r->url, $match ) ) 
        {

            /*DB::table('explore_thumbnails')
                ->insert([
                    'image'                 => 'NO_IMAGE',
                    'discover_id'           => $r->id,
                    'created_at'            => now(),
                    'updated_at'            => now()
                ]);*/
            
        }else{

            DB::table('discover_thumbnails')
            ->where('discover_id',$r->id)
            ->where('image','NO_IMAGE')
            ->delete();

            //check is photo is there?
            $check = DB::table('discover_thumbnails')
            ->where('discover_id',$r->id)
            ->count();

            if($check == 0) {

                if($r->file('thumbnails') == '') 
                {
                    return redirect()->back()->withInput()->withErrors('please upload thumbnail');
                }

            }

            if($r->file('thumbnails') <> '') {
                $image     = $r->file('thumbnails');
                $file_name  = $image->getClientOriginalName();
                $file_ext   = $image->getClientOriginalExtension();
                $destinationPath = 'public/uploads/thumbnails/';
                $image->move($destinationPath,$image->getClientOriginalName());

                DB::table('discover_thumbnails')
                ->insert([
                    'image'                 => 'uploads/thumbnails/'.$image->getClientOriginalName(),
                    'discover_id'           => $r->id,
                    'created_at'            => now(),
                    'updated_at'            => now()
                ]);
            }
                          
        }

        if($r->input('members_only')=='') { $members_only = 'No'; }else{ $members_only = 'Yes'; } 
            
        $data = DB::table('discovers')
            ->where('id',$r->id)
            ->update([
                'title'                 => $r->input('title'),
                'synopsis'              => $r->input('synopsis'),
                'url'                   => $r->input('url'),
                'content_start_date'    => $r->input('content_start_date'),
                'content_expiry_date'   => $r->input('content_expiry_date'),
                'status'                => 'Enable',
                'members_only'          => $members_only,
                'category_id'           => $r->input('category_id'),
                'updated_at'            => now()
            ]);
                
        session()->flash( 'success', 'Space update successfully' );

        return Redirect::route( 'admin.explore.spaces.index' );
        
        /*$space->fill(
            $request->only( [ 'name', 'description', 'category_id' ] )
        );

        if ( $request->hasFile( 'image' ) ) {
            $image     = $request->file( 'image' );
            $imageName = Str::slug( $request->get( 'name' ) ) . '_'
                         . time() . '.' . $image->extension();
            $image->storeAs(
                KCAESpace::IMAGE_DIRECTORY,
                $imageName,
                'public_uploads'
            );

            $space->image = $imageName;
        }

        if ( $space->isDirty() ) {
            $space->save();
        }

        session()->flash( 'success', 'Space updated successfully' );

        return Redirect::route( 'admin.kcae.spaces.index' );*/
    }

    public function deleteSpace($id)
    {
        //optional( $space )->delete();

        DB::table('reactions')
                ->where('reactionable_id','=', $id)
                ->where('reactionable_type','=', 'Modules\Discover\Entities\Discover')
                ->delete();
        
        DB::table('archives')
                ->where('archivable_id','=', $id)
                ->where('archivable_type','=', 'Modules\Discover\Entities\Discover')
                ->delete();


        DB::table('discover_thumbnails')
                ->where('discover_id','=', $id)
                ->limit(1)
                ->delete();

        DB::table('discovers')
                ->where('id','=', $id)
                ->limit(1)
                ->delete();
        session()->flash( 'success', 'Space deleted successfully' );

        return Redirect::route( 'admin.explore.spaces.index' );
    }

    public function slides()
    {
        return view( 'admin.kcae.spaces.slides.index', [
            'slides' => KcaeSpaceSlide::with( 'space.category' )
                                      ->get(),
        ] );
    }

    public function addSlide()
    {
        return view( 'admin.kcae.spaces.slides.add', [
            'spaces' => KcaeSpace::with( 'category' )
                                 ->orderBy( 'name' )
                                 ->get(),
        ] );
    }

    public function insertSlide( KCAESpaceSlideStoreRequest $request )
    {
        $image     = $request->file( 'image' );
        $imageName = Str::slug( $request->get( 'name' ) ) . '_'
                     . time() . '.' . $image->extension();
        $image->storeAs(
            KcaeSpaceSlide::IMAGE_DIRECTORY,
            $imageName,
            'public_uploads'
        );

        $data          = $request->only( [ 'name', 'description', 'space_id' ] );
        $data['image'] = $imageName;

        KcaeSpaceSlide::create( $data );

        session()->flash( 'success', 'Slide added successfully' );

        return Redirect::route( 'admin.kcae.spaces.slides.index' );
    }

    public function editSlide( KcaeSpaceSlide $slide )
    {
        $spaces = KcaeSpace::with( 'category' )
                           ->orderBy( 'name' )
                           ->get();

        return view( 'admin.kcae.spaces.slides.edit', compact( 'slide', 'spaces' ) );
    }

    public function updateSlide( KcaeSpaceSlide $slide, KCAESpaceSlideUpdateRequest $request )
    {
        $slide->fill(
            $request->only( [ 'name', 'description', 'space_id' ] )
        );

        if ( $request->hasFile( 'image' ) ) {
            $image     = $request->file( 'image' );
            $imageName = Str::slug( $request->get( 'name' ) ) . '_'
                         . time() . '.' . $image->extension();
            $image->storeAs(
                KcaeSpaceSlide::IMAGE_DIRECTORY,
                $imageName,
                'public_uploads'
            );

            $slide->image = $imageName;
        }

        if ( $slide->isDirty() ) {
            $slide->save();
        }

        session()->flash( 'success', 'Slide updated successfully' );

        return Redirect::route( 'admin.kcae.spaces.slides.index' );
    }

    public function deleteSlide( KcaeSpaceSlide $slide )
    {
        optional( $slide )->delete();

        session()->flash( 'success', 'Slide deleted successfully' );

        return Redirect::route( 'admin.kcae.spaces.slides.index' );
    }
}
