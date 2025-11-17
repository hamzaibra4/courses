<?php

namespace App\Http\Controllers;

use App\Models\DTO;
use Illuminate\Http\Request;
use Pusher\Pusher;
class GenericController extends Controller
{
    public function uploadImage($request, $imageName)
    {
        $imagePath=false;

        if ($request->hasFile($imageName)) {
            $file = $request->file($imageName);
            $fileNameWithExt = $file->getClientOriginalName();
            error_log("----------------" . $fileNameWithExt);
            $fileNameWithExt = str_replace(' ', '', $fileNameWithExt);
            if (strpos($fileNameWithExt, '(') !== false || strpos($fileNameWithExt, ')') !== false) {
                $fileNameWithExt = str_replace(['(', ')'], '', $fileNameWithExt);
            }
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $file->storeAs('public/images', $fileNameToStore,'public');
            $imagePath = 'storage/public/images/' . $fileNameToStore;
        }
        return $imagePath;
    }

    public function uploadImages($request, $imageName)
    {
        $imagePaths = []; // Array to store the paths of uploaded images

        if ($request->hasFile($imageName)) {
            $files = $request->file($imageName); // Retrieve all files

            foreach ($files as $file) {
                $fileNameWithExt = $file->getClientOriginalName();
                $fileNameWithExt = str_replace(' ', '', $fileNameWithExt);
                if (strpos($fileNameWithExt, '(') !== false || strpos($fileNameWithExt, ')') !== false) {
                    $fileNameWithExt = str_replace(['(', ')'], '', $fileNameWithExt);
                }
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
                $file->storeAs('public/images', $fileNameToStore, 'public');
                $imagePaths[] = 'storage/public/images/' . $fileNameToStore;
            }
        }
        return $imagePaths; // Return array of image paths
    }


    public function sendNotification($chanel, $event,DTO $dto){
        $options = array(
            'cluster' => 'mt1',
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $pusher->trigger($chanel,$event,$dto);
    }

}
