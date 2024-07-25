<?php

namespace App\Http\Controllers;

use App\Models\MembersonProfile;

class MembersonProfileListAdminController extends Controller
{
    public function index()
    {
        if ( ! config( 'app.show_memberson_on_admin' ) ) {
            return redirect()->intended( '/admin/dashboard' );
        }

        $data = MembersonProfile::get();

        return view( 'admin.memberson-profile.index', [
            'profiles' => $data
        ] );
    }
}
