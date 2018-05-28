<?php

namespace App\Controllers;

use App\Models\Image;
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

    public function show($request, $response, $args)
    {
        extract($args);

        try {
            $image = Image::where('uuid', $uuid)->firstOrFail();
        } catch (Exception $e) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(
            $this->getProcessedImage($image, $request)
        );

        return $this->respondWithHeaders($response);
    }

    protected function respondWithHeaders($response)
    {
        foreach ($this->getResponseHeaders() as $header => $value) {
            $response = $response->withHeader($header, $value);
        }

        return $response;
    }

    protected function getResponseHeaders()
    {
        return [
            'Content-Type' => 'image/png'
        ];
    }

    protected function getProcessedImage($image, $request)
    {
        return $this->c->image->cache(function ($builder) use ($image, $request) {
            $this->processImage(
              $builder->make(uploads_path($image->uuid)),
              $request
            );
        });
    }

    protected function processImage($builder, $request)
    {
        return $builder->resize(null, $this->getRequestedSize($request), function ($constraint) {
            $constraint->aspectRatio();
        })->encode('png');
    }

    protected function getRequestedSize($request)
    {
        return max(min($request->getParam('s'), 800) ?? 100, 50);
    }
}
