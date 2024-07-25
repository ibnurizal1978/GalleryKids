<?php

namespace App\Http\Traits;

use \App\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use Modules\User\Entities\ParentStudent;
use Illuminate\Http\Request;

trait Api {

    private $token = "http://explorercms.nationalgallery.sg/api/ngstoken";
    private $login = "https://explorercms.nationalgallery.sg/api2/user/login";
    private $register = "https://explorercms.nationalgallery.sg/api2/user/add";
    private $userAuthentication = "https://ngssgproxy.memgate.com/api/user/authenticate";
    private $svgToken = "https://ngssgproxy.memgate.com/api/user/authenticate";
    private $getMember = "https://ngssgproxy.memgate.com/api/profile";
    private $upgradeMemberUrl = "https://ngssgproxy.memgate.com/api/member/";
    private $profileUrl = "https://ngssgproxy.memgate.com/api/profile/";
    private $forgetUrl = "https://explorercms.nationalgallery.sg/api2/user/pwdresetrequest";
    private $rewardsPoint = "http://explorercms.nationalgallery.sg/api/ngstoken";
    private $contactPerson = "https://ngssgproxy.memgate.com/api/profile/";
    private $benefitIssue = "https://ngssgproxy.memgate.com/api/benefit/issue";
    private $benefitUpdate = "https://ngssgproxy.memgate.com/api/benefit";

    public function setToken($token, $login, $register) {
        $this->token = $token;
        $this->login = $login;
        $this->register = $register;
        $this->userAuthentication = $userAuthentication;
        $this->svgToken = $svgToken;
        $this->getMember = $getMember;
        $this->upgradeMemberUrl = $upgradeMemberUrl;
        $this->benefitUpdate = $benefitUpdate;
        $this->profileUrl = $profileUrl;
        $this->forgetUrl = $forgetUrl;
        $this->rewardsPoint = $rewardsPoint;
        $this->contactPerson = $contactPerson;
        $this->benefitIssue = $benefitIssue;
    }

    public function getToken() {

        return [$this->token, $this->login, $this->register, $this->userAuthentication
            , $this->svgToken, $this->getMember, $this->upgradeMemberUrl
            , $this->profileUrl, $this->forgetUrl, $this->rewardsPoint,
            $this->contactPerson, $this->benefitIssue, $this->benefitUpdate];
    }

//    Token Api

    public function tokenApi() {
        $tokenUrl = $this->token;
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
        return $token;
    }

    //    svc Token Api

    public function svcTokenApi() {
        $svcTokenUrl = $this->svgToken;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $svcTokenUrl, ['headers' => [
                'Accept' => 'application/json',
                'SvcAuth' => 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==',
            ],
            \GuzzleHttp\RequestOptions::JSON => ['username' => "TRINAX",
                'password' => "YFMh7tcCBqQE"]//$request->except(['_token'])
        ]);
        $data = json_decode((string) $response->getBody()->getContents());
        $svcToken = $data;
        return $svcToken;
    }

    public function getProfile($membersonCustNumber, $svcToken, $profileToken) {
        $profileUrl = $this->profileUrl;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('Get', $profileUrl . $membersonCustNumber, ['headers' => [
                'Accept' => 'application/json',
                'SvcAuth' => 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==',
                'Token' => $svcToken,
                'ProfileToken' => $profileToken,
            // 'Content-Type' => 'application/json',
            ],
        ]);

        $data = json_decode((string) $response->getBody()->getContents());
        return $data;
    }

    public function updateProfile($membersonCustNumber, $svcToken, $profileToken, $profileData, $firstname, $lastname, $gender, $datetime) {
        $profileUrl = $this->profileUrl;
        $client = new \GuzzleHttp\Client();

        $response = $client->request('PUT', $profileUrl . $membersonCustNumber, ['headers' => [
                'Accept' => 'application/json',
                'SvcAuth' => 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==',
                'Token' => $svcToken,
                'ProfileToken' => $profileToken,
            // 'Content-Type' => 'application/json',
            ],
            \GuzzleHttp\RequestOptions::JSON => ['FirstName' => $firstname,
                'LastName' => $lastname,
                'DefaultAddressType' => 'HOME',
                'GenderCode' => $gender,
                'DOB' => $datetime,
                'Addresses' => $profileData->Addresses,
                'Phones' => $profileData->Phones,
                'Interests' => $profileData->Interests,
                'ContactPreferences' => $profileData->ContactPreferences,
                'CustomProperties' => $profileData->CustomProperties,
                'ContactPersons' => $profileData->ContactPersons]
        ]);

        $data = json_decode((string) $response->getBody()->getContents());
        return $data;
    }

    public function addFamiliy($request, $Childs, $membersonCustNumber, $svcToken, $profileToken) {
        $contactPerson = $this->contactPerson;
        $client = new \GuzzleHttp\Client();
        foreach ($Childs as $Child) {
            $date = \Carbon\Carbon::createFromFormat('d/m/Y', $Child['Childdate']);
            $newDate = \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');
            $childDob = date("c", strtotime($newDate));
            $response = $client->request('POST', $contactPerson . $membersonCustNumber . '/contact-persons/add', ['headers' => [
                    'Accept' => 'application/json',
                    'SvcAuth' => 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==',
                    'Token' => $svcToken,
                    'ProfileToken' => $profileToken,
                // 'Content-Type' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'Type' => "CHILD",
                    'FirstName' => $Child['Childfirstname'],
                    'LastName' => $Child['Childlastname'],
                    'IC' => "K0000091335",
                    'DOB' => $childDob,
                    'Gender' => "M"]//$request->except(['_token'])
            ]);
            $student = new User();
            $dataStudent = $request->only(['password', 'role_id', 'firstname', 'lastname']);
            $dataStudent['password'] = bcrypt($request['password']);
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
    }

    public function getFamily($Childs, $membersonCustNumber, $svcToken, $profileToken) {
        $contactPerson = $this->contactPerson;
        $date = \Carbon\Carbon::today();
        $client = new \GuzzleHttp\Client();
        $response = $client->request('get', $contactPerson . $membersonCustNumber . '/contact-persons', ['headers' => [
                'Accept' => 'application/json',
                'SvcAuth' => 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==',
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
        $expireDate = date('Y-m-d H:i:s', strtotime($carbon->addYear(12)));
        return $expireDate;
    }

    public function benefitIssue($newMemberNo, $svcToken, $profileToken, $date, $expireDate) {
        $benefitIssue = $this->benefitIssue;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $benefitIssue, ['headers' => [
                'Accept' => 'application/json',
                'SvcAuth' => 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==',
                'Token' => $svcToken,
                'ProfileToken' => $profileToken,
            // 'Content-Type' => 'application/json',
            ],
            \GuzzleHttp\RequestOptions::JSON => [
                'MemberNumber' => $newMemberNo,
                'BenefitCode' => 'GPE',
                'Description' => 'Benefit Description',
                'LocationCode' => "LWEB",
                'Registrator' => "TRINAXWEB",
                'Amount' => 100,
                'ValidFrom' => date("c", strtotime($date)),
                'ExpiryDate' => date("c", strtotime($expireDate)),
            ]//$request->except(['_token'])
        ]);


        $response = ['message' => "success"];
        return "success";
    }

    public function UpgradeMember($memberNo, $svcToken, $profileToken) {
        $upgradeMemberUrl = $this->upgradeMemberUrl;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $upgradeMemberUrl . $memberNo . '/Upgrade', ['headers' => [
                'Accept' => 'application/json',
                'SvcAuth' => 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==',
                'Token' => $svcToken,
                'ProfileToken' => $profileToken,
            // 'Content-Type' => 'application/json',
            ],
            \GuzzleHttp\RequestOptions::JSON => ['StartDate' => "2020-08-01T21:40:25+08:00",
                'TargerMembershipType' => "Gallery Parent Explorer",
                'LocationCode' => "LWEB",
                'Registrator' => "TRINAXWEB",
                'SalesPerson' => "TRINAXWEB",
                'Amount' => 0,
                'Currency' => "SGD",
                'ReceiptNumber' => "Receipt1234",
                'Description' => "Upgrade description"]//$request->except(['_token'])
        ]);
        $newMember = json_decode((string) $response->getBody()->getContents());
        $newMemberNo = $newMember->NewMemberNumber;
        return $newMemberNo;
    }

    public function benefitCode($memberNo, $svcToken, $profileToken) {
        $upgradeMemberUrl = $this->upgradeMemberUrl;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $upgradeMemberUrl . '/' . $memberNo . '/benefits?benefitCode=GPE', ['headers' => [
                'Accept' => 'application/json',
                'SvcAuth' => 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==',
                'Token' => $svcToken,
                'ProfileToken' => $profileToken,
            ],
        ]);
        $data = json_decode((string) $response->getBody()->getContents());
        return $data;
    }

    public function updateBenefitCode($memberNo, $svcToken, $profileToken, $Identifier, $expireDate) {
     
        $date = \Carbon\Carbon::today();
       
        $benefitUpdate = $this->benefitUpdate;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $benefitUpdate . '/' . $Identifier, ['headers' => [
                'Accept' => 'application/json',
                'SvcAuth' => 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==',
                'Token' => $svcToken,
                'ProfileToken' => $profileToken,
            ],
            \GuzzleHttp\RequestOptions::JSON => ["Amount" => 100,
                "ValidFrom" => date("c", strtotime($date)),
                "ExpiryDate" => date("c", strtotime($expireDate)),
                "Description" => "Benefit Description",
                "Status" => "ACTIVE"]
        ]);
        $data = json_decode((string) $response->getBody()->getContents());
       
        return $data;
    }

    //    svc Token Api

    public function summeryApi($membersonCustNumber, $svcToken, $profileToken) {
        $getMember = $this->getMember;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $getMember . '/' . $membersonCustNumber . '/summary', ['headers' => [
                'Accept' => 'application/json',
                'SvcAuth' => 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==',
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
        return [$Type, $Tier, $Status];
    }

    //    Login Step One Api

    public function loginStepOneApi($token, $email, $password) {
        $client = new \GuzzleHttp\Client();
        $loginUrl = $this->login;

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

            $svcToken = $this->svcTokenApi();
            $summery = $this->summeryApi($membersonCustNumber, $svcToken, $profileToken);


            if ($summery[0] == 'Gallery Parent Explorer') {
                $benefit = $this->benefitCode($memberNo, $svcToken, $profileToken);
                $benifitStatus = '';
                foreach ($benefit as $value) {
                    $benifitStatus = $value->Status;
                }

                if ($benifitStatus == 'CREATED') {
                    $user = User::where('email', $email)->first();
                    if (Hash::check($password, $user->password)) {
                        Auth::login($user);
                        $user['membersonCustNumber'] = $membersonCustNumber;
                        $user['profileToken'] = $profileToken;
                        $user['memberNo'] = $memberNo;
                        $user['visit'] = $user['visit'] + 1;
                        $user['date'] = \Carbon\Carbon::now();
                        $user->save();
                    } else {
                        Auth::login($user);
                        $user['membersonCustNumber'] = $membersonCustNumber;
                        $user['profileToken'] = $profileToken;
                        $user['memberNo'] = $memberNo;
                        $user['visit'] = $user['visit'] + 1;
                        $user['date'] = \Carbon\Carbon::now();
                        $user['password'] = bcrypt($request['password']);
                        $user->save();
                        $childrens = $user->children;
                        foreach ($childrens as $children) {
                            $childrenData = User::find($children['id']);
                            $childrenData['password'] = bcrypt($request['password']);
                            $childrenData->save();
                        }
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
            }
        } else {
            $response = ['message' => $data->response->message];
            return response($response, 500);
        }
    }

    //    Login Step Two Api

    public function loginStepTwoApi($token, $email, $password, $Childs) {
        $client = new \GuzzleHttp\Client();
        $loginUrl = $this->login;

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


            $svcToken = $this->svcTokenApi();
            $summery = $this->summeryApi($membersonCustNumber, $svcToken, $profileToken);
            $upgradeMember = $this->UpgradeMember($memberNo, $svcToken, $profileToken);

            $date = \Carbon\Carbon::today();
            $user = User::where('email', $request->email)->first();
            if (Hash::check($password, $user->password)) {
                Auth::login($user);
                $user['membersonCustNumber'] = $membersonCustNumber;
                $user['profileToken'] = $profileToken;
                $user['memberNo'] = $newMemberNo;
                $user['visit'] = $user['visit'] + 1;
                $user['date'] = \Carbon\Carbon::now();
                $user->save();
                $response = ['message' => 'Success'];
                return response($response, 200);
            } else {
                Auth::login($user);
                $user['membersonCustNumber'] = $membersonCustNumber;
                $user['profileToken'] = $profileToken;
                $user['memberNo'] = $memberNo;
                $user['visit'] = $user['visit'] + 1;
                $user['date'] = \Carbon\Carbon::now();
                $user['password'] = bcrypt($request['password']);
                $user->save();
                $childrens = $user->children;
                foreach ($childrens as $children) {
                    $childrenData = User::find($children['id']);
                    $childrenData['password'] = bcrypt($request['password']);
                    $childrenData->save();
                }
            }
        } else {
            $response = ['message' => $data->response->message];
            return response($response, 500);
        }
    }

    public function registrationApi($request, $firstname, $lastname, $email, $password, $country, $subscribe, $mobile, $gender, $date, $Childs) {
        $token = $this->tokenApi();
        $datetime = date("c", strtotime($date));
        $registerUrl = $this->register;

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $registerUrl, ['headers' => [
                'Accept' => 'application/json',
                'Authorization' => $token,
            ],
            \GuzzleHttp\RequestOptions::JSON => ['email' => $email,
                'firstName' => $firstname,
                'isEmailUser' => '1',
                'lastName' => $lastname,
                'locationCode' => "LKIDSCLUBWEB",
                'password' => $password,
                'subscribeStatus' => 1]
        ]);
        $data = json_decode((string) $response->getBody()->getContents());

        if ($data->result == 'success') {
            $registerResponse = json_decode((string) $response->getBody());
            $membersonCustNumber = $registerResponse->response->membersonCustNumber;
            $profileToken = $registerResponse->response->profileToken;
            $memberNo = $registerResponse->response->memberNo;
            $svcToken = $this->svcTokenApi();

            $profileData = $this->getProfile($membersonCustNumber, $svcToken, $profileToken);

            $profileUpdate = $this->updateProfile($membersonCustNumber, $svcToken, $profileToken, $profileData, $firstname, $lastname, $gender, $datetime);
            $newMemberNo = $this->UpgradeMember($memberNo, $svcToken, $profileToken);
            $user = new User();
            $data = $request->only(['email', 'password', 'role_id', 'firstname', 'lastname', 'subscribe']);
            $data['password'] = bcrypt($password);
            $data['email'] = $data['email'];
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
            $userLogin['date'] = \Carbon\Carbon::now();
            $userLogin->save();
            $email = 'nehashr4911@gmail.com';
            $data = ['data' => (object) ['email' => $email]];
            \Mail::send('reg_mail', $data, function ($m) use ($email) {
                $m->to($email)->subject('Registration');
            });
            $addFamiliy = $this->addFamiliy($request, $Childs, $membersonCustNumber, $svcToken, $profileToken);

            $getFamily = $this->getFamily($Childs, $membersonCustNumber, $svcToken, $profileToken);
            $expireDate = $getFamily;
            $benefitIssue = $this->benefitIssue($newMemberNo, $svcToken, $profileToken, $date, $expireDate);
            return $benefitIssue;
        } else {
            $response = ['message' => $data->response->message];
            return $response;
        }
    }

}
