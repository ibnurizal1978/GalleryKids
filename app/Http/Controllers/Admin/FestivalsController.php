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

class FestivalsController extends Controller
{
    /*------------------------FRONT PAGE--------------------------*/
    public function frontExplore()
    {
        
        $contents = DB::table('festivals_contents')
        ->get();
        //dd(Auth::user()->id);
        //$reactions = Discover::with('reactions')->get();

        $categories = DB::table('festivals_spaces_categories')
        ->where('status', 'Enable')
        ->orderBy('serial')
        ->orderBy('name')
        ->get();
        
        foreach($categories as $category) {
            $datas = DB::select(
                DB::raw("SELECT * FROM exhibitions where (content_start_date IS NULL OR DATE_FORMAT(content_start_date, '%Y-%m-%d') <= CURDATE()) AND (content_expiry_date IS NULL OR DATE_FORMAT(content_expiry_date, '%Y-%m-%d') >= CURDATE()) AND status = 'Enable' AND category_id = $category->id ORDER BY id DESC")
            );
            /*$datas = DB::table('exhibitions')
            ->where('status','Enable')
            ->where('category_id',$category->id)
            ->get();*/

            foreach($datas as $data) {

                if (!preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $data->url, $match ))
                { 
                    $thumbnail = DB::table('exhibition_thumbnails')
                    ->where('exhibition_id',$data->id)
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
                    ->where('reactionable_type','Modules\Exhibition\Entities\Exhibition')
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

        $title = $contents[0]->title;
        $description = $contents[0]->description;
        //return view('/explore/explore', ['categories' => $categories, 'data' => $data, 'thumbnail' => $thumbnail]);
        return view('/festivals/festivals', ['title' => $title, 'description' => $description, 'categories' => $categories, 'datas' => $datas, 'thumbnail' => $thumbnail, 'contents' => $contents, 'reactions' => $reactions]);
    }
    /*------------------------END FRONT PAGE--------------------------*/

    public function pageContent()
    {   
        $data = DB::table('festivals_contents')
        ->get();
        return view('/admin/festivals/pageContent', ['data' => $data]);
       /* return view( 'admin.explore.pageContent', [
            'pageContent' => KcaeContent::first(),
        ] );*/
    }

    public function updatePageContent( Request $r )
    {

        DB::table('festivals_contents')
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
        $data = DB::table('festivals_spaces_categories')
        ->orderBy('serial')
        ->orderBy('name')
        ->get();

        return view('/admin/festivals/spaces/categories/index', ['data' => $data]);
        /*return view( 'admin.explore.spaces.categories.index', [
            'categories' => KcaeSpacesCategory::orderBy( 'serial' )
                                              ->orderBy( 'name' )
                                              ->get()
        ] );*/
    }

    public function addCategory()
    {
        return view( 'admin.festivals.spaces.categories.add' );
    }

    public function insertCategory( Request $r )
    {
        DB::table('festivals_spaces_categories')
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

        return Redirect::route( 'admin.festivals.spaces.categories.index' );
    }

    public function editCategory($id)
    {
        $data = DB::table('festivals_spaces_categories')
        ->where('id', '=', $id)
        ->get();
        return view( 'admin.festivals.spaces.categories.edit', ['data' => $data]);
    }

    public function updateCategory( Request $r )
    {
        DB::table('festivals_spaces_categories')
                ->where('id','=', $r->id)
                ->update([
                    'name'      => $r->input('name'),
                    'serial'    => $r->input('serial'),
                    'status'    => $r->input('status')
                ]);
        
        DB::table('exhibitions')
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

        return Redirect::route( 'admin.festivals.spaces.categories.index' );
    }

    public function deleteCategory($id )
    {
        DB::table('festivals_spaces_categories')
                ->where('id','=', $id)
                ->delete();
       // optional( $category )->delete();

        session()->flash( 'success', 'Category deleted successfully' );

        return Redirect::route( 'admin.festivals.spaces.categories.index' );
    }

    public function spaces()
    {
        $data = DB::table('exhibitions as a')
                ->select('a.id as id', 'b.id as category_id', 'title', 'url', 'content_start_date', 'content_expiry_date', 'a.status as status', 'a.synopsis', 'b.name as name' )
                ->join('festivals_spaces_categories as b','a.category_id','b.id')
                ->get();

        return view('admin.festivals.spaces.index', ['data' => $data]);
    }

    public function addSpace()
    {
        $age_groups = DB::table('age_groups')
        ->get();

        $categories = DB::table('festivals_spaces_categories')
        ->where('status','Enable')
        ->get();

        return view('admin.festivals.spaces.add', ['age_groups' => $age_groups, 'categories' => $categories ]);

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
            
            $data = DB::table('exhibitions')
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

            DB::table('exhibition_thumbnails')
            ->insert([
                'image'                 => 'NO_IMAGE',
                'exhibition_id'           => $last_id,
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
            
            $data = DB::table('exhibitions')
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

            DB::table('exhibition_thumbnails')
            ->insert([
                'image'                 => 'uploads/thumbnails/'.$image->getClientOriginalName(),
                'exhibition_id'           => $last_id,
                'created_at'            => now(),
                'updated_at'            => now()
            ]);

        }
               
        session()->flash( 'success', 'Space added successfully' );
        return Redirect::route( 'admin.festivals.spaces.index' );
    }

    public function editSpace($id)
    {
        $data = DB::table('exhibitions')
        ->where('id',$id)
        ->get();

        $age_groups = DB::table('age_groups')
        ->get();

        $categories = DB::table('festivals_spaces_categories')
        ->where('status','Enable')
        ->get();

        return view('admin.festivals.spaces.edit', ['data' => $data, 'age_groups' => $age_groups, 'categories' => $categories]);
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

           /* DB::table('exhibition_thumbnails')
                ->insert([
                    'image'                 => 'NO_IMAGE',
                    'exhibition_id'           => $r->id,
                    'created_at'            => now(),
                    'updated_at'            => now()
                ]);*/
            
        }else{

            DB::table('exhibition_thumbnails')
            ->where('exhibition_id',$r->id)
            ->where('image','NO_IMAGE')
            ->delete();

            //check is photo is there?
            $check = DB::table('exhibition_thumbnails')
            ->where('exhibition_id',$r->id)
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

                DB::table('exhibition_thumbnails')
                ->insert([
                    'image'                 => 'uploads/thumbnails/'.$image->getClientOriginalName(),
                    'exhibition_id'           => $r->id,
                    'created_at'            => now(),
                    'updated_at'            => now()
                ]);
            }
                          
        }

        if($r->input('members_only')=='') { $members_only = 'No'; }else{ $members_only = 'Yes'; } 
            
        $data = DB::table('exhibitions')
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

        return Redirect::route( 'admin.festivals.spaces.index' );
        
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

        DB::table('exhibition_thumbnails')
                ->where('exhibition_id','=', $id)
                ->limit(1)
                ->delete();

        DB::table('exhibitions')
        ->where('id','=', $id)
        ->limit(1)
        ->delete();

        

       

        session()->flash( 'success', 'Space deleted successfully' );

        return Redirect::route( 'admin.festivals.spaces.index' );
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
