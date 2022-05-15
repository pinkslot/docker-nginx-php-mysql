<?php

use App\Acme\Kernel;
use Symfony\Component\HttpFoundation\Request;

include '../app/vendor/autoload.php';

$request = Request::createFromGlobals();
$kernel = new Kernel();
$response = $kernel->handleHttpRequest($request);
$response->prepare($request);
$response->send();
