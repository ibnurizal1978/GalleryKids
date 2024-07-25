<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function search()
    {
        if ( ! config( 'app.delete_user_on_admin' ) ) {
            return redirect()->route( 'user.index', [ 'type' => 'guardian' ] );
        }

        $users = collect();

        if ( $keyword = request()->query( 'keyword' ) ) {
            $users = User::where( 'email', 'like', "%{$keyword}%" )
                         ->limit( 25 )
                         ->get();
        }

        return view( 'admin.users.search', compact( 'users' ) );
    }

    public function destroy( User $user )
    {
        if ( ! config( 'app.delete_user_on_admin' ) ) {
            return redirect()->route( 'user.index', [ 'type' => 'guardian' ] );
        }

        Schema::disableForeignKeyConstraints();

        $user->children()->delete();

        DB::table( 'relation_user' )
          ->where( 'parent_id', $user->id )
          ->delete();

        $user->delete();

        Schema::enableForeignKeyConstraints();

        session()->flash( 'success', 'User Deleted Successfully!' );

        return redirect()->route( 'admin.users.search' );
    }
}
