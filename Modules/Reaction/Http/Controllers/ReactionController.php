<?php

namespace Modules\Reaction\Http\Controllers;

use App\Models\KcaeSpace;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Reaction\Entities\Reaction;
use Auth;
use Modules\Points\Entities\PointManage;
use Modules\Points\Entities\Points;

class ReactionController extends Controller
{

    /**
     * Add Reaction of a user and delete Reaction.
     * @return Response
     */
    public function addReaction( Request $request )
    {
        $request->validate( [

            'reaction_type' => 'required|string|in:create,share,discover,play,exhibition,admin_share,space',
            'reaction_id'   => 'required|numeric'
        ] );

        $data     = $request->all();
        $emoji    = json_encode( $request->reaction );
        $reaction = '';
        if ( $emoji == '"\ud83d\ude0e"' ) {
            $reaction = 'true';
        } elseif ( $emoji == '"\ud83e\udd2a"' ) {
            $reaction = 'true';
        } elseif ( $emoji == '"\ud83d\ude22"' ) {
            $reaction = 'true';
        } elseif ( $emoji == '"\ud83d\ude31"' ) {
            $reaction = 'true';
        } else {
            $reaction = 'false';
        }
        if ( $reaction == 'true' ) {
            $data['user_id']         = Auth::user()->id;
            $data['reactionable_id'] = $data['reaction_id'];

            switch ( $data['reaction_type'] ) {
                case 'space':
                    $data['reactionable_type'] = KcaeSpace::class;
                    break;
                case 'create':
                    $data['reactionable_type'] = 'Modules\Create\Entities\Create';
                    break;
                case 'share':
                    $data['reactionable_type'] = 'Modules\Share\Entities\Share';
                    break;
                case 'discover':
                    $data['reactionable_type'] = 'Modules\Discover\Entities\Discover';
                    break;
                case 'play':
                    $data['reactionable_type'] = 'Modules\Play\Entities\Play';
                    break;
                case 'exhibition':
                    $data['reactionable_type'] = 'Modules\Exhibition\Entities\Exhibition';
                    break;
                case 'admin_share':
                    $data['reactionable_type'] = 'Modules\AdminShare\Entities\AdminShare';
                    break;
            }


            try {

                Reaction::create( $data );

                return response( [ 'status' => 'success', 'message' => 'Reaction stored successfully' ] );
            } catch ( \Exception $e ) {
                return response( [ 'status' => 'error', 'message' => 'some thing wrong' ] );
            }
        } else {
            return response( [ 'status' => 'error', 'message' => 'reaction invalid' ] );
        }
    }

    /**
     * Add Reaction of a user.
     * @return Response
     */
    public function deleteReaction( Request $request )
    {
        $request->validate( [

            'reaction_id' => 'required|numeric'
        ] );

        try {

            Reaction::findOrFail( $request->reaction_id )->delete();

            return response( [ 'status' => 'success', 'message' => 'Reaction removed successfully' ] );
        } catch ( \Exception $e ) {

            return response( [ 'status'  => 'error',
                               'message' => 'You had already removed reacted for this',
                               'dev_msg' => $e->getMessage()
            ] );
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view( 'reaction::create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store( Request $request )
    {
        //
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show( $id )
    {
        return view( 'reaction::show' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit( $id )
    {
        return view( 'reaction::edit' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Response
     */
    public function update( Request $request, $id )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy( $id )
    {
        //
    }

}
