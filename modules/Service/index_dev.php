<?php

if (substr(php_sapi_name(), 0, 3) !== 'cli') {
	die("Please used in client mode");
}

require_once __DIR__.'/../../vendor/autoload.php';

use Plume\Async\Application;

$app = new Application();
$app['plume.root.path'] = __DIR__.'/';
$app['plume.log.debug']=true;
$app->run();