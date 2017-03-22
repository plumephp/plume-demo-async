<?php

namespace Example\Worker;

//框架类
use Plume\Async\Core\Worker;
use Plume\Core\Service;
use Plume\Core\Dao;
//业务实现类
use Example\Worker\TestWorkerService;

class TestWorker extends Worker{

	//Worker通过构造方法初始化系统参数
	public function __construct($env) {
		//__CLASS__参数 指定日志文件名，可以自定义
        parent::__construct(__DIR__, __CLASS__, $env);
    }

    /**
    * 日志使用示例
    * 功能：反序返回原参数的字符串
    */
    public function demoLog($job){
    	//获取任务参数
		$param = $job->workload();
		//记录日志在TestWorker.log
		$this->log('reverse', $param);
		//记录日志在debug.log
		$this->plume('plume.log.debug', true);
		$this->debug('reverse-debug', $param);
		//自定义日志存储到demoLog.log
		$this->provider("log")->log("demoLog", "method", $param);
		return strrev($param);
    }

    /**
    * 数据库使用示例
    * 功能：查询user_info表中id为id0的数据
    */
    public function demoDB($job){
        try {
            //获取任务参数
            $param = $job->workload();
            //使用服务对象处理业务
            $service = new TestWorkerService($this->app);
            $result = $service->query($param);
            $service->close_db();
            $result = $service->query($param);
            return json_encode($result, true);    
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    	
    }

    /**
    * 数据库使用示例
    * 功能：查询user_info表中id为id0的数据
    */
    public function demoRedis($job){
    	//获取任务参数
		$param = $job->workload();
		//使用服务对象处理业务
		$service = new TestWorkerService($this->app);
		$result = $service->getValue($param);
		return json_encode($result, true);
    }

    /**
    * 配置文件使用示例
    * 功能：获取单个和整体配置文件
    */
    public function demoConfig($job){
    	//获取配置文件
		$config = $this->getConfig();
		//获取数据库配置文件
		$dbConfig = $this->getConfigValue('db');
		//获取worker列表
		$workerList = $this->getConfigValue('workers');
		return json_encode($config, true);
    }

    /**
    * 系统配置获取使用示例
    * 功能：获取当前模块的根路径
    */
    public function demoSys($job){
    	return $this->app['plume.root.path'];
    }

    public function demoDestroy($job){
    	$data = array("test","value");
    	echo $data[10];
    	throw new \Exception("destroy");
    	return "demoTest";
    }

	public function get(){
		return function($job){
			$this->my_reverse_function($job);
		};
	}


}