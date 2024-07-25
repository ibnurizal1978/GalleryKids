<?php header('Access-Control-Allow-Origin: *');


$post = array(
    'username' => 'TRINAX',
    'password' => 'YFMh7tcCBqQE'
);
$payload = json_encode($post);
$curl = curl_init("https://ngssgproxy.memgate.com/api/user/authenticate");
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	 'Accept:application/json',
	 'Content-Type:application/json',
               'SvcAuth:VFJJTkFY,b2NnWEplU1FONlpxdjJkbg=='
));

curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);

   $result= curl_exec ($curl);
   // Check if any error occurred
 print_r ($result);
if(!curl_errno($curl))
{
 $info = curl_getinfo($curl);

 echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'];
}

curl_close($curl);


?>
