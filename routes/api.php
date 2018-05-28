<?php

use App\Controllers\ImageController;

$app->post('/image', ImageController::class . ':store');
$app->get('/image/{uuid}', ImageController::class . ':show');
