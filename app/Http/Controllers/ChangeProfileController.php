<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChildLoginRequest;
use App\Repositories\UserRepository;
use App\Services\Auth0\Manager;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Support\Facades\DB;

class ChangeProfileController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    public function __construct( UserRepository $repository )
    {
        $this->repository = $repository;
    }

    public function sendOtp()
    {
        $user = Auth::user();
        if ( $user->isStudent() ) {
            $user = $user->parents()
                         ->whereNotNull( 'email' )
                         ->first();
        }

        $sendOTP = $user && $user->email
            ? $this->repository->sendOtp( $user )
            : false;

        if ( ! $sendOTP ) {
            return response(
                [ 'message' => 'Couldn\'t sent OTP!' ],
                SymfonyResponse::HTTP_BAD_REQUEST
            );
        }

        return response( [ 'message' => 'OTP Sent Successfully!' ] );
    }

    public function childLogin( ChildLoginRequest $request )
    {
        $parent = Auth::user();

//        $verified = $this
//            ->repository
//            ->verifyOtp(
//                $request->password,
//                $parent
//            );

//        if ( ! $verified ) {
//            return response( [
//                'message' => 'Invalid or Expired OTP'
//            ], SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY );
//        }

//        $child = User::find( $request->id );
        $children = $parent->children;
        $child    = $children->firstWhere( 'id', $request->id );

        if ( ! $child ) {
            return response( [
                'message' => 'Child not found!'
            ], SymfonyResponse::HTTP_NOT_FOUND );
        }

        Auth::logout();
        Auth::login( $child );

        $child['visit'] += 1;
        $child['date']  = Carbon::now();
        $child->save();

        return response( [ 'message' => 'You are loggedin successfully' ] );
    }

    public function parentLogin( ChildLoginRequest $request )
    {
        $parent = User::whereId( $request->id )->first();


	 $data = DB::table('relation_user')
                ->where('child_id',Auth::user()->id)
                ->get();

	if($parent->id <> $data[0]->parent_id)
        {
                return response([
                                'message' => 'Invalid login request'
                ], SymfonyResponse::HTTP_UNAUTHORIZED);
        }


        if ( ! $parent ) {
            return response( [
                'message' => 'Invalid login request'
            ], SymfonyResponse::HTTP_UNAUTHORIZED );
        }

//        $verified = $this
//            ->repository
//            ->verifyOtp(
//                $request->password,
//                $parent
//            );
//
//        if ( ! $verified ) {
//            return response( [
//                'message' => 'Invalid or Expired OTP'
//            ], SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY );
//        }

        Auth::logout();
        Auth::login( $parent );
        $parent['visit'] += 1;
        $parent['date']  = Carbon::now();
        $parent->save();

        return response( [
            'message' => 'You are loggedin successfully'
        ] );
    }
}
