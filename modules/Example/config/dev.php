<?php

return array(
	'server' => array(
        // '127.0.0.1' => 4730,
        'localhost' => 4730
	),
    //数据库配置信息
	'db' => array(
        'driver' => 'mysql',
        'host' => 'localhost',
        'username'=>'root',
        'password'=>'',
        'database'=>'plume',
        'port' => '3306',
        'charset'=>'utf8'
	),
    'redis' => array(
        'host' => '127.0.0.1',
        'port' => '6379'
    ),
    'redis_slave' => array(
        'host' => '127.0.0.1',
        'port' => '6379'
    ),
	'workers' => array(
        'Example::TestWorker::demoLog' => 2,
        'Example::TestWorker::demoDB'=> 2,
        'Example::TestWorker::demoRedis'=> 2,
        'Example::TestWorker::demoConfig'=> 2,
        'Example::TestWorker::demoSys'=> 2,
        'Example::TestWorker::demoDestroy'=> 2,
        'Example::TestDaemon::start'=> 1
	),
);
