<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Helper;

class ImageUpload extends Model
{
    use HasFactory;
    public static function upload( $imagedata,$filename = '' )
    {
            $file=$imagedata;
            $file_name = str_replace(" ", "-", $file->getClientOriginalName());
            $file_arr  = Helper::upload_file($file_name,$filename);
            $file->move($file_arr['path'], $file_arr['file_name']);
            $image_path    = $file_arr['db_path'];

            return $image_path;
    }

}
