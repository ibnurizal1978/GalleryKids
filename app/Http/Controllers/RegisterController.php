<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClassUserRequest;
use App\Http\Requests\StoreFamilyUserRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\FileUpload;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Mail\SendOtp;
use App\Imports\StudentsImport;
use App\User;
use App\Import;
use Auth;
use Session;
use Excel;
use Validator;
use Modules\User\Entities\ParentStudent;

class RegisterController extends Controller {

    use FileUpload;

    /**
     * Displays registration form for class.
     *
     * @return \Illuminate\Http\Response
     */
//    public function registerPageClass() {
//        return view('register_class');
//    }

    /**
     * user forget password .
     *
     */
    public function ForgetPassword(Request $request) {
        $request->validate([
            'email' => 'required',
        ]);
        $email = $request['email'];
        //        production api
//        $tokenUrl = "https://explorercms.nationalgallery.sg/app/api/ngstoken";
//        $fogetUrl = "https://explorercms.nationalgallery.sg/api2/user/pwdresetrequest";
//
        //        staging api
        $tokenUrl = "http://sng-test.elasticbeanstalk.com/api/ngstoken";
        $fogetUrl = "https://hzmmhfacy4.execute-api.ap-southeast-1.amazonaws.com/dev/user/pwdresetrequest";

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
            $response = $client->request('get', $fogetUrl . '?email=' . $email, ['headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $token,
                // 'Content-Type' => 'application/json',
                ],
            ]);
            $data = json_decode((string) $response->getBody()->getContents());

            if ($data->result == 'success') {
                $response = ['message' => 'Please check your mail'];
                return response($response, 200);
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
     * user registration .
     *
     *///    09-Dec-20 Change icNumber
    //    03-Dec-20 icNumber ,DOB format,Moblie Number ,Phone
    //    09-Dec-20 add one days for expire date
    //    09-Dec-20 new data editing in put api
    public function newRegister(Request $request) {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'password' => 'required',
            'country' => 'required',
        ]);
        $firstname = $request['firstname'];
        $lastname = $request['lastname'];
        $email = $request['email'];
        $password = $request['password'];
        $country = $request['country'];
        $subscribe = $request['subscribe'];
        $mobile = $request['mobile'];
        $gender = $request['gender'];
        $date = $request['date'];
        $parentDate = $request['date'];
        $Childs = $request['ChildData'];
//        $pass = rand(100000, 999999);
//        $icNumber = 'K00' . $pass;
//        production api
//        $tokenUrl = "https://explorercms.nationalgallery.sg/app/api/ngstoken";
//        $registerUrl = "https://explorercms.nationalgallery.sg/api2/user/add";
//        $svcTokenUrl = "https://ngssgproxy.memgate.com/api/user/authenticate";
//        $profileUrl = "https://ngssgproxy.memgate.com/api/profile/";
//        $upgradeMemberUrl = "https://ngssgproxy.memgate.com/api/member/";
//        $benefitIssue = "https://ngssgproxy.memgate.com/api/benefit/issue";
//        $SvcAuthUserName = "TRINAX";
//        $SvcAuthPassword = "YFMh7tcCBqQE";
//        $SvcAuthToken = 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==';
        //        staging api

        $tokenUrl = "http://sng-test.elasticbeanstalk.com/api/ngstoken";
        $registerUrl = "https://hzmmhfacy4.execute-api.ap-southeast-1.amazonaws.com/dev/user/add";
        $svcTokenUrl = "https://ngssgproxyuat.memgate.com/api/user/authenticate";
        $profileUrl = "https://ngssgproxyuat.memgate.com/api/profile/";
        $upgradeMemberUrl = "https://ngssgproxyuat.memgate.com/api/member/";
        $benefitIssue = "https://ngssgproxyuat.memgate.com/api/benefit/issue";
        $SvcAuthUserName = "TRINAX";
        $SvcAuthPassword = "LFy4cUD6E3Gu";
        $SvcAuthToken = 'VFJJTkFY,VkEyOFloSjlDd3lCWmRLVA==';


        $start_new_date = \Carbon\Carbon::now();
        $StartDate = date("c", strtotime($start_new_date));
        $client = new \GuzzleHttp\Client();
        $ReceiptNumber = uniqid();
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
            $response = $client->request('POST', $registerUrl, ['headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $token,
                // 'Content-Type' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::JSON => ['email' => $email,
                    'firstName' => $firstname,
                    'isEmailUser' => '1',
                    'lastName' => $lastname,
                    'locationCode' => "LKIDSCLUBWEB",
                    'password' => $password,
                    'subscribeStatus' => 1]//$request->except(['_token'])
            ]);
            $data = json_decode((string) $response->getBody()->getContents());
            if ($data->result == 'success') {
                $registerResponse = json_decode((string) $response->getBody());
                $membersonCustNumber = $registerResponse->response->membersonCustNumber;
                $profileToken = $registerResponse->response->profileToken;
                $memberNo = $registerResponse->response->memberNo;

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

                        $datetime = date("c", strtotime($date));

                        $response = $client->request('Get', $profileUrl . $membersonCustNumber, ['headers' => [
                                'Accept' => 'application/json',
                                'SvcAuth' => $SvcAuthToken,
                                'Token' => $svcToken,
                                'ProfileToken' => $profileToken,
                            // 'Content-Type' => 'application/json',
                            ],
                        ]);
                        $datetime = date("c", strtotime($date));

                        $response = $client->request('get', $profileUrl . $membersonCustNumber, ['headers' => [
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
//                        $DOB = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parentDate)->format('Y-m-d');
//                        dd($parentDate);
//                        $newDateFormat = $parentDate->format('Y-m-d');
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
                        $parentDob = $parentDate . 'T00:00:00+08:00';
//                        dd($parentDob);
                        // dd($profileData);
                        $response = $client->request('PUT', $profileUrl . $membersonCustNumber, ['headers' => [
                                'Accept' => 'application/json',
                                'SvcAuth' => $SvcAuthToken,
                                'Token' => $svcToken,
                                'ProfileToken' => $profileToken,
                            // 'Content-Type' => 'application/json',
                            ],

                            \GuzzleHttp\RequestOptions::JSON => ['FirstName' => $firstname,
                                'LastName' => $lastname,
                                'DefaultAddressType' => 'HOME',
                                'CustomerNumber' => $profileData->CustomerNumber,
                                'Title' => $profileData->Title,
                                'IC' => $profileData->IC,
                                'JoinDate' => $profileData->JoinDate,
                                'NationalityCode' => $country,
                                'Remark' => $profileData->Remark,
                                'NickName' => $profileData->NickName,
                                'GenderCode' => $gender,
                                'DOB' => $parentDob,
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
                            $year = date('Y', strtotime($date));
                            $user = new User();
                            $data = $request->only(['email', 'date', 'role_id', 'firstname', 'lastname', 'subscribe']);
                            $data['email'] = $data['email'];
                            $data['year_of_birth'] = $year;
                            $data['username'] = $data['email'];
                            $data['first_name'] = $data['firstname'];
                            if ($subscribe == 'on') {
                                $data['subscribe'] = 1;
                            } else {
                                $data['subscribe'] = 0;
                            }

                            $data['last_name'] = $data['lastname'];
                            $data['membersonCustNumber'] = $membersonCustNumber;
                            $data['profileToken'] = $profileToken;
                            $data['memberNo'] = $newMemberNo;
                            $data['role_id'] = 3;
                            $user = $user->create($data);

                            $userLogin = User::where('email', $data['email'])->first();
                            Auth::login($userLogin);
                            $userLogin['membersonCustNumber'] = $membersonCustNumber;
                            $userLogin['profileToken'] = $profileToken;
                            $userLogin['memberNo'] = $newMemberNo;
                            $userLogin['visit'] = $user['visit'] + 1;
                            $userLogin['date'] = \Carbon\Carbon::now();
                            $userLogin->save();
                            $email = Auth::user()['email'];
                            //registraion mail
                            $data = ['data' => (object) ['email' => $email]];
                            \Mail::send('reg_mail', $data, function ($m) use ($email) {
                                $m->to($email)->subject('Welcome to GalleryKids!');
                            });
                            \Mail::send('badgeTemplate', $data, function ($m) use ($email) {
                                $m->to($email)->subject('Welcome to GalleryKids!');
                            });
//
                            try {

                                foreach ($Childs as $Child) {
                                    $pass = rand(100000, 999999);
                                    $icNumber = 'K00' . $pass;
                                    $date = \Carbon\Carbon::createFromFormat('d/m/Y', $Child['Childdate']);
                                    $newDate = \Carbon\Carbon::parse($date)->format('Y-m-d');
                                    $childDob = $newDate . 'T00:00:00+08:00';
//                                    $childDob = date("c", strtotime($newDate));
                                    $response = $client->request('POST', $profileUrl . $membersonCustNumber . '/contact-persons/add', ['headers' => [
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
                                    $dataStudent['last_name'] = $Child['Childlastname'];
                                    $dataStudent['year_of_birth'] = $year;
                                    $dataStudent['role_id'] = 4;
                                    $student = $student->create($dataStudent);
                                    $parent = new ParentStudent();
                                    $dataParent = $request->only(['parent_id', 'child_id']);
                                    $dataParent['parent_id'] = Auth::user()['id'];
                                    $dataParent['child_id'] = $student['id'];
                                    $parent = $parent->create($dataParent);
                                }
                                $date = \Carbon\Carbon::today();
                                $response = $client->request('get', $profileUrl . $membersonCustNumber . '/contact-persons', ['headers' => [
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
//                               return response([$newExpireDate,$families], 500);
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
     * Resend otp to user's mail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resendOtp(Request $request) {
        $request->validate([
            'token' => 'required|string',
        ]);

        $data['otp'] = rand(10000, 99999);
        $user = User::where('hash', $request->token)->first();
        if ($user) {
            $user->update($data);
            $message = "Your otp is " . $data['otp'];
            Mail::to($user->email)->send(new SendOtp($message));
            session()->flash('success', 'A new OTP has been sent to your mail');
        } else {
            session()->flash('error', 'Invalid token');
        }
        return redirect()->back();
    }

    /**
     * Verify OTP Form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyOtpPage(Request $request) {
        $request->validate([
            'token' => 'required|string|exists:users,hash',
        ]);

        $token = $request->token;

        return view('verify_otp', compact('token'));
    }

    /**
     * Verify OTP and login users
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyOtp(Request $request) {
        $request->validate([
            'otp' => 'required|string|exists:users,otp',
            'token' => 'required|string|exists:users,hash',
        ]);

        $user = User::where('hash', $request->token)->first();

        $data['email_verified_at'] = date('Y-m-d H:i');
        $data['status'] = 'Enable';

        if ($user->email_verified_at) {
            session()->flash('error', 'Your account already verified');
            return redirect()->back();
        }

        if ($user->otp == $request->otp) {
            $parent_ids = $user->children->first()->parents->pluck('id')->toArray();
            $children_ids = $user->children->pluck('id')->toArray();
            User::whereIn('id', array_merge($parent_ids, $children_ids))->update($data);
            session()->flash('success', 'Your account verified successfully');
            Auth::login($user);
            return redirect()->route('home');
        } else {
            session()->flash('error', 'Invalid OTP');
            return redirect()->back();
        }
    }

    /**
     * Displays home page
     *
     * @return \Illuminate\Http\Response
     */
    public function home() {
        return view('home');
    }

}
