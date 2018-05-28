<?php
/**
 * Created by PhpStorm.
 * User: Pramana
 * Date: 5/28/2018
 * Time: 12:11 PM
 */

namespace App\Files;


use Slim\Http\UploadedFile;

class FileStore
{
    public function store(UploadedFile $file)
    {
        $file->moveTo(uploads_path('abc.jpg'));

        return $this;
    }
}