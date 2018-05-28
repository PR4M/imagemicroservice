<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG') === 'true',

        'app' => [
            'name' => getenv('APP_NAME')
        ],

        'database' => [
          'driver' => 'mysql',
          'host' => 'localhost',
          'port' => '3306',
          'database' => 'microimageservice',
          'username' => 'root',
          'pass' => '',
          'charset' => 'utf8',
          'collation' => 'utf8_unicode_ci',
          'prefix' => '',
        ],

    ],
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container['settings']['database']);
$capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher());

$capsule->setAsGlobal();
$capsule->bootEloquent();

require_once __DIR__ . '/../routes/api.php';
