<?php

		 $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://ngssgproxy.memgate.com/api/user/authenticate', ['headers' => [
                'Accept' => 'application/json',
                'SvcAuth' => 'VFJJTkFY,b2NnWEplU1FONlpxdjJkbg==',
            ],
            \GuzzleHttp\RequestOptions::JSON => ['username' => "TRINAX",
                'password' => "YFMh7tcCBqQE"]//$request->except(['_token'])
        ]);
		if ($curl_response === false) {
		$info = curl_getinfo($curl);
		curl_close($curl);
		die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
        //dd($response);
         
    

}
