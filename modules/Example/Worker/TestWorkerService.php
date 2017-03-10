<?php

namespace Example\Worker;

use Plume\Core\Service;
use Plume\Core\Dao;

class TestWorkerService extends Service{


	public function __construct($app) {
		//指定默认service使用的DAO，并且指定表名和主键
        parent::__construct($app, new Dao($app, 'user_info', 'id'));
    }


    /**
    * WorkerService的数据库查询示例
    */
	public function query($id){
		//检查参数是否正确
		if (empty($id)) {
			return "query nothing";
		}
		//连接数据库查询
		try {
			$result = $this->fetchById($id);
			$this->closeDB();
		} catch (Exception $e) {
			return "exception";
		}
		//检查查询数据
		if(sizeof($result) == 0){
			return "db nothing";
		}
		return $result;
	}

	/**
	* WorkerService的redis查询示例
	*/
	public function getValue($key){
		//检查参数是否正确
		if (empty($key)) {
			return "getValue nothing";
		}
		//连接redis查询
		try{
			$this->getRedis()->set($key, "Hello getValue Method");
			$result = $this->getRedis()->get($key);
			$this->closeRedis();//$this->getRedis()->close();
		} catch (Exception $e) {
			return "exception";
		}
		//检查查询数据
		if(empty($result)){
			return "redis nothing";
		}
		return $result;

	}
}