<?php

use App\Controllers\ImageController;

$app->post('/image', ImageController::class . ':store');
