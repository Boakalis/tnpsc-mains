<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Helper;
use App\MediaManager;
use Auth;

class HelperController extends Controller
{
    public function fileUploadEditor()
    {

        reset($_FILES);
        $temp = current($_FILES);

        if ($temp['size'] > 10485760)
        { // 10 MB (this size is in bytes)
            return json_encode(['File exceeds limit of 10mb']);
        }

        // Accept upload if there was no origin, or if it is an accepted origin
        $file_name = $temp['name'];

        $file_arr = Helper::upload_file($file_name);

        $file_path = $file_arr['path'] . '/' . $file_arr['file_name'];

        move_uploaded_file($temp['tmp_name'], $file_path);

        $path = url('/') . '/' . $file_arr['db_path'];

        return json_encode(['location' => $path]);
    }

    public function fileUploadDropBoxEditor(Request $request)
    {
        $type = request('type');

        if ($request['file'] != null && $request->has('file'))
        {
            $file_name = str_replace(" ", "-", $request
                ->file
                ->getClientOriginalName());
            $file_arr = Helper::upload_file($file_name, 'service_gallery_image');
            $request
                ->file
                ->move($file_arr['path'], $file_arr['file_name']);
            $media = ['type' => $type, 'image_path' => $file_arr['db_path'], 'image_name' => $file_arr['file_name'], 'created_by' => Auth::User()->id];
            MediaManager::create($media);
        }

        return \response()->json(['status' => 200, 'message' => 'Media Uploaded Successfully']);
    }

    public function getMediaGallery(Request $request)
    {
        $type = (request('type') != null) ? request('type') : 1;
        $datas = MediaManager::where('type', $type)->get();
        $html = view('admin.media.gallery', compact('datas', 'type'))->render();
        return response()
            ->json(['status' => 200, 'message' => 'Gallery Fetched Successfully', 'html' => $html]);
    }



}

