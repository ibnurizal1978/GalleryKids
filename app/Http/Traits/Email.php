<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;
use \App\User;
trait Email {

    //Admin work publish
    public function sendEmail($title,$image,$description) {
      
       $users = User::whereSubscribe(1)->get();
       foreach($users as $user){
        $email = $user['email'];
        $data = ['data' => (object) ['email' => $email,'title' => $title,'image' => $image,'description' => $description]];
        \Mail::send('adminActivity', $data, function ($m) use ($email) {
            $m->to($email)->subject('A new content has been added on GalleryKids!');
        });
       }
    }

}
