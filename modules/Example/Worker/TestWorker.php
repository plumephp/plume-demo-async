<?php

namespace Example\Worker;

//框架类
use Plume\Async\Core\Worker;
use Plume\Core\Service;
use Plume\Core\Dao;
//业务实现类
use Example\Worker\UserInfoDao;

class TestWorker extends Worker{

	//Worker通过构造方法初始化系统参数
	public function __construct($env) {
        parent::__construct(__DIR__, __CLASS__, $env);

    }
    
    //反序返回原参数的字符串
	public function reverse($job){
		//获取任务参数
		$param = $job->workload();
		//记录日志在TestWorker.log
		$this->log('reverse', $param);
		//记录日志在debug.log
		$this->plume('plume.log.debug', true);
		$this->debug('reverse-debug', $param);
		return strrev($param);
	}

	//反序返回原参数的字符串并休眠10秒
	public function sleep($job){
		for ($i=10; $i <20 ; $i++) { 
			echo '...'.$i;
			sleep(1);
		}
		return strrev($job->workload().':sleep working');

	}

	public function query($job){
		//1.获取提交任务参数
		$filter = $job->workload();
		//2.处理提交任务参数，比如数据格式，内容等
		if(empty($filter)){
			return "";
		}else{
			$filter = trim($filter);
		}
		//3.初始化业务服务处理对象
		//3.1使用默认服务对象
		try {
			$service = new Service($this->app, new Dao($this->app, 'user_info'));	
		} catch (Exception $e) {
			var_dump($e);
		}
		//3.2使用自定义服务对象
		$service = new TestWorkerService($this->app);
		//4.调用业务服务对象处理业务逻辑
		$result = $service->fetchById($filter);
		return json_encode($result, true);
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