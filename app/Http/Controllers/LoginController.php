<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Mail;
use Auth;
use App\Mail\SendOtp;
use App\Imports\StudentsImport;
use App\Import;
use Session;
use Excel;
use Validator;
use Modules\User\Entities\ParentStudent;

class LoginController extends Controller {

    /**
     * Displays login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginPage() {
        return view('login');
    }

    /**
     * login step one .
     *
     */
    //    03-Dec-20 icNumber ,DOB format,Moblie Number ,Phone
    public function LoginStepOne(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $email = $request['email'];
        $password = $request['password'];
        //   $pass = rand(100000, 999999);
//        $icNumber = 'K00' . $pass;
// dd('K00'.$pass);
//        production api start here
//        $tokenUrl = "https://explorercms.nationalgallery.sg/app/api/ngstoken";
//        $loginUrl = "https://explorercms.nationalgallery.sg/api2/user/login";
//        $svcTokenUrl = "https://ngssgproxy.memgate.com/api/user/authenticate";
//        $getMember = "https://ngssgproxy.memgate.com/api/profile";
//        $upgradeMemberUrl = "https://ngssgproxy.memgate.com/api/member/";
//        $profileUrl = "https://ngssgproxy.memgate.com/api/profile/";
//         $SvcAuthUserName = "TRINAX";
//        $SvcAuthPassword = "YFMh7tcCBqQE";
//        $SvcAuthToken = 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==';
//        production api end here
//
        //        staging api start here
        $tokenUrl = "http://sng-test.elasticbeanstalk.com/api/ngstoken";
        $loginUrl = "https://hzmmhfacy4.execute-api.ap-southeast-1.amazonaws.com/dev/user/login";
        $svcTokenUrl = "https://ngssgproxyuat.memgate.com/api/user/authenticate";
        $getMember = "https://ngssgproxyuat.memgate.com/api/profile";
        $upgradeMemberUrl = "https://ngssgproxyuat.memgate.com/api/member/";
        $profileUrl = "https://ngssgproxyuat.memgate.com/api/profile/";
        $SvcAuthUserName = "TRINAX";
        $SvcAuthPassword = "LFy4cUD6E3Gu";
        $SvcAuthToken = 'VFJJTkFY,VkEyOFloSjlDd3lCWmRLVA==';
//        production api end here


        $start_new_date = \Carbon\Carbon::now();
        $StartDate = date("c", strtotime($start_new_date));
        $client = new \GuzzleHttp\Client();
        // return response($client, 500);
        $res = $client->request('POST', $tokenUrl, [
            'form_params' => [
                'password' => "gallery-kids-sso",
                'grant_type' => "password",
                'scope' => "am_application_scope user_web artwork_web comment_web",
                'username' => "gallery-kids-sso",
            ]
        ]);
        $tokenRespose = json_decode((string) $res->getBody());
        $token = $tokenRespose->access_token;
        // dd($token);

        try {
            $response = $client->request('POST', $loginUrl, ['headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $token,
                // 'Content-Type' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::JSON => ['email' => $email,
                    'locationCode' => "LKIDSCLUBWEB",
                    'password' => $password]//$request->except(['_token'])
            ]);
            $data = json_decode((string) $response->getBody()->getContents());

            if ($data->result == 'success') {
                $registerResponse = json_decode((string) $response->getBody());
                $membersonCustNumber = $registerResponse->response->membersonCustNumber;
                $profileToken = $registerResponse->response->profileToken;
                $memberNo = $registerResponse->response->memberNo;

                $user = User::where('email', $request->email)->first();

                if (!$user) {
                    $response = $client->request('POST', $svcTokenUrl, ['headers' => [
                            'Accept' => 'application/json',
                            'SvcAuth' => $SvcAuthToken,
                        ],
                        \GuzzleHttp\RequestOptions::JSON => ['username' => $SvcAuthUserName,
                            'password' => $SvcAuthPassword]//$request->except(['_token'])
                    ]);
                    $data = json_decode((string) $response->getBody()->getContents());
                    $svcToken = $data;
                    $user = new User();
                    $data = $request->only(['email', 'date', 'role_id', 'firstname', 'lastname', 'subscribe']);
                    $data['email'] = $registerResponse->response->email;
                    $data['username'] = $registerResponse->response->email;
                    $data['first_name'] = $registerResponse->response->firstName;
                    $data['subscribe'] = 0;
                    $data['last_name'] = $registerResponse->response->lastName;

                    $data['role_id'] = 3;
                    $data['membersonCustNumber'] = $membersonCustNumber;
                    $data['profileToken'] = $profileToken;
                    $data['memberNo'] = $memberNo;
                    $data['visit'] = 1;
                    $data['date'] = \Carbon\Carbon::now();
                    $user = $user->create($data);

                    $date = \Carbon\Carbon::today();
                    $response = $client->request('get', $profileUrl . '/' . $membersonCustNumber . '/contact-persons', ['headers' => [
                            'Accept' => 'application/json',
                            'SvcAuth' => $SvcAuthToken,
                            'Token' => $svcToken,
                            'ProfileToken' => $profileToken,
                        // 'Content-Type' => 'application/json',
                        ],
                    ]);
                    $families = json_decode((string) $response->getBody()->getContents());

                    foreach ($families as $family) {
                        $year = date('Y', strtotime($family->DOB));
                        $student = new User();
                        $dataStudent = $request->only(['role_id', 'firstname', 'lastname']);
                        $dataStudent['first_name'] = $family->FirstName;
                        $dataStudent['last_name'] = $family->LastName;
                        $dataStudent['year_of_birth'] = $year;
                        $dataStudent['role_id'] = 4;
                        $student = $student->create($dataStudent);
                        $parent = new ParentStudent();
                        $dataParent = $request->only(['parent_id', 'child_id']);
                        $dataParent['parent_id'] = $user['id'];
                        $dataParent['child_id'] = $student['id'];
                        $parent = $parent->create($dataParent);
                    }
                }


                try {
                    $response = $client->request('POST', $svcTokenUrl, ['headers' => [
                            'Accept' => 'application/json',
                            'SvcAuth' => $SvcAuthToken,
                        ],
                        \GuzzleHttp\RequestOptions::JSON => ['username' => $SvcAuthUserName,
                            'password' => $SvcAuthPassword]//$request->except(['_token'])
                    ]);
                    $data = json_decode((string) $response->getBody()->getContents());
                    $svcToken = $data;

                    try {
                        $response = $client->request('GET', $getMember . '/' . $membersonCustNumber . '/summary', ['headers' => [
                                'Accept' => 'application/json',
                                'SvcAuth' => $SvcAuthToken,
                                'Token' => $svcToken,
                                'ProfileToken' => $profileToken,
                            ],
                        ]);
                        $data = json_decode((string) $response->getBody()->getContents());
                        //  dd($data);
                        $Type = '';
                        $Tier = '';
                        $Status = '';

                        foreach ($data->MembershipSummaries as $mebmer) {
                            if ($mebmer->Status == 'ACTIVE') {
                                $Type = $mebmer->Type;
                                $Tier = $mebmer->Tier;
                                $Status = $mebmer->Status;
                            }
                        }

                        if ($Type == 'Gallery Parent Explorer') {
                            try {
                                $response = $client->request('GET', $upgradeMemberUrl . '/' . $memberNo . '/benefits?benefitCode=GPE', ['headers' => [
                                        'Accept' => 'application/json',
                                        'SvcAuth' => $SvcAuthToken,
                                        'Token' => $svcToken,
                                        'ProfileToken' => $profileToken,
                                    ],
                                ]);
                                $data = json_decode((string) $response->getBody()->getContents());
                                $benifitStatus = '';

                                foreach ($data as $value) {

                                    $benifitStatus = $value->Status;
                                }

                                if ($benifitStatus == 'CREATED') {
                                    $user = User::where('email', $request->email)->first();
                                    Auth::login($user);
                                    $user['membersonCustNumber'] = $membersonCustNumber;
                                    $user['profileToken'] = $profileToken;
                                    $user['memberNo'] = $memberNo;
                                    $user['visit'] = $user['visit'] + 1;
                                    $user['date'] = \Carbon\Carbon::now();
                                    $user->save();
                                    $childrens = $user->children;
                                    foreach ($childrens as $children) {
                                        $childrenData = User::find($children['id']);
                                        $childrenData->save();
                                    }

                                    Auth::login($user);
                                    $user['membersonCustNumber'] = $membersonCustNumber;
                                    $user['profileToken'] = $profileToken;
                                    $user['memberNo'] = $memberNo;
                                    $user['visit'] = $user['visit'] + 1;
                                    $user['date'] = \Carbon\Carbon::now();
                                    $user->save();

                                    $response = ['message' => 'CREATED'];
                                    return response($response, 200);
                                } else {
                                    $response = ['message' => 'NOTCREATED'];
                                    return response($response, 500);
                                }



//                    foreach($data[''])
                            } catch (\Exception $e) {
                                $message = $e->getMessage();
                                return response($message, 500);
                            }
                        } else if ($Type == 'Gallery Explorer') {
                            $response = ['message' => 'Gallery Explorer'];
                            return response($response, 500);
                        } else {


                            try {
                                $response = $client->request('GET', $upgradeMemberUrl . '/' . $memberNo . '/benefits?benefitCode=GPE', ['headers' => [
                                        'Accept' => 'application/json',
                                        'SvcAuth' => $SvcAuthToken,
                                        'Token' => $svcToken,
                                        'ProfileToken' => $profileToken,
                                    ],
                                ]);
                                $data = json_decode((string) $response->getBody()->getContents());
                                $benifitStatus = '';

                                foreach ($data as $value) {

                                    $benifitStatus = $value->Status;
                                }

                                if ($benifitStatus == 'CREATED') {
                                    $user = User::where('email', $request->email)->first();
                                    Auth::login($user);
                                    $user['membersonCustNumber'] = $membersonCustNumber;
                                    $user['profileToken'] = $profileToken;
                                    $user['memberNo'] = $memberNo;
                                    $user['visit'] = $user['visit'] + 1;
                                    $user['date'] = \Carbon\Carbon::now();
                                    $user->save();
                                    $response = ['message' => 'CREATED'];
                                    return response($response, 200);
                                } else {
                                    $response = ['message' => 'NOTCREATED'];
                                    return response($response, 500);
                                }



//                    foreach($data[''])
                            } catch (\Exception $e) {
                                $message = $e->getMessage();
                                return response($message, 500);
                            }
                        }
//                    foreach($data[''])
                    } catch (\Exception $e) {
                        $message = $e->getMessage();
                        return response($message, 500);
                    }
                } catch (\Exception $e) {
                    $message = $e->getMessage();
                    return response($message, 500);
                }
            } else {
                $response = ['message' => $data->response->message];
                return response($response, 500);
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response($message, 500);
        }
    }

    /**
     * login step two .
     *
     */
    //    08-Dec-20 icNumber ,DOB format,Moblie Number ,Phone
    //    09-Dec-20 Change icNumber
    //    09-Dec-20 add one days for expire date
    //    09-Dec-20 new data editing in put api
    public function LoginStepTwo(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
//        $pass = rand(100000, 999999);
//        $icNumber = 'K00' . $pass;
        $email = $request['email'];
        $password = $request['password'];
        $Childs = $request['ChildData'];
        $mobile = $request['mobile'];
        $country = $request['country'];

//        production api start here
//        $tokenUrl = "https://explorercms.nationalgallery.sg/app/api/ngstoken";
//        $loginUrl = "https://explorercms.nationalgallery.sg/api2/user/login";
//        $svcTokenUrl = "https://ngssgproxy.memgate.com/api/user/authenticate";
//        $getMember = "https://ngssgproxy.memgate.com/api/profile";
//        $upgradeMemberUrl = "https://ngssgproxy.memgate.com/api/member/";
//        $profileUrl = "https://ngssgproxy.memgate.com/api/profile/";
//        $benefitIssue = "https://ngssgproxy.memgate.com/api/benefit/issue";
//        production api end here
//
//         staging api start here
        $tokenUrl = "http://sng-test.elasticbeanstalk.com/api/ngstoken";
        $loginUrl = "https://hzmmhfacy4.execute-api.ap-southeast-1.amazonaws.com/dev/user/login";
        $svcTokenUrl = "https://ngssgproxyuat.memgate.com/api/user/authenticate";
        $getMember = "https://ngssgproxyuat.memgate.com/api/profile";
        $upgradeMemberUrl = "https://ngssgproxyuat.memgate.com/api/member/";
        $profileUrl = "https://ngssgproxyuat.memgate.com/api/profile/";
        $benefitIssue = "https://ngssgproxyuat.memgate.com/api/benefit/issue";
        $SvcAuthUserName = "TRINAX";
        $SvcAuthPassword = "LFy4cUD6E3Gu";
        $SvcAuthToken = 'VFJJTkFY,VkEyOFloSjlDd3lCWmRLVA==';
        $parentDate = $request['date'];
        $gender = $request['gender'];
//        staging api start here

        $start_new_date = \Carbon\Carbon::now();
        $ReceiptNumber = uniqid();
        $StartDate = date("c", strtotime($start_new_date));
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', $tokenUrl, [
            'form_params' => [
                'password' => "gallery-kids-sso",
                'grant_type' => "password",
                'scope' => "am_application_scope user_web artwork_web comment_web",
                'username' => "gallery-kids-sso",
            ]
        ]);
        $tokenRespose = json_decode((string) $res->getBody());
        $token = $tokenRespose->access_token;
        //dd($token);

        try {
            $response = $client->request('POST', $loginUrl, ['headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $token,
                // 'Content-Type' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::JSON => ['email' => $email,
                    'locationCode' => "LKIDSCLUBWEB",
                    'password' => $password]//$request->except(['_token'])
            ]);
            $data = json_decode((string) $response->getBody()->getContents());

            if ($data->result == 'success') {
                $registerResponse = json_decode((string) $response->getBody());
                $membersonCustNumber = $registerResponse->response->membersonCustNumber;
                $profileToken = $registerResponse->response->profileToken;
                $memberNo = $registerResponse->response->memberNo;
                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    $response = $client->request('POST', $svcTokenUrl, ['headers' => [
                            'Accept' => 'application/json',
                            'SvcAuth' => $SvcAuthToken,
                        ],
                        \GuzzleHttp\RequestOptions::JSON => ['username' => $SvcAuthUserName,
                            'password' => $SvcAuthPassword]//$request->except(['_token'])
                    ]);
                    $data = json_decode((string) $response->getBody()->getContents());
                    $svcToken = $data;
                    $user = new User();
                    $data = $request->only(['email', 'date', 'role_id', 'firstname', 'lastname', 'subscribe']);
                    $data['email'] = $registerResponse->response->email;
                    $data['username'] = $registerResponse->response->email;
                    $data['first_name'] = $registerResponse->response->firstName;
                    $data['subscribe'] = 0;
                    $data['last_name'] = $registerResponse->response->lastName;

                    $data['role_id'] = 3;
                    $data['membersonCustNumber'] = $membersonCustNumber;
                    $data['profileToken'] = $profileToken;
                    $data['memberNo'] = $memberNo;
                    $data['visit'] = 1;
                    $data['date'] = \Carbon\Carbon::now();
                    $user = $user->create($data);

                    $date = \Carbon\Carbon::today();
                    $response = $client->request('get', $profileUrl . '/' . $membersonCustNumber . '/contact-persons', ['headers' => [
                            'Accept' => 'application/json',
                            'SvcAuth' => $SvcAuthToken,
                            'Token' => $svcToken,
                            'ProfileToken' => $profileToken,
                        // 'Content-Type' => 'application/json',
                        ],
                    ]);
                    $families = json_decode((string) $response->getBody()->getContents());
                    foreach ($families as $family) {
                        $year = date('Y', strtotime($family->DOB));
                        $student = new User();
                        $dataStudent = $request->only(['role_id', 'firstname', 'lastname']);
                        $dataStudent['first_name'] = $family->FirstName;
                        $dataStudent['last_name'] = $family->LastName;
                        $dataStudent['year_of_birth'] = $year;
                        $dataStudent['role_id'] = 4;
                        $student = $student->create($dataStudent);
                        $parent = new ParentStudent();
                        $dataParent = $request->only(['parent_id', 'child_id']);
                        $dataParent['parent_id'] = $user['id'];
                        $dataParent['child_id'] = $student['id'];
                        $parent = $parent->create($dataParent);
                    }
                }
                try {
                    $response = $client->request('POST', $svcTokenUrl, ['headers' => [
                            'Accept' => 'application/json',
                            'SvcAuth' => $SvcAuthToken,
                        ],
                        \GuzzleHttp\RequestOptions::JSON => ['username' => $SvcAuthUserName,
                            'password' => $SvcAuthPassword]//$request->except(['_token'])
                    ]);
                    $data = json_decode((string) $response->getBody()->getContents());
                    $svcToken = $data;
                    try {
                        $date = \Carbon\Carbon::now();
                        $datetime = date("c", strtotime($date));

                        $response = $client->request('Get', $profileUrl . '/' . $membersonCustNumber, ['headers' => [
                                'Accept' => 'application/json',
                                'SvcAuth' => $SvcAuthToken,
                                'Token' => $svcToken,
                                'ProfileToken' => $profileToken,
                            // 'Content-Type' => 'application/json',
                            ],
                        ]);
                        $profileData = json_decode((string) $response->getBody()->getContents());

                        $datetime = date("c", strtotime($date));
                        $response = $client->request('get', $profileUrl . '/' . $membersonCustNumber . '/contact-persons', ['headers' => [
                                'Accept' => 'application/json',
                                'SvcAuth' => $SvcAuthToken,
                                'Token' => $svcToken,
                                'ProfileToken' => $profileToken,
                            // 'Content-Type' => 'application/json',
                            ],
                        ]);
                        $families = json_decode((string) $response->getBody()->getContents());
                        $type = [];
                        $number = [];
                        $CountryCode = [];
                        $IsVerified = [];
                        foreach ($profileData->Phones as $phoneData) {

                            $type[] = $phoneData->Type;
                            $number[] = $phoneData->Number;
                            $CountryCode[] = $phoneData->CountryCode;
                            $IsVerified[] = $phoneData->IsVerified;
                        }

                        $phonesDetails = array(
                            array(
                                'Type' => $type[0],
                                'Number' => $number[0],
                                'CountryCode' => $CountryCode[0],
                                'IsVerified' => $IsVerified[0],
                            ),
                            array(
                                'Type' => $type[1],
                                'Number' => $number[1],
                                'CountryCode' => $CountryCode[1],
                                'IsVerified' => $IsVerified[1],
                            ),
                            array(
                                'Type' => $type[2],
                                'Number' => $mobile,
                                'CountryCode' => $CountryCode[2],
                                'IsVerified' => $IsVerified[2],
                            )
                        );

                        $parentnwDate = \Carbon\Carbon::parse($parentDate)->format('Y-m-d');
                        $parentDob = $parentnwDate . 'T00:00:00+08:00';
//                        dd($parentDob,$gender);
                        $response = $client->request('PUT', $profileUrl . '/' . $membersonCustNumber, ['headers' => [
                                'Accept' => 'application/json',
                                'SvcAuth' => $SvcAuthToken,
                                'Token' => $svcToken,
                                'ProfileToken' => $profileToken,
                            // 'Content-Type' => 'application/json',
                            ],
                            \GuzzleHttp\RequestOptions::JSON => ['FirstName' => $profileData->FirstName,
                                'LastName' => $profileData->LastName,
                                'DefaultAddressType' => 'HOME',
                                'GenderCode' => $gender,
                                'DOB' => $parentDob,
                                'CustomerNumber' => $profileData->CustomerNumber,
                                'Title' => $profileData->Title,
                                'IC' => $profileData->IC,
                                'JoinDate' => $profileData->JoinDate,
                                'NationalityCode' => $country,
                                'Remark' => $profileData->Remark,
                                'NickName' => $profileData->NickName,
                                'Addresses' => $profileData->Addresses,
                                'Email' => $profileData->Email,
                                'Phones' => $phonesDetails,
                                'Interests' => $profileData->Interests,
                                'ContactPreferences' => $profileData->ContactPreferences,
                                'CustomProperties' => $profileData->CustomProperties,
                                'LanguagePreference' => $profileData->LanguagePreference,
                                'Password' => $profileData->Password,
                                'ContactPersons' => $families]
                        ]);
                        try {

                            $response = $client->request('POST', $upgradeMemberUrl . $memberNo . '/Upgrade', ['headers' => [
                                    'Accept' => 'application/json',
                                    'SvcAuth' => $SvcAuthToken,
                                    'Token' => $svcToken,
                                    'ProfileToken' => $profileToken,
                                // 'Content-Type' => 'application/json',
                                ],
                                \GuzzleHttp\RequestOptions::JSON => ['StartDate' => $StartDate,
                                    'TargerMembershipType' => "Gallery Parent Explorer",
                                    'LocationCode' => "LKIDSCLUBWEB",
                                    'Registrator' => "TRINAXWEB",
                                    'SalesPerson' => "TRINAXWEB",
                                    'Amount' => 0,
                                    'Currency' => "SGD",
                                    'ReceiptNumber' => $ReceiptNumber,
                                    'Description' => ""]//$request->except(['_token'])
                            ]);
                            $newMember = json_decode((string) $response->getBody()->getContents());
                            $newMemberNo = $newMember->NewMemberNumber;
//dd($svcToken,$profileToken,$membersonCustNumber);
                            try {
                                $date = \Carbon\Carbon::today();
                                $user = User::where('email', $request->email)->first();
                                Auth::login($user);
                                $user['membersonCustNumber'] = $membersonCustNumber;
                                $user['profileToken'] = $profileToken;
                                $user['memberNo'] = $memberNo;
                                $user['visit'] = $user['visit'] + 1;
                                $user['date'] = \Carbon\Carbon::now();
                                $user->save();
                                $childrens = $user->children;
                                foreach ($childrens as $children) {
                                    $childrenData = User::find($children['id']);
                                    $childrenData->save();
                                }

                                foreach ($Childs as $Child) {
                                    $pass = rand(100000, 999999);
                                    $icNumber = 'K00' . $pass;
                                    $date = \Carbon\Carbon::createFromFormat('d/m/Y', $Child['Childdate']);
                                    $newDate = \Carbon\Carbon::parse($date)->format('Y-m-d');
//                                    $childDob = date("c", strtotime($newDate));
                                    $childDob = $newDate . 'T00:00:00+08:00';
                                    $response = $client->request('POST', $profileUrl . '/' . $membersonCustNumber . '/contact-persons/add', ['headers' => [
                                            'Accept' => 'application/json',
                                            'SvcAuth' => $SvcAuthToken,
                                            'Token' => $svcToken,
                                            'ProfileToken' => $profileToken,
                                        // 'Content-Type' => 'application/json',
                                        ],
                                        \GuzzleHttp\RequestOptions::JSON => [
                                            'Type' => "CHILD",
                                            'FirstName' => $Child['Childfirstname'],
                                            'LastName' => $Child['Childlastname'],
                                            'IC' => $icNumber,
                                            'DOB' => $childDob,
                                            'Gender' => "M"]//$request->except(['_token'])
                                    ]);
                                    $year = date('Y', strtotime($newDate));
                                    $student = new User();
                                    $dataStudent = $request->only(['role_id', 'firstname', 'lastname']);
                                    $dataStudent['first_name'] = $Child['Childfirstname'];
                                    $dataStudent['year_of_birth'] = $year;
                                    $dataStudent['last_name'] = $Child['Childlastname'];
                                    $dataStudent['role_id'] = 4;
                                    $student = $student->create($dataStudent);
                                    $parent = new ParentStudent();
                                    $dataParent = $request->only(['parent_id', 'child_id']);
                                    $dataParent['parent_id'] = Auth::user()['id'];
                                    $dataParent['child_id'] = $student['id'];
                                    $parent = $parent->create($dataParent);
                                }

                                $date = \Carbon\Carbon::now();
                                $response = $client->request('get', $profileUrl . '/' . $membersonCustNumber . '/contact-persons', ['headers' => [
                                        'Accept' => 'application/json',
                                        'SvcAuth' => $SvcAuthToken,
                                        'Token' => $svcToken,
                                        'ProfileToken' => $profileToken,
                                    // 'Content-Type' => 'application/json',
                                    ],
                                ]);
                                $families = json_decode((string) $response->getBody()->getContents());


                                $dOB = array();
                                foreach ($families as $family) {
                                    $dateOfBirth = date('d-m-Y', strtotime($family->DOB));
                                    $years = \Carbon\Carbon::parse($dateOfBirth)->age;
                                    $dOB[] = $dateOfBirth;
                                }

                                usort($dOB, function($a, $b) {
                                    $dateTimestamp1 = strtotime($a);
                                    $dateTimestamp2 = strtotime($b);

                                    return $dateTimestamp1 < $dateTimestamp2 ? -1 : 1;
                                });
                                $youngerChild = $dOB[count($dOB) - 1];

                                $carbon = \Carbon\Carbon::parse($youngerChild);
                                $expireDate = date('Y-m-d', strtotime($carbon->addYear(12)));
                                $expireFormatDate = \Carbon\Carbon::parse($expireDate)->addDays(1);
                                $newDateFormat = $date->format('Y-m-d');
                                $newExpireDate = $expireFormatDate . 'T23:59:59+08:00';
                                $newValdidFrom = $newDateFormat . 'T00:00:00+08:00';

                                try {
                                    $response = $client->request('POST', $benefitIssue, ['headers' => [
                                            'Accept' => 'application/json',
                                            'SvcAuth' => $SvcAuthToken,
                                            'Token' => $svcToken,
                                            'ProfileToken' => $profileToken,
                                        // 'Content-Type' => 'application/json',
                                        ],
                                        \GuzzleHttp\RequestOptions::JSON => [
                                            'MemberNumber' => $newMemberNo,
                                            'BenefitCode' => 'GPE',
                                            'Description' => '',
                                            'LocationCode' => "LKIDSCLUBWEB",
                                            'Registrator' => "TRINAXWEB",
                                            'Amount' => 100,
                                            'ValidFrom' => $newValdidFrom,
                                            'ExpiryDate' => $newExpireDate,
                                        ]//$request->except(['_token'])
                                    ]);


                                    $response = ['message' => "success"];
                                    return response($response, 200);
//                                    dd($response);
                                } catch (\Exception $e) {
                                    echo $e->getMessage();
                                }
                            } catch (\Exception $e) {
                                echo $e->getMessage();
                            }
                        } catch (\Exception $e) {
                            echo $e->getMessage();
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                $response = ['message' => $data->response->message];
                return response($response, 500);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * login step three .
     *
     */
    //    09-Dec-20 Change icNumber
    //    09-Dec-20 add one days for expire date
    public function LoginStepThree(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        //  $pass = rand(100000, 999999);
//        $icNumber = 'K00' . $pass;
        $email = $request['email'];
        $password = $request['password'];

//         production api start here
//        $tokenUrl = "https://explorercms.nationalgallery.sg/app/api/ngstoken";
//        $loginUrl = "https://explorercms.nationalgallery.sg/api2/user/login";
//        $svcTokenUrl = "https://ngssgproxy.memgate.com/api/user/authenticate";
//        $getMember = "https://ngssgproxy.memgate.com/api/profile";
//        $upgradeMemberUrl = "https://ngssgproxy.memgate.com/api/member/";
//        $profileUrl = "https://ngssgproxy.memgate.com/api/profile/";
//        $benefitIssue = "https://ngssgproxy.memgate.com/api/benefit/issue";
//         production api end here
//
//        staging api  start here
        $tokenUrl = "http://sng-test.elasticbeanstalk.com/api/ngstoken";
        $loginUrl = "https://hzmmhfacy4.execute-api.ap-southeast-1.amazonaws.com/dev/user/login";
        $svcTokenUrl = "https://ngssgproxyuat.memgate.com/api/user/authenticate";
        $getMember = "https://ngssgproxyuat.memgate.com/api/profile";
        $upgradeMemberUrl = "https://ngssgproxyuat.memgate.com/api/member/";
        $profileUrl = "https://ngssgproxyuat.memgate.com/api/profile/";
        $benefitIssue = "https://ngssgproxyuat.memgate.com/api/benefit/issue";
        $SvcAuthUserName = "TRINAX";
        $SvcAuthPassword = "LFy4cUD6E3Gu";
        $SvcAuthToken = 'VFJJTkFY,VkEyOFloSjlDd3lCWmRLVA==';
//        staging api  end here

        $Childs = $request['Childs'];
        $start_new_date = \Carbon\Carbon::now();
        $StartDate = date("c", strtotime($start_new_date));
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', $tokenUrl, [
            'form_params' => [
                'password' => "gallery-kids-sso",
                'grant_type' => "password",
                'scope' => "am_application_scope user_web artwork_web comment_web",
                'username' => "gallery-kids-sso",
            ]
        ]);
        $tokenRespose = json_decode((string) $res->getBody());
        $token = $tokenRespose->access_token;

        try {
            $response = $client->request('POST', $loginUrl, ['headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $token,
                // 'Content-Type' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::JSON => ['email' => $email,
                    'locationCode' => "LKIDSCLUBWEB",
                    'password' => $password]//$request->except(['_token'])
            ]);
            $data = json_decode((string) $response->getBody()->getContents());

            if ($data->result == 'success') {
                $registerResponse = json_decode((string) $response->getBody());
                $membersonCustNumber = $registerResponse->response->membersonCustNumber;
                $profileToken = $registerResponse->response->profileToken;
                $memberNo = $registerResponse->response->memberNo;
                $user = User::where('email', $request->email)->first();

                if (!$user) {
                    $response = $client->request('POST', $svcTokenUrl, ['headers' => [
                            'Accept' => 'application/json',
                            'SvcAuth' => $SvcAuthToken,
                        ],
                        \GuzzleHttp\RequestOptions::JSON => ['username' => $SvcAuthUserName,
                            'password' => $SvcAuthPassword]//$request->except(['_token'])
                    ]);
                    $data = json_decode((string) $response->getBody()->getContents());
                    $svcToken = $data;
                    $user = new User();
                    $data = $request->only(['email', 'date', 'role_id', 'firstname', 'lastname', 'subscribe']);
                    $data['email'] = $registerResponse->response->email;
                    $data['username'] = $registerResponse->response->email;
                    $data['first_name'] = $registerResponse->response->firstName;
                    $data['subscribe'] = 0;
                    $data['last_name'] = $registerResponse->response->lastName;

                    $data['role_id'] = 3;
                    $data['membersonCustNumber'] = $membersonCustNumber;
                    $data['profileToken'] = $profileToken;
                    $data['memberNo'] = $memberNo;
                    $data['visit'] = 1;
                    $data['date'] = \Carbon\Carbon::now();
                    $user = $user->create($data);

                    $date = \Carbon\Carbon::today();
                    $response = $client->request('get', $profileUrl . '/' . $membersonCustNumber . '/contact-persons', ['headers' => [
                            'Accept' => 'application/json',
                            'SvcAuth' => $SvcAuthToken,
                            'Token' => $svcToken,
                            'ProfileToken' => $profileToken,
                        // 'Content-Type' => 'application/json',
                        ],
                    ]);
                    $families = json_decode((string) $response->getBody()->getContents());
                    foreach ($families as $family) {
                        $year = date('Y', strtotime($family->DOB));
                        $student = new User();
                        $dataStudent = $request->only(['role_id', 'firstname', 'lastname']);
                        $dataStudent['first_name'] = $family->FirstName;
                        $dataStudent['last_name'] = $family->LastName;
                        $dataStudent['year_of_birth'] = $year;
                        $dataStudent['role_id'] = 4;
                        $student = $student->create($dataStudent);
                        $parent = new ParentStudent();
                        $dataParent = $request->only(['parent_id', 'child_id']);
                        $dataParent['parent_id'] = $user['id'];
                        $dataParent['child_id'] = $student['id'];
                        $parent = $parent->create($dataParent);
                    }
                }
                try {
                    $response = $client->request('POST', $svcTokenUrl, ['headers' => [
                            'Accept' => 'application/json',
                            'SvcAuth' => $SvcAuthToken,
                        ],
                        \GuzzleHttp\RequestOptions::JSON => ['username' => $SvcAuthUserName,
                            'password' => $SvcAuthPassword]//$request->except(['_token'])
                    ]);
                    $data = json_decode((string) $response->getBody()->getContents());
                    $svcToken = $data;
                    try {
                        $date = \Carbon\Carbon::now();
                        $datetime = date("c", strtotime($date));

                        $response = $client->request('Get', $profileUrl . '/' . $membersonCustNumber, ['headers' => [
                                'Accept' => 'application/json',
                                'SvcAuth' => $SvcAuthToken,
                                'Token' => $svcToken,
                                'ProfileToken' => $profileToken,
                            // 'Content-Type' => 'application/json',
                            ],
                        ]);



                        $user = User::where('email', $request->email)->first();
                        Auth::login($user);
                        $user['membersonCustNumber'] = $membersonCustNumber;
                        $user['profileToken'] = $profileToken;
                        $user['memberNo'] = $memberNo;
                        $user['visit'] = $user['visit'] + 1;
                        $user['date'] = \Carbon\Carbon::now();
                        $user->save();
                        $childrens = $user->children;
                        foreach ($childrens as $children) {
                            $childrenData = User::find($children['id']);
                            $childrenData->save();
                        }
                        try {


                            Auth::login($user);
                            $user['membersonCustNumber'] = $membersonCustNumber;
                            $user['profileToken'] = $profileToken;
                            $user['memberNo'] = $memberNo;
                            $user['visit'] = $user['visit'] + 1;
                            $user['date'] = \Carbon\Carbon::now();
                            $user->save();
                            $childrens = $user->children;
                            foreach ($childrens as $children) {
                                $childrenData = User::find($children['id']);
                                $childrenData->save();
                            }


                            foreach ($Childs as $Child) {
                                $pass = rand(100000, 999999);
                                $icNumber = 'K00' . $pass;
                                // 07/Dec/2020 DOB Format Fixed for adding chilg GI
                                $date = \Carbon\Carbon::createFromFormat('d/m/Y', $Child['Childdate']);
                                $newDate = \Carbon\Carbon::parse($date)->format('Y-m-d');
//                                $childDob = date("c", strtotime($newDate));
                                $childDob = $newDate . 'T00:00:00+08:00';
                                $response = $client->request('POST', $profileUrl . '/' . $membersonCustNumber . '/contact-persons/add', ['headers' => [
                                        'Accept' => 'application/json',
                                        'SvcAuth' => $SvcAuthToken,
                                        'Token' => $svcToken,
                                        'ProfileToken' => $profileToken,
                                    // 'Content-Type' => 'application/json',
                                    ],
                                    \GuzzleHttp\RequestOptions::JSON => [
                                        'Type' => "CHILD",
                                        'FirstName' => $Child['Childfirstname'],
                                        'LastName' => $Child['Childlastname'],
                                        'IC' => $icNumber,
                                        'DOB' => $childDob,
                                        'Gender' => "M"]//$request->except(['_token'])
                                ]);

                                $year = date('Y', strtotime($newDate));
                                $student = new User();
                                $dataStudent = $request->except('_token');
                                $dataStudent = $request->only(['role_id', 'firstname', 'lastname']);
                                ;
                                $dataStudent['year_of_birth'] = $year;
                                $dataStudent['first_name'] = $Child['Childfirstname'];
                                $dataStudent['last_name'] = $Child['Childlastname'];
                                $dataStudent['role_id'] = 4;
                                $student = $student->create($dataStudent);
                                $parent = new ParentStudent();
                                $dataParent = $request->only(['parent_id', 'child_id']);
                                $dataParent['parent_id'] = Auth::user()['id'];
                                $dataParent['child_id'] = $student['id'];
                                $parent = $parent->create($dataParent);
                            }
                            $date = \Carbon\Carbon::today();
                            $response = $client->request('get', $profileUrl . '/' . $membersonCustNumber . '/contact-persons', ['headers' => [
                                    'Accept' => 'application/json',
                                    'SvcAuth' => $SvcAuthToken,
                                    'Token' => $svcToken,
                                    'ProfileToken' => $profileToken,
                                // 'Content-Type' => 'application/json',
                                ],
                            ]);
                            $families = json_decode((string) $response->getBody()->getContents());


                            $dOB = array();
                            foreach ($families as $family) {
                                $dateOfBirth = date('d-m-Y', strtotime($family->DOB));
                                $years = \Carbon\Carbon::parse($dateOfBirth)->age;
                                $dOB[] = $dateOfBirth;
                            }

                            usort($dOB, function($a, $b) {
                                $dateTimestamp1 = strtotime($a);
                                $dateTimestamp2 = strtotime($b);

                                return $dateTimestamp1 < $dateTimestamp2 ? -1 : 1;
                            });
                            $youngerChild = $dOB[count($dOB) - 1];

                            $carbon = \Carbon\Carbon::parse($youngerChild);
                            $expireDate = date('Y-m-d', strtotime($carbon->addYear(12)));
                            $expireFormatDate = \Carbon\Carbon::parse($expireDate)->addDays(1);
                            $newDateFormat = $date->format('Y-m-d');
                            $newExpireDate = $expireFormatDate . 'T23:59:59+08:00';
                            $newValdidFrom = $newDateFormat . 'T00:00:00+08:00';
                            try {
                                $response = $client->request('POST', $benefitIssue, ['headers' => [
                                        'Accept' => 'application/json',
                                        'SvcAuth' => $SvcAuthToken,
                                        'Token' => $svcToken,
                                        'ProfileToken' => $profileToken,
                                    // 'Content-Type' => 'application/json',
                                    ],
                                    \GuzzleHttp\RequestOptions::JSON => [
                                        'MemberNumber' => $memberNo,
                                        'BenefitCode' => 'GPE',
                                        'Description' => '',
                                        'LocationCode' => "LKIDSCLUBWEB",
                                        'Registrator' => "TRINAXWEB",
                                        'Amount' => 100,
                                        'ValidFrom' => $newValdidFrom,
                                        'ExpiryDate' => $newExpireDate,
                                    ]//$request->except(['_token'])
                                ]);

                                $response = ['message' => "success"];
                                return response($response, 200);
//                                    dd($response);
                            } catch (\Exception $e) {
                                $message = $e->getMessage();
                                return response($message, 500);
                            }
                        } catch (\Exception $e) {
                            $message = $e->getMessage();
                            return response($message, 500);
                        }
                    } catch (\Exception $e) {
                        $message = $e->getMessage();
                        return response($message, 500);
                    }
                } catch (\Exception $e) {
                    $message = $e->getMessage();
                    return response($message, 500);
                }
            } else {
                $response = ['message' => $data->response->message];
                return response($response, 500);
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response($message, 500);
        }
    }

    public function adminLogin() {
        if (Auth::guest()) {
            return view('login');
        } else {
            return redirect('/');
        }
    }

    /**
     * Autheticates a user and redirect to home page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {

        $request->validate([
            'username' => 'required|string|exists:users,username',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();
        if ($user->isAdmin()) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return redirect()->route('admin.dashboard');
            } else {
                session()->flash('error', 'Incorrect password');
            }
        } else {
            session()->flash('error', 'Incorrect password Email password');
        }

        return redirect()->back();
    }

    /**
     * Logout an authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {
        Auth::logout();
        session()->flash('success', 'Successfully logged out');
        return redirect('/');
    }

}
