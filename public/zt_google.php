<?php header('Access-Control-Allow-Origin: *');

$curl = curl_init("https://www.google.com/");
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	 'Accept:application/json',
               'SvcAuth:VFJJTkFY,b2NnWEplU1FONlpxdjJkbg=='
));
    curl_exec ($curl);
   // Check if any error occurred
   curl_close($curl);
if(!curl_errno($curl))
{
 $info = curl_getinfo($curl);

 echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'];
}


echo 'tdddddddddddddddddddddddddddddddddddeeeeef';

?>
