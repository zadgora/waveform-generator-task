<?php

use App\Reader;
use App\Processor;
use App\Application;
use App\Parser;

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', __DIR__);

require_once __DIR__.DS.'vendor'.DS.'autoload.php';
$config = require_once 'app'.DS.'config.php';

$reader = new Reader();
$parser = new Parser();
$processor = new Processor();


$app = new Application(
   $reader, 
   $parser, 
   $processor, 
   $config);


$res = $app->run();

echo json_encode($res);

