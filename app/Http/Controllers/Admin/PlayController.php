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
use Modules\Play\Entities\Play;
use Session;
use Auth;

class PlayController extends Controller
{
    /*------------------------FRONT PAGE--------------------------*/
    public function frontExplore()
    {
        
        $contents = DB::table('play_contents')
        ->get();
        //dd(Auth::user()->id);
        //$reactions = Discover::with('reactions')->get();

        $categories = DB::table('play_spaces_categories')
        ->where('status', 'Enable')
        ->orderBy('serial')
        ->orderBy('name')
        ->get();
        
        foreach($categories as $category) {
            $datas = DB::table('plays')
            ->where('status','Enable')
            ->where('category_id',$category->id)
            ->orderBy('id','DESC')
            ->get();
            
            foreach($datas as $data) {
                if(Auth::user())
                {
                    DB::enableQueryLog();
                    $id = Auth::user()->id;
                    $reactions = DB::table('reactions')
                    ->where('reactionable_type','Modules\Play\Entities\Play')
                    ->where('user_id',$id)
                    ->where('reactionable_id',$data->id)
                    ->first();
                    //dd(DB::getQueryLog());
                    //dd($reactions);
                    $data->reactions = $reactions;
                }else{
                    $data->reactions = '';
                    $reactions = '';
                }       
            }

        $category->datas = $datas;  

        	if(Auth::user()) 
		{ 
		$category->reactions = $reactions; 
		} else {  
		$category->reactions = ''; 
		}
        }

        $title = $contents[0]->title;
        $description = $contents[0]->description;
        return view('/play/play', ['title' => $title, 'description' => $description, 'categories' => $categories, 'datas' => $datas, 'contents' => $contents, 'reactions' => $reactions]);
    }
    /*------------------------END FRONT PAGE--------------------------*/

    public function pageContent()
    {   
        $data = DB::table('play_contents')
        ->get();
        return view('/admin/play/pageContent', ['data' => $data]);
       /* return view( 'admin.explore.pageContent', [
            'pageContent' => KcaeContent::first(),
        ] );*/
    }

    public function updatePageContent( Request $r )
    {

        DB::table('play_contents')
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
        $data = DB::table('play_spaces_categories')
        ->orderBy('serial')
        ->orderBy('name')
        ->get();

        return view('/admin/play/spaces/categories/index', ['data' => $data]);
        /*return view( 'admin.explore.spaces.categories.index', [
            'categories' => KcaeSpacesCategory::orderBy( 'serial' )
                                              ->orderBy( 'name' )
                                              ->get()
        ] );*/
    }

    public function addCategory()
    {
        return view( 'admin.play.spaces.categories.add' );
    }

    public function insertCategory( Request $r )
    {
        DB::table('play_spaces_categories')
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

        return Redirect::route( 'admin.play.spaces.categories.index' );
    }

    public function editCategory($id)
    {
        $data = DB::table('play_spaces_categories')
        ->where('id', '=', $id)
        ->get();
        return view( 'admin.play.spaces.categories.edit', ['data' => $data]);
    }

    public function updateCategory( Request $r )
    {
        DB::table('play_spaces_categories')
                ->where('id','=', $r->id)
                ->update([
                    'name'      => $r->input('name'),
                    'serial'    => $r->input('serial'),
                    'status'    => $r->input('status')
                ]);

        DB::table('plays')
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

        return Redirect::route( 'admin.play.spaces.categories.index' );
    }

    public function deleteCategory($id )
    {
        DB::table('play_spaces_categories')
                ->where('id','=', $id)
                ->delete();
       // optional( $category )->delete();

        session()->flash( 'success', 'Category deleted successfully' );

        return Redirect::route( 'admin.play.spaces.categories.index' );
    }

    public function spaces()
    {
        $data = DB::table('plays as a')
                ->select('a.id as id', 'b.id as category_id', 'title', 'url', 'a.status as status', 'a.synopsis', 'b.name as name' )
                ->join('play_spaces_categories as b','a.category_id','b.id')
                ->get();

        return view('admin.play.spaces.index', ['data' => $data]);
    }

    public function addSpace()
    {
        $age_groups = DB::table('age_groups')
        ->get();

        $categories = DB::table('play_spaces_categories')
        ->where('status','Enable')
        ->get();

        return view('admin.play.spaces.add', ['age_groups' => $age_groups, 'categories' => $categories ]);

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
            
            DB::table('plays')
                ->insert([
                    'title'                 => $r->input('title'),
                    'synopsis'              => $r->input('synopsis'),
                    'url'                   => $r->input('url'),
                    'status'                => 'Enable',
                    'thumbnail'             => 'NO_IMAGE',
                    'category_id'           => $r->input('category_id'),
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
            
            DB::table('plays')
                ->insert([
                    'title'                 => $r->input('title'),
                    'synopsis'              => $r->input('synopsis'),
                    'url'                   => $r->input('url'),
                    'status'                => 'Enable',
                    'thumbnail'             => 'uploads/thumbnails/'.$image->getClientOriginalName(),
                    'category_id'           => $r->input('category_id'),
                    'created_at'            => now(),
                    'updated_at'            => now()
                ]);

        }
               
        session()->flash( 'success', 'Space added successfully' );
        return Redirect::route( 'admin.play.spaces.index' );
    }

    public function editSpace($id)
    {
        $data = DB::table('plays')
        ->where('id',$id)
        ->get();

        $age_groups = DB::table('age_groups')
        ->get();

        $categories = DB::table('play_spaces_categories')
        ->where('status','Enable')
        ->get();

        return view('admin.play.spaces.edit', ['data' => $data, 'age_groups' => $age_groups, 'categories' => $categories]);
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
            
            DB::table('plays')
                ->where('id',$r->id)
                ->update([
                    'title'                 => $r->input('title'),
                    'synopsis'              => $r->input('synopsis'),
                    'url'                   => $r->input('url'),
                    'thumbnail'             => 'NO_IMAGE',
                    'status'                => 'Enable',
                    'category_id'           => $r->input('category_id'),
                    'updated_at'            => now()
                ]);
                
        }else{

            //check is photo is there?
            $check = DB::table('plays')
            ->where('id',$r->id)
            ->get();

            if($check[0]->thumbnail == '' || $check[0]->thumbnail == 'NO_IMAGE' && $r->file('thumbnails') == '') 
            {
                echo '1';

                return redirect()->back()->withInput()->withErrors('please upload thumbnail');
            }elseif($r->file('thumbnails') <> ''){

                echo '2';
                $image     = $r->file('thumbnails');
                $file_name  = $image->getClientOriginalName();
                $file_ext   = $image->getClientOriginalExtension();
                $destinationPath = 'public/uploads/thumbnails/';
                $image->move($destinationPath,$image->getClientOriginalName());

                
                DB::table('plays')
                    ->where('id',$r->id)
                    ->update([
                        'title'                 => $r->input('title'),
                        'synopsis'              => $r->input('synopsis'),
                        'url'                   => $r->input('url'),
                        'status'                => 'Enable',
                        'thumbnail'             => 'uploads/thumbnails/'.$image->getClientOriginalName(),
                        'category_id'           => $r->input('category_id'),
                        'updated_at'            => now()
                ]);
            
            }else{

                echo '3';

                DB::table('plays')
                    ->where('id',$r->id)
                    ->update([
                        'title'                 => $r->input('title'),
                        'synopsis'              => $r->input('synopsis'),
                        'url'                   => $r->input('url'),
                        'status'                => 'Enable',
                        'category_id'           => $r->input('category_id'),
                        'updated_at'            => now()
                ]);

            }
                
            
                   

            echo '4';
        }
                
        session()->flash( 'success', 'Space update successfully' );

        return Redirect::route( 'admin.play.spaces.index' );
        
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

        DB::table('plays')
                ->where('id','=', $id)
                ->limit(1)
                ->delete();
        session()->flash( 'success', 'Space deleted successfully' );

        return Redirect::route( 'admin.play.spaces.index' );
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
