<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KCAEHeroSlideStoreRequest;
use App\Http\Requests\Admin\KCAEHeroSlideUpdateRequest;
use App\KcaeHeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class KCAEHeroSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view( 'admin.kcae.hero-slides.index', [
            'slides' => KcaeHeroSlide::all(),
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view( 'admin.kcae.hero-slides.add' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param KCAEHeroSlideStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( KCAEHeroSlideStoreRequest $request )
    {
        $image     = $request->file( 'image' );
        $imageName = Str::slug( $request->get( 'name' ) ) . '_'
                     . time() . '.' . $image->extension();
        $image->storeAs(
            KcaeHeroSlide::IMAGE_DIRECTORY,
            $imageName,
            'public_uploads'
        );

        $data          = $request->only( [ 'name', 'video' ] );
        $data['image'] = $imageName;

        KcaeHeroSlide::create( $data );

        session()->flash( 'success', 'Hero slide added successfully' );

        return Redirect::route( 'admin.kcae.hero-slides.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param KcaeHeroSlide $hero_slide
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show( KcaeHeroSlide $hero_slide )
    {
        return Redirect::route( 'admin.kcae.hero-slides.index' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param KcaeHeroSlide $hero_slide
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit( KcaeHeroSlide $hero_slide )
    {
        return view( 'admin.kcae.hero-slides.edit', [
            'slide' => $hero_slide
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param KCAEHeroSlideUpdateRequest $request
     * @param KcaeHeroSlide $hero_slide
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( KCAEHeroSlideUpdateRequest $request, KcaeHeroSlide $hero_slide )
    {
        $hero_slide->fill( $request->only( [ 'name', 'video' ] ) );

        if ( $request->hasFile( 'image' ) ) {
            $image     = $request->file( 'image' );
            $imageName = Str::slug( $request->get( 'name' ) ) . '_'
                         . time() . '.' . $image->extension();
            $image->storeAs(
                KcaeHeroSlide::IMAGE_DIRECTORY,
                $imageName,
                'public_uploads'
            );

            $hero_slide->image = $imageName;
        }

        if ( $hero_slide->isDirty() ) {
            $hero_slide->save();
        }

        session()->flash( 'success', 'Hero slide updated successfully' );

        return Redirect::route( 'admin.kcae.hero-slides.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param KcaeHeroSlide $hero_slide
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy( KcaeHeroSlide $hero_slide )
    {
        optional( $hero_slide )->delete();

        session()->flash( 'success', 'Hero slide deleted successfully' );

        return Redirect::route( 'admin.kcae.hero-slides.index' );
    }
}
