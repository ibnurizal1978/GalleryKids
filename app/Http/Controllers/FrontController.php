<?php

namespace App\Http\Controllers;

use App\KcaeHeroSlide;
use App\Models\KcaeContent;
use App\Models\KcaeSpacesCategory;
use Illuminate\Http\Request;
use Modules\Setting\Entities\Tab;
use Modules\Create\Entities\Create;
use Modules\Event\Entities\Event;
use Modules\Play\Entities\Play;
use Modules\Share\Entities\Share;
use Modules\Discover\Entities\Discover;
use Modules\Exhibition\Entities\Exhibition;
use Auth;
use Modules\Points\Entities\PointManage;
use Modules\Points\Entities\Points;
use Modules\AdminShare\Entities\AdminShare;
use Modules\Category\Entities\Category;
use Modules\Setting\Entities\Setting;
use Artisan;
use \Cache;

class FrontController extends Controller
{

    /**
     * Displays all menu tabs.
     *
     * @return \Illuminate\Http\Response
     */

    /* Updated on 11-12-20
       What's updated -> enabled categories only in share only using scope enable
    */

    public function tab( $tab, Request $request )
    {

        $tab      = Tab::where( 'slug', $tab )->first();
        $search   = $request['search'];
        $sort     = $request['sort'];
        $category = $request['category'];

        //disabled cateegories
        $disabled_categories = Category::where( 'status', 0 )->pluck( 'id' )->toArray();


        if ( $category ) {
            $cat = Category::find( $category );
            if ( $cat && ! $cat->status ) {
                return redirect( '/' );
            }

            if ( $sort ) {
                $sort = $request['sort'];
            } else {
                $sort = 'AtoZ';
            }
        } else {
            $sort = $request['sort'];
        }


        $type = $request['sort'];
        $data = $request->all();

        if ( $tab ) {
            if ( Auth::check() ) {
                if ( Auth::user()->isStudent() ) {
                    switch ( $tab->name ) {
                        case 'create':
                            $events = Event::enable()->orderBy( 'id', 'DESC' )->get();
                            if ( isset( $data['category_id'] ) ) {
                                $creates = Create::enable()
//                                                 ->agegroup()
                                                 ->valid()
                                                 ->with( [ 'thumbnails' ] )
                                                 ->where( 'category_id', $data['category_id'] )
                                                 ->orderBy( 'id', 'DESC' )
                                                 ->get()
                                                 ->groupBy( 'category_id' );
                            } else {
                                $creates = Create::enable()
//                                                 ->agegroup()
                                                 ->valid()
                                                 ->with( [ 'thumbnails' ] )
                                                 ->orderBy( 'id', 'DESC' )
                                                 ->get()
                                                 ->groupBy( 'category_id' );
                            }

                            return view( 'create::front.index', compact( 'creates', 'events', 'data' ) );
                            break;
                        case 'share':
                            if ( $sort ) {
                                if ( $sort == 'AtoZ' ) {
                                    $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category ) {
                                        if ( ! is_null( $category ) ) {
                                            $query->where( 'category_id', $category );
                                        }

                                    } )->orderBy( 'ARTIST', 'ASC' )->enable()->get();
                                } else if ( $sort == 'ZtoA' ) {
                                    $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                        if ( $category ) {
                                            $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                        } else {
                                            $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                        }

                                    } )->orderBy( 'ARTIST', 'DESC' )->enable()->get();
                                } else if ( $sort == 'Old' ) {
                                    $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                        if ( $category ) {
                                            $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                        } else {
                                            $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                        }

                                    } )->orderBy( 'created_at', 'ASC' )->enable()->get();
                                } else if ( $sort == 'New' ) {
                                    $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                        if ( $category ) {
                                            $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                        } else {
                                            $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                        }

                                    } )->orderBy( 'created_at', 'DESC' )->enable()->get();
                                } else {
                                    $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                        if ( $category ) {
                                            $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                        } else {
                                            $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                        }

                                    } )->enable()->get();
                                }
                            } else {
                                $admin_shares = AdminShare::enable()->where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $disabled_categories ) {
                                    $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                } )->orderBy( 'id', 'DESC' )->get();
                            }

                            if ( $sort ) {
                                if ( $sort == 'AtoZ' ) {
                                    $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'name', 'ASC' )->enable()->get();
                                } else if ( $sort == 'ZtoA' ) {
                                    $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'name', 'DESC' )->enable()->get();
                                } else if ( $sort == 'Old' ) {
                                    $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'created_at', 'ASC' )->enable()->get();
                                } else if ( $sort == 'New' ) {
                                    $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'created_at', 'DESC' )->enable()->get();
                                } else {
                                    $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->enable()->get();
                                }
                            } else {
                                $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->enable()->orderBy( 'id', 'DESC' )->get();
                            }
                            $categories = Category::enable()->whereType( 'pictionShare' )->get();

                            return view( 'share::front.index', compact( 'admin_shares', 'my_shares', 'categories' ) );
                            break;
                        case 'discover':
                            if ( isset( $data['category_id'] ) ) {
                                $discovers = Discover::enable()
//                                                     ->agegroup()
                                                     ->valid()
                                                     ->with( [ 'category' ] )
                                                     ->where( 'category_id', $data['category_id'] )
                                                     ->orderBy( 'id', 'DESC' )
                                                     ->get()
                                                     ->groupBy( 'category_id' );
                            } else {
                                $discovers = Discover::enable()
//                                                     ->agegroup()
                                                     ->valid()
                                                     ->orderBy( 'id', 'DESC' )
                                                     ->get()
                                                     ->groupBy( 'category_id' );
                            }

                            return view( 'discover::front.index', compact( 'discovers', 'data' ) );
                            break;
                        case 'play':
                            $plays = Play::enable()
//                                         ->agegroup()
                                         ->orderBy( 'id', 'DESC' )
                                         ->get();

                            return view( 'play::front.index', compact( 'plays' ) );
                            break;
                        case 'special_exhibition':
                            $setting = Setting::first();
                            if ( isset( $data['category_id'] ) ) {
                                $exhibitions = Exhibition::enable()
//                                                         ->agegroup()
                                                         ->valid()
                                                         ->with( [ 'thumbnails' ] )
                                                         ->where( 'category_id', $data['category_id'] )
                                                         ->orderBy( 'id', 'DESC' )
                                                         ->get()
                                                         ->groupBy( 'category_id' );
                            } else {
                                $exhibitions = Exhibition::enable()
//                                                         ->agegroup()
                                                         ->valid()
                                                         ->orderBy( 'id', 'DESC' )
                                                         ->take( 3 )
                                                         ->get()
                                                         ->groupBy( 'category_id' );
                            }

                            return view( 'exhibition::front.index', compact( 'exhibitions', 'data', 'setting' ) );
                            break;
                    }
                } else {
                    switch ( $tab->name ) {
                        case 'create':
                            $events = Event::enable()->orderBy( 'id', 'DESC' )->get();
                            if ( isset( $data['category_id'] ) ) {
                                $creates = Create::enable()->valid()->with( [ 'thumbnails' ] )->where( 'category_id', $data['category_id'] )->orderBy( 'id', 'DESC' )->get()->groupBy( 'category_id' );
                            } else {
                                $creates = Create::enable()->valid()->with( [ 'thumbnails' ] )->orderBy( 'id', 'DESC' )->get()->groupBy( 'category_id' );
                            }

                            return view( 'create::front.index', compact( 'creates', 'events', 'data' ) );
                            break;
                        case 'share':
                            if ( $sort ) {
                                if ( $sort == 'AtoZ' ) {
                                    $admin_shares = AdminShare::enable()->where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                        if ( $category ) {
                                            $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                        } else {
                                            $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                        }

                                    } )->orderBy( 'ARTIST', 'ASC' )->get();
                                } else if ( $sort == 'ZtoA' ) {
                                    $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                        if ( $category ) {
                                            $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                        } else {
                                            $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                        }

                                    } )->orderBy( 'ARTIST', 'DESC' )->enable()->get();
                                } else if ( $sort == 'Old' ) {
                                    $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                        if ( $category ) {
                                            $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                        } else {
                                            $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                        }

                                    } )->orderBy( 'created_at', 'ASC' )->enable()->get();
                                } else if ( $sort == 'New' ) {
                                    $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                        if ( $category ) {
                                            $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                        } else {
                                            $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                        }

                                    } )->orderBy( 'created_at', 'DESC' )->enable()->get();
                                } else {
                                    $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                        if ( $category ) {
                                            $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                        } else {
                                            $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                        }

                                    } )->enable()->get();
                                }
                            } else {
                                $admin_shares = AdminShare::enable()->where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $disabled_categories ) {
                                    $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                } )->orderBy( 'id', 'DESC' )->get();
                            }
                            if ( isset( $data['category_id'] ) ) {
                                $my_shares = Share::enable()->orderBy( 'id', 'DESC' )->where( 'category_id', $data['category_id'] )->get();
                            } else if ( $sort ) {
                                if ( $sort == 'AtoZ' ) {
                                    $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'name', 'ASC' )->enable()->get();
                                } else if ( $sort == 'ZtoA' ) {
                                    $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'name', 'DESC' )->enable()->get();
                                } else if ( $sort == 'Old' ) {
                                    $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'created_at', 'ASC' )->enable()->get();
                                } else if ( $sort == 'New' ) {
                                    $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'created_at', 'DESC' )->enable()->get();
                                } else {
                                    $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->enable()->get();
                                }
                            } else {
                                $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->enable()->orderBy( 'id', 'DESC' )->get();
                            }
                            $categories = Category::enable()->whereType( 'pictionShare' )->get();

                            return view( 'share::front.index', compact( 'admin_shares', 'my_shares', 'data', 'categories' ) );
                            break;
                        case 'discover':
                            if ( isset( $data['category_id'] ) ) {
                                $discovers = Discover::enable()->valid()->with( [ 'category' ] )->where( 'category_id', $data['category_id'] )->orderBy( 'id', 'DESC' )->get()->groupBy( 'category_id' );
                            } else {
                                $discovers = Discover::enable()->valid()->with( [ 'category' ] )->orderBy( 'id', 'DESC' )->get()->groupBy( 'category_id' );
                            }

                            return view( 'discover::front.index', compact( 'discovers', 'data' ) );
                            break;
                        case 'play':
                            if ( isset( $data['category_id'] ) ) {
                                $plays = Play::enable()->where( 'category_id', $data['category_id'] )->orderBy( 'id', 'DESC' )->get();
                            } else {
                                $plays = Play::enable()->orderBy( 'id', 'DESC' )->get();
                            }

                            return view( 'play::front.index', compact( 'plays', 'data' ) );
                            break;
                        case 'special_exhibition':
                            $setting = Setting::first();
                            if ( isset( $data['category_id'] ) ) {
                                $exhibitions = Exhibition::enable()->valid()->with( [ 'thumbnails' ] )->where( 'category_id', $data['category_id'] )->orderBy( 'id', 'DESC' )->get()->groupBy( 'category_id' );
                            } else {
                                $exhibitions = Exhibition::enable()->valid()->with( [ 'thumbnails' ] )->orderBy( 'id', 'DESC' )->take( 3 )->get()->groupBy( 'category_id' );
                            }

                            return view( 'exhibition::front.index', compact( 'exhibitions', 'data', 'setting' ) );
                            break;
                    }
                }
            } else {
                switch ( $tab->name ) {
                    case 'create':
                        $events = Event::enable()->orderBy( 'id', 'DESC' )->get();
                        if ( isset( $data['category_id'] ) ) {
                            $creates = Create::enable()->valid()->nonmembers()->with( [ 'thumbnails' ] )->where( 'category_id', $data['category_id'] )->orderBy( 'id', 'DESC' )->get()->groupBy( 'category_id' );
                        } else {
                            $creates = Create::enable()->valid()->nonmembers()->with( [ 'thumbnails' ] )->orderBy( 'id', 'DESC' )->get()->groupBy( 'category_id' );
                        }

                        return view( 'create::front.index', compact( 'creates', 'events', 'data' ) );
                        break;
                    case 'share':
                        if ( $sort ) {
                            if ( $sort == 'AtoZ' ) {
                                $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category ) {
                                    if ( ! is_null( $category ) ) {
                                        $query->where( 'category_id', $category );
                                    }

                                } )->orderBy( 'ARTIST', 'ASC' )->enable()->get();
                            } else if ( $sort == 'ZtoA' ) {
                                $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                    if ( $category ) {
                                        $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                    } else {
                                        $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                    }

                                } )->orderBy( 'ARTIST', 'DESC' )->enable()->get();
                            } else if ( $sort == 'Old' ) {
                                $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                    if ( $category ) {
                                        $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                    } else {
                                        $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                    }

                                } )->orderBy( 'created_at', 'ASC' )->enable()->get();
                            } else if ( $sort == 'New' ) {
                                $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                    if ( $category ) {
                                        $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                    } else {
                                        $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                    }

                                } )->orderBy( 'created_at', 'DESC' )->enable()->get();
                            } else {
                                $admin_shares = AdminShare::where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $category, $disabled_categories ) {

                                    if ( $category ) {
                                        $query->where( 'category_id', $category )->whereNotIn( 'category_id', $disabled_categories );
                                    } else {
                                        $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                                    }

                                } )->enable()->get();
                            }
                        } else {
                            $admin_shares = AdminShare::enable()->where( 'title', 'LIKE', '%' . $search . "%" )->where( function ( $query ) use ( $disabled_categories ) {
                                $query->whereNotIn( 'category_id', $disabled_categories )->orWhereNull( 'category_id' );
                            } )->orderBy( 'id', 'DESC' )->get();
                        }
//                        $my_shares = [];
                        if ( $sort ) {
                            if ( $sort == 'AtoZ' ) {
                                $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'name', 'ASC' )->enable()->get();
                            } else if ( $sort == 'ZtoA' ) {
                                $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'name', 'DESC' )->enable()->get();
                            } else if ( $sort == 'Old' ) {
                                $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'created_at', 'ASC' )->enable()->get();
                            } else if ( $sort == 'New' ) {
                                $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->orderBy( 'created_at', 'DESC' )->enable()->get();
                            } else {
                                $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->enable()->get();
                            }
                        } else {
                            $my_shares = Share::where( 'name', 'LIKE', '%' . $search . "%" )->orWhere( 'description', 'LIKE', '%' . $search . "%" )->enable()->orderBy( 'id', 'DESC' )->get();
                        }

                        $categories = Category::enable()->whereType( 'pictionShare' )->get();

//                        dd($admin_shares);

                        return view( 'share::front.index', compact( 'admin_shares', 'my_shares', 'categories' ) );
                        break;
                    case 'discover':
                        if ( isset( $data['category_id'] ) ) {
                            $discovers = Discover::enable()->valid()->nonmembers()->with( [ 'category' ] )->where( 'category_id', $data['category_id'] )->orderBy( 'id', 'DESC' )->get()->groupBy( 'category_id' );
                        } else {
                            $discovers = Discover::enable()->valid()->nonmembers()->with( [ 'category' ] )->orderBy( 'id', 'DESC' )->get()->groupBy( 'category_id' );
                        }

                        return view( 'discover::front.index', compact( 'discovers', 'data' ) );
                        break;
                    case 'play':
                        if ( isset( $data['category_id'] ) ) {
                            $plays = Play::enable()->orderBy( 'id', 'DESC' )->get();
                        } else {
                            $plays = Play::enable()->orderBy( 'id', 'DESC' )->get();
                        }

                        return view( 'play::front.index', compact( 'plays', 'data' ) );
                        break;
                    case 'special_exhibition':
                        $setting = Setting::first();
                        if ( isset( $data['category_id'] ) ) {
                            $exhibitions = Exhibition::enable()->valid()->nonmembers()->with( [ 'thumbnails' ] )->where( 'category_id', $data['category_id'] )->orderBy( 'id', 'DESC' )->get()->groupBy( 'category_id' );
                        } else {
                            $exhibitions = Exhibition::enable()->valid()->nonmembers()->with( [ 'thumbnails' ] )->orderBy( 'id', 'DESC' )->get()->groupBy( 'category_id' );
                        }

                        return view( 'exhibition::front.index', compact( 'exhibitions', 'data', 'setting' ) );
                        break;
                }
            }
        } else {
            return redirect( '/' );
        }
    }

//    public function tab($tab, Request $request) {
//
//        $tab = Tab::where('slug', $tab)->first();
//        $search = $request['search'];
//        $sort = $request['sort'];
//        if($sort){
//          $sort = $request['sort'];
//        }else{
//           $sort = 'AtoZ';
//        }
//        $category = $request['category'];
//        $type = $request['sort'];
//        $data = $request->all();
//        $cacheTime = 60;
//        if ($tab) {
//            if (Auth::check()) {
//                if (Auth::user()->isStudent()) {
//                    switch ($tab->name) {
//                        case 'create':
//                            $events = Event::enable()->orderBy('id', 'DESC')->get();
//                            if (isset($data['category_id']))
//                                $creates = Create::enable()->agegroup()->valid()->with(['thumbnails'])->where('category_id', $data['category_id'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                            else
//                                $creates = Create::enable()->agegroup()->valid()->with(['thumbnails'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//
//                            return view('create::front.index', compact('creates', 'events', 'data'));
//                            break;
//                        case 'share':
//                            if ($sort) {
//                                if ($sort == 'AtoZ') {
//                                    $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category) {
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'ASC')->enable()->get();
//                                    });
//                                  //  $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'ASC')->enable()->get();
//                                } else if ($sort == 'ZtoA') {
//                                    $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'DESC')->enable()->get();
//                                    });
//                                   // $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'DESC')->enable()->get();
//                                } else if ($sort == 'Old') {
//                                    $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'ASC')->enable()->get();
//                                    });
//                                   // $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'ASC')->enable()->get();
//                                } else if ($sort == 'New') {
//                                     $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'DESC')->enable()->get();
//                                    });
//                                    //$admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'DESC')->enable()->get();
//                                } else {
//                                    $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->enable()->get();
//                                    });
//                                   // $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->enable()->get();
//                                }
//                            } else {
//                                $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->enable()->orderBy('id', 'DESC')->get();
//                                    });
//                               // $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->enable()->orderBy('id', 'DESC')->get();
//                            }
//
//                            if ($sort) {
//                                if ($sort == 'AtoZ') {
//                                    $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('name', 'ASC')->enable()->get();
//                                } else if ($sort == 'ZtoA') {
//                                    $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('name', 'DESC')->enable()->get();
//                                } else if ($sort == 'Old') {
//                                    $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('created_at', 'ASC')->enable()->get();
//                                } else if ($sort == 'New') {
//                                    $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('created_at', 'DESC')->enable()->get();
//                                } else {
//                                    $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->enable()->get();
//                                }
//                            } else {
//                                $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->enable()->orderBy('id', 'DESC')->get();
//                            }
//                            $categories = Category::whereType('pictionShare')->get();
//                            return view('share::front.index', compact('admin_shares', 'my_shares', 'categories'));
//                            break;
//                        case 'discover':
//                            if (isset($data['category_id']))
//                                $discovers = Discover::enable()->agegroup()->valid()->with(['category'])->where('category_id', $data['category_id'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                            else
//                                $discovers = Discover::enable()->agegroup()->valid()->orderBy('id', 'DESC')->get()->groupBy('category_id');
//
//                            return view('discover::front.index', compact('discovers', 'data'));
//                            break;
//                        case 'play':
//                            $plays = Play::enable()->agegroup()->orderBy('id', 'DESC')->get();
//                            return view('play::front.index', compact('plays'));
//                            break;
//                        case 'special_exhibition':
//                            $setting = Setting::first();
//                            if (isset($data['category_id']))
//                                $exhibitions = Exhibition::enable()->agegroup()->valid()->with(['thumbnails'])->where('category_id', $data['category_id'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                            else
//                                $exhibitions = Exhibition::enable()->agegroup()->valid()->orderBy('id', 'DESC')->take(3)->get()->groupBy('category_id');
//
//                            return view('exhibition::front.index', compact('exhibitions', 'data', 'setting'));
//                            break;
//                    }
//                }
//                else {
//                    switch ($tab->name) {
//                        case 'create':
//                            $events = Event::enable()->orderBy('id', 'DESC')->get();
//                            if (isset($data['category_id']))
//                                $creates = Create::enable()->valid()->with(['thumbnails'])->where('category_id', $data['category_id'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                            else
//                                $creates = Create::enable()->valid()->with(['thumbnails'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                            return view('create::front.index', compact('creates', 'events', 'data'));
//                            break;
//                        case 'share':
//                            if ($sort) {
//                                if ($sort == 'AtoZ') {
//                                      $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'ASC')->enable()->get();
//                                    });
//                                    //$admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'ASC')->enable()->get();
//                                } else if ($sort == 'ZtoA') {
//                                    $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'DESC')->enable()->get();
//                                    });
//                                   // $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'DESC')->enable()->get();
//                                } else if ($sort == 'Old') {
//                                    $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'ASC')->enable()->get();
//                                    });
//                                    //$admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'ASC')->enable()->get();
//                                } else if ($sort == 'New') {
//                                    $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'DESC')->enable()->get();
//                                    });
//                                   // $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'DESC')->enable()->get();
//                                } else {
//                                     $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->enable()->get();
//                                    });
//                                  //  $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->enable()->get();
//                                }
//                            } else {
//                                $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->enable()->orderBy('id', 'DESC')->get();
//                                    });
//                               // $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->enable()->orderBy('id', 'DESC')->get();
//                            }
//                            if (isset($data['category_id']))
//                                $my_shares = Share::enable()->orderBy('id', 'DESC')->where('category_id', $data['category_id'])->get();
//                            else
//                            if ($sort) {
//                                if ($sort == 'AtoZ') {
//                                    $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('name', 'ASC')->enable()->get();
//                                } else if ($sort == 'ZtoA') {
//                                    $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('name', 'DESC')->enable()->get();
//                                } else if ($sort == 'Old') {
//                                    $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('created_at', 'ASC')->enable()->get();
//                                } else if ($sort == 'New') {
//                                    $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('created_at', 'DESC')->enable()->get();
//                                } else {
//                                    $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->enable()->get();
//                                }
//                            } else {
//                                $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->enable()->orderBy('id', 'DESC')->get();
//                            }
//                            $categories = Category::whereType('pictionShare')->get();
//                            return view('share::front.index', compact('admin_shares', 'my_shares', 'data', 'categories'));
//                            break;
//                        case 'discover':
//                            if (isset($data['category_id']))
//                                $discovers = Discover::enable()->valid()->with(['category'])->where('category_id', $data['category_id'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                            else
//                                $discovers = Discover::enable()->valid()->with(['category'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                            return view('discover::front.index', compact('discovers', 'data'));
//                            break;
//                        case 'play':
//                            if (isset($data['category_id']))
//                                $plays = Play::enable()->where('category_id', $data['category_id'])->orderBy('id', 'DESC')->get();
//                            else
//                                $plays = Play::enable()->orderBy('id', 'DESC')->get();
//                            return view('play::front.index', compact('plays', 'data'));
//                            break;
//                        case 'special_exhibition':
//                            $setting = Setting::first();
//                            if (isset($data['category_id']))
//                                $exhibitions = Exhibition::enable()->valid()->with(['thumbnails'])->where('category_id', $data['category_id'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                            else
//                                $exhibitions = Exhibition::enable()->valid()->with(['thumbnails'])->orderBy('id', 'DESC')->take(3)->get()->groupBy('category_id');
//                            return view('exhibition::front.index', compact('exhibitions', 'data', 'setting'));
//                            break;
//                    }
//                }
//            } else {
//                switch ($tab->name) {
//                    case 'create':
//                        $events = Event::enable()->orderBy('id', 'DESC')->get();
//                        if (isset($data['category_id']))
//                            $creates = Create::enable()->valid()->nonmembers()->with(['thumbnails'])->where('category_id', $data['category_id'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                        else
//                            $creates = Create::enable()->valid()->nonmembers()->with(['thumbnails'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                        return view('create::front.index', compact('creates', 'events', 'data'));
//                        break;
//                    case 'share':
//                        if ($sort) {
//
//                            if ($sort == 'AtoZ') {
//                                $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                            return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'ASC')->enable()->get();
//                                        });
//                                // $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'ASC')->enable()->get();
//                            } else if ($sort == 'ZtoA') {
//                                $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                            return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'DESC')->enable()->get();
//                                        });
//                                // $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('ARTIST', 'DESC')->enable()->get();
//                            } else if ($sort == 'Old') {
//                                $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                            return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'ASC')->enable()->get();
//                                        });
//                                //$admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'ASC')->enable()->get();
//                            } else if ($sort == 'New') {
//                                $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                            return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'DESC')->enable()->get();
//                                        });
//                                // $admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->orderBy('created_at', 'DESC')->enable()->get();
//                            } else {
//                                $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category){
//                                            return AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->enable()->get();
//                                        });
//                                //$admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->where('category_id', $category)->enable()->get();
//                            }
//                        } else {
//                            //$admin_shares = AdminShare::where('title', 'LIKE', '%' . $search . "%")->enable()->orderBy('id', 'DESC')->get();
//
//                            $admin_shares = Cache::remember('admin_shares', $cacheTime, function() use($search,$category) {
//                                        return AdminShare::where('title', 'LIKE', '%' . $search . "%")->enable()->orderBy('id', 'DESC')->get();
//                                    });
//                        }
////                        $my_shares = [];
//                        if ($sort) {
//                            if ($sort == 'AtoZ') {
//                                $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('name', 'ASC')->enable()->get();
//                            } else if ($sort == 'ZtoA') {
//                                $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('name', 'DESC')->enable()->get();
//                            } else if ($sort == 'Old') {
//                                $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('created_at', 'ASC')->enable()->get();
//                            } else if ($sort == 'New') {
//                                $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->orderBy('created_at', 'DESC')->enable()->get();
//                            } else {
//                                $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->enable()->get();
//                            }
//                        } else {
//                            $my_shares = Share::where('name', 'LIKE', '%' . $search . "%")->orWhere('description', 'LIKE', '%' . $search . "%")->enable()->orderBy('id', 'DESC')->get();
//                        }
//
//                        $categories = Category::whereType('pictionShare')->get();
//                        return view('share::front.index', compact('admin_shares', 'my_shares', 'categories'));
//                        break;
//                    case 'discover':
//                        if (isset($data['category_id']))
//                            $discovers = Discover::enable()->valid()->nonmembers()->with(['category'])->where('category_id', $data['category_id'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                        else
//                            $discovers = Discover::enable()->valid()->nonmembers()->with(['category'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                        return view('discover::front.index', compact('discovers', 'data'));
//                        break;
//                    case 'play':
//                        if (isset($data['category_id']))
//                            $plays = Play::enable()->orderBy('id', 'DESC')->get();
//                        else
//                            $plays = Play::enable()->orderBy('id', 'DESC')->get();
//                        return view('play::front.index', compact('plays', 'data'));
//                        break;
//                    case 'special_exhibition':
//                        $setting = Setting::first();
//                        if (isset($data['category_id']))
//                            $exhibitions = Exhibition::enable()->valid()->nonmembers()->with(['thumbnails'])->where('category_id', $data['category_id'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                        else
//                            $exhibitions = Exhibition::enable()->valid()->nonmembers()->with(['thumbnails'])->orderBy('id', 'DESC')->get()->groupBy('category_id');
//                        return view('exhibition::front.index', compact('exhibitions', 'data', 'setting'));
//                        break;
//                }
//            }
//        } else {
//            return redirect('/');
//        }
//    }

    /**
     * add post share points.
     *
     * @return \Illuminate\Http\Response
     */
//    public function sharePoints(Request $request) {
//        $type = $request['type'];
//        $id = $request['id'];
//        $point = Points::find(2);
//        $bonusPoint = Points::find(2);
//        $date = \Carbon\Carbon::today();
//
//        $pointsManage = PointManage::where('date', $date)->wherePostId($id)->whereType($type)->whereUserId(Auth::user()['id'])->first();
//        if (!$pointsManage) {
//            $parent = new PointManage();
//            $dataParent = $request->only(['user_id', 'post_id', 'type', 'points', 'date', 'time']);
//            $dataParent['user_id'] = Auth::user()['id'];
//            $dataParent['type'] = $type;
//            $dataParent['post_id'] = $id;
//            $dataParent['date'] = \Carbon\Carbon::today();
//            $dataParent['time'] = 1;
//            $dataParent['points'] = $point['value'];
//            $parent = $parent->create($dataParent);
//
//            $firstDayofPreviousMonth = \Carbon\Carbon::now()->startOfMonth()->toDateString();
//            $lastDayofPreviousMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();
//            $check = PointManage::whereUserId(Auth::user()['id'])->whereType($type . 'Share3Times')->whereBetween('created_at', [$firstDayofPreviousMonth, $lastDayofPreviousMonth])->get()->groupBy(function($booking) {
//
//            });
//            if ($check == '[]') {
//                $booking_groups = PointManage::whereUserId(Auth::user()['id'])->whereType($type)->whereBetween('created_at', [$firstDayofPreviousMonth, $lastDayofPreviousMonth])->get()->groupBy(function($booking) {
//                    return \Carbon\Carbon::parse($booking->created_at)->format('W');
//                });
//
//
//                $groupCount = $booking_groups->map(function ($item, $key) {
//                    return collect($item)->count();
//                });
//                $dt = '';
////       $booking_groups =  Question::whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()])->get();
//                foreach ($groupCount as $count)
//                    if ($count >= 3) {
//                        $dt = true;
//                    } else {
//                        $dt = false;
//                    }
//                if ($dt == 'true') {
//                    $parent = new PointManage();
//                    $dataParent = $request->only(['user_id', 'post_id', 'type', 'points', 'date', 'time']);
//                    $dataParent['user_id'] = Auth::user()['id'];
//                    $dataParent['type'] = $type . 'Share3Times';
//                    $dataParent['post_id'] = $id;
//                    $dataParent['date'] = \Carbon\Carbon::today();
//                    $dataParent['time'] = 1;
//                    $dataParent['points'] = $bonusPoint['value'];
//                    $parent = $parent->create($dataParent);
//                }
//            }
//        }
//        $response = ['message' => 'success'];
//        return response($response, 200);
//    }

    /**
     * display particular share page load.
     *
     * @return \Illuminate\Http\Response
     */
    public function singleShare( $id )
    {
        try {
            $share = Share::whereStatus( 'Enable' )->find( $id );
            if ( $share ) {
                return view( 'share::front.show', compact( 'share' ) );
            } else {
                return redirect( '/share' );
            }
        } catch ( \Exception $e ) {
            return redirect( '/share' );
        }
    }

    /**
     * display keppel Centre page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function keppelCentre()
    {

        return view( 'keppelCentre', [
            'pageContent' => KcaeContent::first(),
            'slides'      => KcaeHeroSlide::all(),
            'spaces'      => KcaeSpacesCategory::where( 'status', 'enabled' )
                                               ->with( 'spaces.slides' )
                                               ->orderBy( 'serial' )
                                               ->get(),
        ] );
    }

}
