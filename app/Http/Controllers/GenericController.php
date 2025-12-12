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
    public function uploadVideo($request, $videoName)
    {
        $videoPath = false;

        if ($request->hasFile($videoName)) {
            $file = $request->file($videoName);

            // Optional: Validate video file type
            $allowedExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, $allowedExtensions)) {
                return false; // or throw an exception
            }

            $fileNameWithExt = $file->getClientOriginalName();
            error_log("----------------" . $fileNameWithExt);
            $fileNameWithExt = str_replace(' ', '', $fileNameWithExt);

            if (strpos($fileNameWithExt, '(') !== false || strpos($fileNameWithExt, ')') !== false) {
                $fileNameWithExt = str_replace(['(', ')'], '', $fileNameWithExt);
            }

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

            // Store in videos directory instead of images
            $file->storeAs('public/videos', $fileNameToStore, 'public');
            $videoPath = 'storage/public/videos/' . $fileNameToStore;
        }

        return $videoPath;
    }

    public function uploadPdfs($request, $pdfName)
    {
        $pdfPaths = []; // Array to store the paths of uploaded PDFs

        if ($request->hasFile($pdfName)) {
            $files = $request->file($pdfName); // Retrieve all files

            foreach ($files as $file) {
                // Optional: Validate PDF file type
                $extension = strtolower($file->getClientOriginalExtension());

                if ($extension !== 'pdf') {
                    continue; // Skip non-PDF files
                }

                $fileNameWithExt = $file->getClientOriginalName();
                $fileNameWithExt = str_replace(' ', '', $fileNameWithExt);

                if (strpos($fileNameWithExt, '(') !== false || strpos($fileNameWithExt, ')') !== false) {
                    $fileNameWithExt = str_replace(['(', ')'], '', $fileNameWithExt);
                }

                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $fileNameToStore = $fileName . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension;

                // Store in pdfs directory
                $file->storeAs('public/pdfs', $fileNameToStore, 'public');
                $pdfPaths[] = 'storage/public/pdfs/' . $fileNameToStore;
            }
        }
        return $pdfPaths; // Return array of PDF paths
    }


    public function uploadPdfsWithNames($request, $pdfName)
    {
        $pdfs = [];

        if ($request->hasFile($pdfName)) {
            $files = $request->file($pdfName);

            foreach ($files as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                if ($extension !== 'pdf') {
                    continue;
                }

                $originalName = $file->getClientOriginalName();
                $cleanName = str_replace([' ', '(', ')'], '', $originalName);

                $nameWithoutExt = pathinfo($cleanName, PATHINFO_FILENAME);
                $fileNameToStore = $nameWithoutExt . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension;

                $file->storeAs('public/pdfs', $fileNameToStore, 'public');

                $pdfs[] = [
                    'name' => $nameWithoutExt,
                    'path' => 'storage/public/pdfs/' . $fileNameToStore,
                ];
            }
        }

        return $pdfs;
    }

}
