<?php
$worker= new GearmanWorker();
$worker->addServer('127.0.0.1', 4730);
$worker->addFunction('module::reverse', 'my_reverse_function');
while ($worker->work());
function my_reverse_function($job) {
	for ($i=10; $i <20 ; $i++) { 
		echo '...'.$i;
		sleep(1);
	}
return strrev($job->workload().'ddd');
}
?>