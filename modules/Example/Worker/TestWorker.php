<?php

namespace Example\Worker;

use Plume\Async\Core\Worker;

class TestWorker extends Worker{

	public function __construct($env) {
        parent::__construct(__DIR__, $env);
    }
    
    //反序返回原参数的字符串
	public function reverse($job){
		return strrev($job->workload());
	}

	//反序返回原参数的字符串并休眠10秒
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

	//获取redis示例
	private function getRedis(){
		$redis = $this->provider('redis')->connect();
		echo $redis->ping();
		return $redis;
	}

	//获取mysql操作示例
	private function getDB(){
		$db = $this->provider('dataBase')->connnect();
		return $db;
	}

	//获取配置示例
	private function getModuleConfig(){
		//获取配置文件
		$config = $this->getConfig();
		//获取数据库配置文件
		$dbConfig = $this->getConfigValue('db');
		//获取worker列表
		$workerList = $this->getConfigValue('workers');
		return $config;
	}

	//获取模块根路径
	private function getRootPath(){
		return $this->app['plume.root.path'];
	}
}