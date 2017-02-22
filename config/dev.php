<?php

return array(
	'server' => array(
        // '127.0.0.1' => 4730,
        'localhost' => 4730
	),
	'workers' => array(
        'Example::TestWorker::reverse' => 2,
        'Example::TestWorker::sleep'=> 2
	),
);