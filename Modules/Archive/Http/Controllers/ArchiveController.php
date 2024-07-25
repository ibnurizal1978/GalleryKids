<?php

namespace Modules\Archive\Http\Controllers;

use App\Models\KcaeSpace;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Archive\Entities\Archive;
use Auth;

class ArchiveController extends Controller
{
    /**
     * Add to archive. in profile section
     * @return Response
     */
    public function addToArchive( Request $request )
    {
        $request->validate( [

            'archive_type' => 'required|string|in:create,share,discover,exhibition,play,space',
            'archive_id'   => 'required|numeric'

        ] );

        $data = $request->all();

        $data['user_id']       = Auth::user()->id;
        $data['archivable_id'] = $data['archive_id'];

        switch ( $data['archive_type'] ) {
            case 'create':
                $data['archivable_type'] = 'Modules\Create\Entities\Create';
                break;
            case 'share':
                $data['archivable_type'] = 'Modules\Share\Entities\Share';
                break;
            case 'discover':
                $data['archivable_type'] = 'Modules\Discover\Entities\Discover';
                break;
            case 'exhibition':
                $data['archivable_type'] = 'Modules\Exhibition\Entities\Exhibition';
                break;
            case 'play':
                $data['archivable_type'] = 'Modules\Play\Entities\Play';
                break;
            case 'admin_share':
                $data['archivable_type'] = 'Modules\AdminShare\Entities\AdminShare';
                break;
            case 'space':
                $data['archivable_type'] = KcaeSpace::class;
                break;
        }

        try {

            Archive::create( $data );

            return response( [ 'status' => 'success', 'message' => 'Archived successfully' ] );

        } catch ( \Exception $e ) {

            return response( [ 'status' => 'error', 'message' => 'You had already reacted for this' ] );
        }


    }
}
