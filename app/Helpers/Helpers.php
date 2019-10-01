<?php

namespace App\Helpers;

class Helpers {

    public static function handle_upload_request_image($image){
        if($image):
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            return $imageName;
        endif;
    }

}