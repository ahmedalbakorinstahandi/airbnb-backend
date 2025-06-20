<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Services\FileService;
use App\Services\ImageService;
use App\Services\OrderHelper;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
            'folder' => 'required|string|in:users,listings,house_types,categories,features',
        ]);

        $imageName = ImageService::storeImage($request->image, $request->folder, $request->folder == 'listings');

        return ResponseService::response([
            'success' => true,
            'data' => [
                'image_name' => $imageName,
                'image_url' => asset('storage/' . $imageName),
            ],
            'message' => 'messages.image.uploaded',
            'status' => 201,
        ]);
    }

    // file upload
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpeg,png,jpg,gif,webp|max:8192',
            'folder' => 'required|string|in:users,transactions',
        ]);

        $fileName = FileService::storeFile($request->file, $request->folder);

        return ResponseService::response([
            'success' => true,
            'data' => [
                'file_name' => $fileName,
                'file_url' => asset('storage/' . $fileName),
            ],
            'message' => 'messages.file.uploaded',
            'status' => 201,
        ]);
    }


    public function reorder($id, Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
        ]);

        $image = Image::find($id);

        if (!$image) {
            return ResponseService::response([
                'success' => false,
                'message' => 'messages.image.not_found',
                'status' => 404,
            ]);
        }

        OrderHelper::reorder($image, $request->orders);

        return $image;
    }
}
