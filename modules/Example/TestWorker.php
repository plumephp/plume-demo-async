<?php

namespace Example;

class TestWorker {

	public function reverse($job){
		return strrev($job->workload());
	}

	public function sleep($job){
		for ($i=10; $i <20 ; $i++) { 
			echo '...'.$i;
			sleep(1);
		}
		return strrev($job->workload().':sleep working');

	}

	public function get(){
		return function($job){
			$this->my_reverse_function($job);
		};
	}
}