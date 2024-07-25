<?php

namespace Modules\User\Http\Controllers;

use App\Models\KcaeSpace;
use App\Services\Memberson\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Api;
use App\Http\Traits\DeleteFile;
use Modules\Share\Entities\Share;
use Modules\Setting\Entities\Tab;
use Modules\Avatar\Entities\Avatar;
use Modules\Reaction\Entities\Reaction;
use Modules\Archive\Entities\Archive;
use App\Role;
use App\User;
use Auth;
use Modules\Challenges\Entities\Challenges;
use Modules\Challenges\Entities\UserChallenge;
use Illuminate\Support\Facades\Hash;
use Session;
use Modules\Points\Entities\PointManage;
use Modules\Points\Entities\Points;
use Modules\User\Entities\ParentStudent;
use Modules\Question\Entities\Question;

class UserController extends Controller
{

    use FileUpload,
        DeleteFile,
        Api;


    /**
     * view load user profile
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function profile( Request $request )
    {

        $users     = User::get();
        $share     = $request['share'];
        $favourite = $request['favourite'];
        $user      = Auth::user();

        $tab = Tab::get( [ 'name', 'slug', 'display_name' ] )->toArray();

        if ( $favourite ) {
            if ( $favourite == 'AtoZ' ) {
                $reactions = Reaction::with( [ 'reactionable.archives_user' ] )->where( 'user_id', $user->id )->orderBy( 'created_at', 'DESC' )->get();
            } else if ( $favourite == 'ZtoA' ) {
                $reactions = Reaction::with( [ 'reactionable.archives_user' ] )->where( 'user_id', $user->id )->orderBy( 'created_at', 'ASC' )->get();
            } else if ( $favourite == 'Old' ) {
                $reactions = Reaction::with( [ 'reactionable.archives_user' ] )->where( 'user_id', $user->id )->orderBy( 'created_at', 'DESC' )->get();
            } else if ( $favourite == 'New' ) {
                $reactions = Reaction::with( [ 'reactionable.archives_user' ] )->where( 'user_id', $user->id )->orderBy( 'created_at', 'ASC' )->get();
            } else {
                $reactions = Reaction::with( [ 'reactionable.archives_user' ] )->where( 'user_id', $user->id )->get();
            }
        } else {
            $reactions = Reaction::with( [ 'reactionable.archives_user' ] )->where( 'user_id', $user->id )->get();
        }

        if ( $share ) {
            if ( $share == 'AtoZ' ) {
                $shares = Share::with( [
                    'reactions',
                    'archives_user'
                ] )->doesntHave( 'archives_user' )->where( 'user_id', $user->id )->orderBy( 'created_at', 'ASC' )->get();
            } else if ( $share == 'ZtoA' ) {
                $shares = Share::with( [
                    'reactions',
                    'archives_user'
                ] )->doesntHave( 'archives_user' )->where( 'user_id', $user->id )->orderBy( 'created_at', 'DESC' )->get();
            } else if ( $share == 'Old' ) {
                $shares = Share::with( [
                    'reactions',
                    'archives_user'
                ] )->doesntHave( 'archives_user' )->where( 'user_id', $user->id )->orderBy( 'created_at', 'ASC' )->get();
            } else if ( $share == 'New' ) {
                $shares = Share::with( [
                    'reactions',
                    'archives_user'
                ] )->doesntHave( 'archives_user' )->where( 'user_id', $user->id )->orderBy( 'created_at', 'DESC' )->get();
            } else if ( $share == 'like' ) {
                $shares = Share::with( [
                    'reactions',
                    'archives_user'
                ] )->doesntHave( 'archives_user' )->where( 'user_id', $user->id )->get();
            } else {
                $shares = Share::with( [
                    'reactions',
                    'archives_user'
                ] )->doesntHave( 'archives_user' )->where( 'user_id', $user->id )->get();
            }
        } else {
            $shares = Share::with( [
                'reactions',
                'archives_user'
            ] )->doesntHave( 'archives_user' )->where( 'user_id', $user->id )->get();
        }
        $avatars = Avatar::enable()->get();
        // dd($avatars);
        $archived_shares = Archive::with( [ 'archivable' ] )->where( 'archivable_type', 'Modules\Share\Entities\Share' )->where( 'user_id', $user->id )->get();

        $reactions_share_ids = Reaction::where( 'user_id', $user->id )->where( 'reactionable_type', 'Modules\Share\Entities\Share' )->pluck( 'reactionable_id' )->toArray();

        $reactions_create_ids = Reaction::where( 'user_id', $user->id )->where( 'reactionable_type', 'Modules\Create\Entities\Create' )->pluck( 'reactionable_id' )->toArray();

        $reactions_discover_ids = Reaction::where( 'user_id', $user->id )->where( 'reactionable_type', 'Modules\Discover\Entities\Discover' )->pluck( 'reactionable_id' )->toArray();

        $reactions_play_ids = Reaction::where( 'user_id', $user->id )->where( 'reactionable_type', 'Modules\Play\Entities\Play' )->pluck( 'reactionable_id' )->toArray();

        $archived_favourite_shares = Archive::with( [ 'archivable' ] )->where( 'archivable_type', 'Modules\Share\Entities\Share' )->where( 'user_id', $user->id )->whereIn( 'archivable_id', $reactions_share_ids )->get();
        $archived_favourite_spaces = Archive::with( [ 'archivable' ] )
                                            ->where( 'archivable_type', KcaeSpace::class )
                                            ->where( 'user_id', $user->id )
                                            ->get();

        $archived_favourite_creates = Archive::with( [ 'archivable' ] )->where( 'archivable_type', 'Modules\Create\Entities\Create' )->where( 'user_id', $user->id )->whereIn( 'archivable_id', $reactions_create_ids )->get();

        $archived_favourite_discovers = Archive::with( [ 'archivable' ] )->where( 'archivable_type', 'Modules\Discover\Entities\Discover' )->where( 'user_id', $user->id )->whereIn( 'archivable_id', $reactions_discover_ids )->get();

        $archived_favourite_plays = Archive::with( [ 'archivable' ] )->where( 'archivable_type', 'Modules\Play\Entities\Play' )->where( 'user_id', $user->id )->whereIn( 'archivable_id', $reactions_play_ids )->get();

        if ( Auth::user()->isStudent() ) {
            $challenges = Challenges::enable()->get();
            $user       = Auth::user();
            $parent     = '';
            foreach ( $user->parents as $parents ) {
                $parent = $parents->id;
            }
            $amout      = PointManage::whereUserId( Auth::user()['id'] )->orderBy( 'created_at', 'DESC' )->get()->sum( 'points' );
            $parentName = User::find( $parent );

            $points = $amout;

            if ( $points <= 500 ) {
                $current_level = intdiv( $points, 50 );
                $startLabel    = $current_level;
                $endLabel      = $current_level + 1;
                $points        = ( $points - ( $current_level * 50 ) );
            } elseif ( $points <= 2000 ) {
                $current_level = 10 + intdiv( ( $points - 500 ), 75 );
                $startLabel    = $current_level;
                $endLabel      = $current_level + 1;
                $points        = ( ( $points - 500 ) - ( $current_level - 10 ) * 75 );
            } elseif ( $points <= 3000 ) {
                $current_level = 30 + intdiv( ( $points - 2000 ), 100 );
                $startLabel    = $current_level;
                $endLabel      = $current_level + 1;
                $points        = ( ( $points - 2000 ) - ( $current_level - 30 ) * 100 );
            } elseif ( $points > 3000 ) {
                $current_level = 40 + intdiv( ( $points - 3000 ), 125 );
                $startLabel    = $current_level;
                $endLabel      = $current_level + 1;
                $points        = ( ( $points - 3000 ) - ( $current_level - 40 ) * 125 );
            }

//            future functionality disabled for now only
//            if ($startLabel != Auth::user()['currentLevel']) {
//                $lebel = User::findOrFail(Auth::user()['id']);
//                $lebel->currentLevel = $startLabel;
//                $lebel->save();
//                $email = $parentName['email'];
//                $childFirstName = Auth::user()['first_name'];
//                $childLastName = Auth::user()['last_name'];
//                $parentName = $parentName['first_name'] . ' ' . $parentName['last_name'];
//                $level = $startLabel;
//                $image = Auth::user()['image'];
//                ;
////                $data = ['data' => (object) ['parentName' => $parentName, 'image' => $image, 'level' => $level, 'childFirstName' => $childFirstName, 'childLastName' => $childLastName]];
////                //Level Up Mail
////                \Mail::send('levelupTemplate', $data, function ($m) use ($email) {
////                    $m->to($email)->subject('Level Up');
////                });
//            }

            return view( 'user::profileStudent', compact( 'user', 'amout', 'startLabel', 'endLabel', 'points', 'parent', 'shares', 'tab', 'avatars', 'reactions', 'archived_shares', 'archived_favourite_shares', 'archived_favourite_spaces', 'archived_favourite_creates', 'archived_favourite_discovers', 'archived_favourite_plays', 'challenges' ) );
        } else {

            try {
                $user      = Auth::user();
                $childrens = $user->children;

                $ids = [];
                foreach ( $childrens as $children ) {
                    $ids[] = $children['id'];
                }

                $membersonClient = new Client();
                $response        = $membersonClient->getProfileSummary();

                $member      = json_decode( $response->body() );
                $pointExpire = '';
                $point       = '';
            } catch ( \Exception $e ) {

                $message = $e->getMessage();

                return response( $message, 400 );
            }
        }

        $challenges = [];
        $user       = Auth::user();
        $childrens  = $user->children;

        return view( 'user::profile', compact( 'user', 'pointExpire', 'point', 'member', 'childrens', 'shares', 'tab', 'avatars', 'reactions', 'archived_shares', 'archived_favourite_shares', 'archived_favourite_creates', 'archived_favourite_discovers', 'archived_favourite_plays', 'challenges' ) );
    }

    /**
     * Gets the host.
     *
     * @param <type> $Address The address
     *
     * @return     <type>  The host.
     */
    public function getHost( $Address )
    {
        $parseUrl = parse_url( trim( $Address ) );

        return trim( isset( $parseUrl['host'] ) ? $parseUrl['host'] : array_shift( explode( '/', $parseUrl['path'], 2 ) ) );
    }

    /**
     * user profile update
     * @return Response
     */
    public function profileUpdate( Request $request )
    {
        $user    = Auth::user();
        $avatars = Avatar::enable()->get();
        if ( $request->has( 'profile' ) ) {
            $pathToUpload     = 'uploads/profile/';
            $file             = $request->file( 'profile' );
            $uploaded_profile = $this->uploadFile( $pathToUpload, $file, 100, 100 );
            if ( $user->image ) {
                $this->deleteFile( $user->image );
            }
            $user->update( [ 'image' => $uploaded_profile ] );

            return url( '/' ) . '/' . $uploaded_profile;
        } elseif ( $request->has( 'avatar' ) ) {
            if ( $this->getHost( $request->avatar ) != $request->getHttpHost() ) {
                return response( 'Unknown host', $status = 500 );
            }
            //Check if the request image is in avatar array or not
            if ( ! in_array( strstr( $request->avatar, 'uploads' ), $avatars->pluck( 'image' )->toArray() ) ) {
                return response( 'Unknown image', $status = 500 );
            }
            $str  = preg_replace( '#<script(.?)>(.?)</script>#is', '', $request['avatar'] );
            $l    = ( explode( ".", $str ) );
            $last = end( $l );
            if ( $last == 'jpg' ) {
                if ( strpos( $user->image, 'avatar' ) != false ) {
                    $this->deleteFile( $user->image );
                }
                $user->update( [ 'image' => preg_replace( '#<script(.?)>(.?)</script>#is', '', $request['avatar'] ) ] );

                return preg_replace( '#<script(.?)>(.?)</script>#is', '', $request['avatar'] );

                return preg_replace( '#<script(.?)>(.?)</script>#is', '', $request['avatar'] );
            } else if ( $last == 'jpeg' ) {
                if ( strpos( $user->image, 'avatar' ) != false ) {
                    $this->deleteFile( $user->image );
                }
                $user->update( [ 'image' => preg_replace( '#<script(.?)>(.?)</script>#is', '', $request['avatar'] ) ] );

                return preg_replace( '#<script(.?)>(.?)</script>#is', '', $request['avatar'] );
            } else if ( $last == 'png' ) {
                if ( strpos( $user->image, 'avatar' ) != false ) {
                    $this->deleteFile( $user->image );
                }
                $user->update( [ 'image' => preg_replace( '#<script(.?)>(.?)</script>#is', '', $request['avatar'] ) ] );

                return preg_replace( '#<script(.?)>(.?)</script>#is', '', $request['avatar'] );
            } else if ( $last == 'bmp' ) {
                if ( strpos( $user->image, 'avatar' ) != false ) {
                    $this->deleteFile( $user->image );
                }
                $user->update( [ 'image' => preg_replace( '#<script(.?)>(.?)</script>#is', '', $request['avatar'] ) ] );

                return preg_replace( '#<script(.?)>(.?)</script>#is', '', $request['avatar'] );
            } else {
                $response = [ 'message' => 'given data invalid' ];

                return response( $response, 500 );
            }
        }
    }

    /**
     * child login
     * @return Response
     */
    /**
     * parent login
     * @return Response
     */

    /**
     * children Add
     * @return Response
     */
    //    03-Dec-20 icNumber ,DOB format,Moblie Number ,Phone
    //    09-Dec-20 Change icNumber
    //    09-Dec-20 add one days for expire date
    public function childrenAdd( Request $request )
    {

        $email    = Auth::user()['email'];
        $password = \Session::get( 'password' );
        // $pass = rand(100000, 999999);
        // $icNumber = 'K00' . $pass;
        //            production api start here
//        $tokenUrl = "https://explorercms.nationalgallery.sg/app/api/ngstoken";
//        $loginUrl = "https://explorercms.nationalgallery.sg/api2/user/login";
//        $svcTokenUrl = "https://ngssgproxy.memgate.com/api/user/authenticate";
//        $getMember = "https://ngssgproxy.memgate.com/api/profile";
//        $upgradeMemberUrl = "https://ngssgproxy.memgate.com/api/member/";
//        $profileUrl = "https://ngssgproxy.memgate.com/api/profile/";
//        //        $SvcAuthUserName = "TRINAX";
//        $SvcAuthPassword = "YFMh7tcCBqQE";
//        $SvcAuthToken = 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==';
        //            production api end here
        // staging api start here
        $tokenUrl         = "http://sng-test.elasticbeanstalk.com/api/ngstoken";
        $loginUrl         = "https://hzmmhfacy4.execute-api.ap-southeast-1.amazonaws.com/dev/user/login";
        $svcTokenUrl      = "https://ngssgproxyuat.memgate.com/api/user/authenticate";
        $getMember        = "https://ngssgproxyuat.memgate.com/api/profile";
        $upgradeMemberUrl = "https://ngssgproxyuat.memgate.com/api/member/";
        $profileUrl       = "https://ngssgproxyuat.memgate.com/api/profile/";
        $SvcAuthUserName  = "TRINAX";
        $SvcAuthPassword  = "LFy4cUD6E3Gu";
        $SvcAuthToken     = 'VFJJTkFY,VkEyOFloSjlDd3lCWmRLVA==';
        // staging api end here
        $benefitUpdate = "https://ngssgproxyuat.memgate.com/api/benefit";

        $Childs = $request['ChildData'];

        $client       = new \GuzzleHttp\Client();
        $res          = $client->request( 'POST', $tokenUrl, [
            'form_params' => [
                'password'   => "gallery-kids-sso",
                'grant_type' => "password",
                'scope'      => "am_application_scope user_web artwork_web comment_web",
                'username'   => "gallery-kids-sso",
            ]
        ] );
        $tokenRespose = json_decode( (string) $res->getBody() );
        $token        = $tokenRespose->access_token;


        $membersonCustNumber = Auth::user()['membersonCustNumber'];
        $profileToken        = Auth::user()['profileToken'];
        $memberNo            = Auth::user()['memberNo'];
        try {
            $response = $client->request( 'POST', $svcTokenUrl, [
                'headers'                        => [
                    'Accept'  => 'application/json',
                    'SvcAuth' => $SvcAuthToken,
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'username' => $SvcAuthUserName,
                    'password' => $SvcAuthPassword
                ]//$request->except(['_token'])
            ] );
            $data     = json_decode( (string) $response->getBody()->getContents() );
            $svcToken = $data;
            try {
                $date     = \Carbon\Carbon::now();
                $datetime = date( "c", strtotime( $date ) );

                $response = $client->request( 'Get', $profileUrl . $membersonCustNumber, [
                    'headers' => [
                        'Accept'       => 'application/json',
                        'SvcAuth'      => $SvcAuthToken,
                        'Token'        => $svcToken,
                        'ProfileToken' => $profileToken,
                        // 'Content-Type' => 'application/json',
                    ],
                ] );

                try {


                    foreach ( $Childs as $Child ) {
                        $pass     = rand( 100000, 999999 );
                        $icNumber = 'K00' . $pass;
                        //  $date = \Carbon\Carbon::now();
                        $date    = \Carbon\Carbon::createFromFormat( 'd/m/Y', $Child['Childdate'] );
                        $newDate = \Carbon\Carbon::parse( $date )->format( 'Y-m-d' );
//                        $childDob = date("c", strtotime($newDate));
                        $childDob = $newDate . 'T00:00:00+08:00';


                        $response                     = $client->request( 'POST', $profileUrl . '/' . $membersonCustNumber . '/contact-persons/add', [
                            'headers'                        => [
                                'Accept'       => 'application/json',
                                'SvcAuth'      => $SvcAuthToken,
                                'Token'        => $svcToken,
                                'ProfileToken' => $profileToken,
                                // 'Content-Type' => 'application/json',
                            ],
                            \GuzzleHttp\RequestOptions::JSON => [
                                'Type'      => "CHILD",
                                'FirstName' => $Child['Childfirstname'],
                                'LastName'  => $Child['Childlastname'],
                                'IC'        => $icNumber,
                                'DOB'       => $childDob,
                                'Gender'    => "M"
                            ]//$request->except(['_token'])
                        ] );
                        $year                         = date( 'Y', strtotime( $newDate ) );
                        $student                      = new User();
                        $dataStudent                  = $request->only( [
                            'password',
                            'role_id',
                            'firstname',
                            'lastname'
                        ] );
                        $dataStudent['year_of_birth'] = $year;
                        $dataStudent['password']      = Auth::user()['password'];
                        $dataStudent['first_name']    = $Child['Childfirstname'];
                        $dataStudent['last_name']     = $Child['Childlastname'];
                        $dataStudent['role_id']       = 4;
                        $student                      = $student->create( $dataStudent );
                        $parent                       = new ParentStudent();
                        $dataParent                   = $request->only( [ 'parent_id', 'child_id' ] );
                        $dataParent['parent_id']      = Auth::user()['id'];
                        $dataParent['child_id']       = $student['id'];
                        $parent                       = $parent->create( $dataParent );
                    }

                    $date     = \Carbon\Carbon::today();
                    $response = $client->request( 'get', $profileUrl . '/' . $membersonCustNumber . '/contact-persons', [
                        'headers' => [
                            'Accept'       => 'application/json',
                            'SvcAuth'      => $SvcAuthToken,
                            'Token'        => $svcToken,
                            'ProfileToken' => $profileToken,
                            // 'Content-Type' => 'application/json',
                        ],
                    ] );
                    $families = json_decode( (string) $response->getBody()->getContents() );


                    $dOB = array();
                    foreach ( $families as $family ) {
                        $dateOfBirth = date( 'd-m-Y', strtotime( $family->DOB ) );
                        $years       = \Carbon\Carbon::parse( $dateOfBirth )->age;
                        $dOB[]       = $dateOfBirth;
                    }


                    usort( $dOB, function ( $a, $b ) {
                        $dateTimestamp1 = strtotime( $a );
                        $dateTimestamp2 = strtotime( $b );

                        return $dateTimestamp1 < $dateTimestamp2 ? - 1 : 1;
                    } );
                    $youngerChild = $dOB[ count( $dOB ) - 1 ];

                    $carbon           = \Carbon\Carbon::parse( $youngerChild );
                    $expireDateOld    = date( 'Y-m-d', strtotime( $carbon->addYear( 12 ) ) );
                    $expireFormatDate = \Carbon\Carbon::parse( $expireDateOld )->addDays( 1 );
                    $newDateFormat    = $date->format( 'Y-m-d' );
                    $expireDate       = $expireFormatDate . 'T23:59:59+08:00';
                    $newValdidFrom    = $newDateFormat . 'T00:00:00+08:00';

                    try {

//                        $benefitCode = $this->benefitCode($memberNo, $svcToken, $profileToken);
//                        $Identifier = '';
//                        foreach ($benefitCode as $Code) {
//                            $Identifier = $Code->Identifier;
//                        }
                        $response   = $client->request( 'GET', $upgradeMemberUrl . '/' . $memberNo . '/benefits?benefitCode=GPE', [
                            'headers' => [
                                'Accept'       => 'application/json',
                                'SvcAuth'      => $SvcAuthToken,
                                'Token'        => $svcToken,
                                'ProfileToken' => $profileToken,
                            ],
                        ] );
                        $data       = json_decode( (string) $response->getBody()->getContents() );
                        $Identifier = '';

                        foreach ( $data as $value ) {

                            $Identifier = $value->Status;
                        }

//                      $Identifier = $benefitCode->Identifier;
//                        $updateBenefitCode = $this->updateBenefitCode($memberNo, $svcToken, $profileToken, $Identifier, $expireDate);

                        $date = \Carbon\Carbon::today();


                        $client   = new \GuzzleHttp\Client();
                        $response = $client->request( 'POST', $benefitUpdate . '/' . $Identifier, [
                            'headers'                        => [
                                'Accept'       => 'application/json',
                                'SvcAuth'      => $SvcAuthToken,
                                'Token'        => $svcToken,
                                'ProfileToken' => $profileToken,
                            ],
                            \GuzzleHttp\RequestOptions::JSON => [
                                "Amount"      => 100,
                                "ValidFrom"   => date( "c", strtotime( $newValdidFrom ) ),
                                "ExpiryDate"  => date( "c", strtotime( $expireDate ) ),
                                "Description" => "Benefit Description",
                                "Status"      => "ACTIVE"
                            ]
                        ] );
                        $data     = json_decode( (string) $response->getBody()->getContents() );

                        return $data;

                        $response = [ 'message' => "success" ];

                        return response( $response, 200 );
//                                    dd($response);
                    } catch ( \Exception $e ) {
                        $message = $e->getMessage();

                        return response( $message, 500 );
                    }
                } catch ( \Exception $e ) {
                    $message = $e->getMessage();

                    return response( $message, 500 );
                }
            } catch ( \Exception $e ) {
                $message = $e->getMessage();

                return response( $message, 500 );
            }
        } catch ( \Exception $e ) {
            $message = $e->getMessage();

            return response( $message, 500 );
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index( Request $request )
    {

        $request->validate( [
            'type' => 'required|string|in:guardian,teacher,student'
        ] );

        $data  = $request->all();
        $role  = Role::where( 'name', $data['type'] )->first();
        $users = User::where( 'role_id', $role->id )->get();

        switch ( $data['type'] ) {
            case 'guardian':
                return view( 'user::guardian.index', compact( 'users' ) );
                break;
            case 'teacher':
                return view( 'user::teacher.index', compact( 'users' ) );
                break;
            case 'student':
                return view( 'user::student.index', compact( 'users' ) );
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view( 'user::create' );
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

        return view( 'user::show' );
    }

    /**
     * Get Parent/Teacher Students.
     *
     * @param int $id
     *
     * @return Response
     */
    public function StudentLogin( Request $request )
    {
        $password = $request['password'];
        $email    = Auth::user()['email'];
        $id       = $request['id'];
        $date     = \Carbon\Carbon::today();
        //            production api start here
//        $loginUrl = "https://explorercms.nationalgallery.sg/api2/user/login";
//        $tokenUrl = "https://explorercms.nationalgallery.sg/app/api/ngstoken";
        //            production api end here
        // staging api start here
        $loginUrl = "https://hzmmhfacy4.execute-api.ap-southeast-1.amazonaws.com/dev/user/login";
        $tokenUrl = "http://sng-test.elasticbeanstalk.com/api/ngstoken";
        // staging spi end here

        $client       = new \GuzzleHttp\Client();
        $res          = $client->request( 'POST', $tokenUrl, [
            'form_params' => [
                'password'   => "gallery-kids-sso",
                'grant_type' => "password",
                'scope'      => "am_application_scope user_web artwork_web comment_web",
                'username'   => "gallery-kids-sso",
            ]
        ] );
        $tokenRespose = json_decode( (string) $res->getBody() );
        $token        = $tokenRespose->access_token;

        $response = $client->request( 'POST', $loginUrl, [
            'headers'                        => [
                'Accept'        => 'application/json',
                'Authorization' => $token,
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'email'        => $email,
                'locationCode' => "YFMh7tcCBqQE",
                'password'     => $password
            ]//$request->except(['_token'])
        ] );
        $data     = json_decode( (string) $response->getBody()->getContents() );


        $user = User::find( $id );
        if ( $user ) {
            Auth::logout();
            Auth::login( $user );
            $user['visit'] = $user['visit'] + 1;
            $user['date']  = \Carbon\Carbon::now();
            $user->save();
            $response = [ 'message' => 'Success' ];

            return response( $response, 200 );
        } else {
            $response = [ 'message' => 'Incorrect password' ];

            return response( $response, 500 );
        }
    }

    /**
     * parent login
     * @return Response
     */
    public function parentLogin( Request $request )
    {
        $password = $request['password'];
        $id       = $request['id'];
        $user     = User::whereRoleId( 3 )->whereId( $id )->first();
        $password = $request['password'];
        $email    = $user['email'];
        //            production api start here
//        $loginUrl = "https://explorercms.nationalgallery.sg/api2/user/login";
//        $tokenUrl = "https://explorercms.nationalgallery.sg/app/api/ngstoken";
        //            production api end here
        // staging start here
        $loginUrl = "https://hzmmhfacy4.execute-api.ap-southeast-1.amazonaws.com/dev/user/login";
        $tokenUrl = "http://sng-test.elasticbeanstalk.com/api/ngstoken";
        //  staging end here

        $client       = new \GuzzleHttp\Client();
        $res          = $client->request( 'POST', $tokenUrl, [
            'form_params' => [
                'password'   => "gallery-kids-sso",
                'grant_type' => "password",
                'scope'      => "am_application_scope user_web artwork_web comment_web",
                'username'   => "gallery-kids-sso",
            ]
        ] );
        $tokenRespose = json_decode( (string) $res->getBody() );
        $token        = $tokenRespose->access_token;

        $response = $client->request( 'POST', $loginUrl, [
            'headers'                        => [
                'Accept'        => 'application/json',
                'Authorization' => $token,
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'email'        => $email,
                'locationCode' => "YFMh7tcCBqQE",
                'password'     => $password
            ]//$request->except(['_token'])
        ] );
        $data     = json_decode( (string) $response->getBody()->getContents() );
        if ( $data->result == 'success' ) {
            if ( $user ) {
                Auth::logout();
                Auth::login( $user );
                $user['visit'] = $user['visit'] + 1;
                $user['date']  = \Carbon\Carbon::now();
                $user->save();

                $response = [ 'message' => 'Success' ];

                return response( $response, 200 );
            } else {
                $response = [ 'message' => 'Incorrect password' ];

                return response( $response, 500 );
            }
        } else {
            $response = [ 'message' => 'Incorrect password' ];

            return response( $response, 500 );
        }
    }

    public function myChalanges( Request $request )
    {
        $chalangeId = $request['id'];
        $userId     = Auth::user()['id'];
        if ( $user = UserChallenge::whereChallangeId( $chalangeId )->whereUserId( $userId )->first() ) {
            //  dd($user);
        } else {
            $challenge            = new UserChallenge();
            $data                 = $request->only( [ 'challange_id', 'user_id' ] );
            $data['challange_id'] = $chalangeId;
            $data['user_id']      = $userId;
            $challenge            = $challenge->create( $data );
            $response             = [ 'message' => "It seems that you are not register with us. Please contact service provider." ];

            return response( $response, 404 );
        }
    }

    /**
     * Change Status.
     *
     * @param int $id
     *
     * @return Response
     */
    public function changeStatus( $id )
    {

        try {

            $user   = User::findOrFail( $id );
            $status = 'Disable';
            if ( $user->status == 'Disable' ) {
                $status = 'Enable';
            }

            $data['status'] = $status;

            switch ( $user->role->name ) {
                case 'guardian':
                    if ( ! is_null( $user->email ) ) {
                        $parent_ids   = $user->children->first()->parents->pluck( 'id' )->toArray();
                        $children_ids = $user->children->pluck( 'id' )->toArray();
                        User::whereIn( 'id', array_merge( $parent_ids, $children_ids ) )->update( $data );
                        session()->flash( 'success', "Guardians and its childrens status changed to {$user->status} successfully" );
                    }
                    session()->flash( 'success', "Guardian and its childrens status changed to {$user->status} successfully" );

                    return redirect()->back();

                    break;
                case 'teacher':
                    $user->children()->update( $data );
                    session()->flash( 'success', "Teacher and it's Students status changed to {$user->status} successfully" );
                    break;
                case 'student':
                    session()->flash( 'success', "Student status changed to {$user->status} successfully" );
                    break;
            }

            $user->status = $status;
            $user->save();
        } catch ( \Exception $e ) {

            session()->flash( 'error', $e->getMessage() );

            return redirect()->back();
        }

        return redirect()->back();
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
        return view( 'user::edit' );
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
