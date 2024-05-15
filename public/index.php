<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

//IF $_SERVER['DOCUMENT_ROOT'] does not contain the public folder, add it
if (strpos($_SERVER['DOCUMENT_ROOT'], "/public") === false) {
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/public";
    $_SERVER['SCRIPT_FILENAME'] = $_SERVER['DOCUMENT_ROOT']."/index.php";

    //get $_SERVER['REQUEST_URI']; until the first ? or # character
    $_SERVER['PATH_INFO'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $_SERVER['PHP_SELF'] = "/index.php".$_SERVER['PATH_INFO'];
}
$vercelURL = getenv('VERCEL_URL');

putenv("APP_URL=https://$vercelURL");

// Forward Vercel requests to public index.
require __DIR__ . "/" . "../public/index.php";

// Register the Composer autoloader...
// require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
