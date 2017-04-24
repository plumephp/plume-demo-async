<?php

return array(
    'server' => array(
        // '127.0.0.1' => 4730,
        'localhost' => 4730
	),
    'workers' => array(
        'Service::Log::asyncLog' => 1,
        'Service::Log::asyncTime' => 1,
    ),
    'server_es' => '127.0.0.1:9200',
);
