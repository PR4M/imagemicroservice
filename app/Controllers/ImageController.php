<?php

namespace App\Controllers;

use Exception;
use App\Controllers\Controller;
use App\Files\FileStore;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

class ImageController extends Controller
{

    public function store($request, $response, $args)
    {
        /*
         * Check if the uploaded file is null,
         * return the 422 error code
         */
        if (!$upload = $request->getUploadedFiles()['file'] ?? null) {
            return $response->withStatus(422);
        }

        try {
            $this->c->image->make($upload->file);
        } catch (\Exception $e) {
            return $response->withStatus(422);
        }

        /*
         * Store the uploaded image
         */
        $store = (new FileStore())->store($upload);

        /*
         * Return the image being upload, with simple JSON
         */
        return $response->withJson([
           'data' => [
               'uuid' => $store->getStored()->uuid
           ]
        ]);

    }
}
