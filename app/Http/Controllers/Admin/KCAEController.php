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

class KCAEController extends Controller
{
    public function pageContent()
    {
        return view( 'admin.kcae.pageContent', [
            'pageContent' => KcaeContent::first(),
        ] );
    }

    public function updatePageContent( KCAEContentEditRequest $request )
    {
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

        session()->flash( 'success', 'Content updated successfully!' );

        return back();
    }

    public function categories()
    {
        return view( 'admin.kcae.spaces.categories.index', [
            'categories' => KcaeSpacesCategory::orderBy( 'serial' )
                                              ->orderBy( 'name' )
                                              ->get()
        ] );
    }

    public function addCategory()
    {
        return view( 'admin.kcae.spaces.categories.add' );
    }

    public function insertCategory( KCAESpacesCategoryStoreRequest $request )
    {
        KcaeSpacesCategory::create(
            $request->only( [
                'name',
                'serial',
                'status'
            ] )
        );

        session()->flash( 'success', 'Category added successfully' );

        return Redirect::route( 'admin.kcae.spaces.categories.index' );
    }

    public function editCategory( KcaeSpacesCategory $category )
    {
        return view( 'admin.kcae.spaces.categories.edit', compact( 'category' ) );
    }

    public function updateCategory( KcaeSpacesCategory $category, KCAESpacesCategoryUpdateRequest $request )
    {
        $category->fill(
            $request->only( [ 'name', 'serial', 'status' ] )
        );

        if ( $category->isDirty() ) {
            $category->save();
        }

        session()->flash( 'success', 'Category updated successfully' );

        return Redirect::route( 'admin.kcae.spaces.categories.index' );
    }

    public function deleteCategory( KcaeSpacesCategory $category )
    {
        optional( $category )->delete();

        session()->flash( 'success', 'Category deleted successfully' );

        return Redirect::route( 'admin.kcae.spaces.categories.index' );
    }

    public function spaces()
    {
        return view( 'admin.kcae.spaces.index', [
            'spaces' => KcaeSpace::with( 'category' )->get()
        ] );
    }

    public function addSpace()
    {
        return view( 'admin.kcae.spaces.add', [
            'categories' => KcaeSpacesCategory::where( 'status', '=', 'enabled' )
                                              ->orderBy( 'serial' )
                                              ->get()
        ] );
    }

    public function insertSpace( KCAESpaceStoreRequest $request )
    {
        $image     = $request->file( 'image' );
        $imageName = Str::slug( $request->get( 'name' ) ) . '_'
                     . time() . '.' . $image->extension();
        $image->storeAs(
            KCAESpace::IMAGE_DIRECTORY,
            $imageName,
            'public_uploads'
        );

        $data          = $request->only( [ 'name', 'description', 'category_id' ] );
        $data['image'] = $imageName;

        KcaeSpace::create( $data );

        session()->flash( 'success', 'Space added successfully' );

        return Redirect::route( 'admin.kcae.spaces.index' );
    }

    public function editSpace( KcaeSpace $space )
    {
        $categories = KcaeSpacesCategory::where( 'status', '=', 'enabled' )
                                        ->orderBy( 'serial' )
                                        ->get();

        return view( 'admin.kcae.spaces.edit', compact( 'space', 'categories' ) );
    }

    public function updateSpace( KcaeSpace $space, KCAESpaceUpdateRequest $request )
    {
        $space->fill(
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

        return Redirect::route( 'admin.kcae.spaces.index' );
    }

    public function deleteSpace( KcaeSpace $space )
    {
        optional( $space )->delete();

        session()->flash( 'success', 'Space deleted successfully' );

        return Redirect::route( 'admin.kcae.spaces.index' );
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
