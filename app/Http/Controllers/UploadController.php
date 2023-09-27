<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Config;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
class UploadController extends Controller
{
    /**
     * Retrieves and return the image
     *
     * @param $category
     * @param $imageId
     * @return \Illuminate\Http\Response|void
     */
    public function loadImage($category, $imageId)
    {
        /**
         * undocumented constant
         **/
        // Filepond uses an XHR call to load the image. Not sure why it has to do that but hopefully we can change that behavoir in the future
        // Because it's XHR we cannot just redirect to the CDN because of CORS. So here, we just load the image from CDN and serve.

        // Floor-layout view also will use this call because it also loads the image via XHR call.

        $domain = url('/');
        $folder = "";
        switch ($category) {
            case 'product':
                $folder = Config::get('constants.images.product');
                break;
        }
        try {
            $remoteFile = $domain . '/' . $folder . '/' . $imageId;
            $path=Storage::get($folder.$imageId);
            $response = Response::make($folder.$imageId);

            return $response->header('Content-Type', 'image/*');

        } catch (\Exception $e) {
            Log::info("Call to API to load image failed to fetch from cloud: " . $imageId);
            abort(404);
        }
    }
    /**
     * Uploads the event image to the images directory. If
     * the image is uploaded and resized successfully, the image filename
     * (with extension) is returned.
     *
     * @param Request $request
     * @param $productId
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function uploadImage(Request $request)
    {
        $imageFile = 'image_file';
        if ($request->hasFile($imageFile)) {
            if ($request->file($imageFile)->isValid()) {
                $imageFile = $request->file($imageFile);

                // Define the directory where you want to store the image
                $directory = Config::get('constants.images.product');

                // Generate a unique filename for the image
                $filename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $path = $directory . $filename;
                Storage::disk('public')->put($path, File::get($imageFile));

                return response()->json($path);
            }
            return Response::make('The uploaded image is not a valid file.', 400);
        }

        return Response::make('The uploaded image is missing.', 400);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function revertImage(Request $request)
    {
        $fileToDelete = $request->getContent();
        Storage::disk('public')->delete($fileToDelete);
        return response()->json($fileToDelete);
    }
}
