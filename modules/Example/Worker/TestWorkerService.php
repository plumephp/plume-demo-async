<?php

namespace Example\Worker;

use Plume\Core\Service;
use Plume\Core\Dao;

class TestWorkerService extends Service{


	public function __construct($app) {
        parent::__construct($app, new Dao($app, 'user_info', 'id'));
    }

	function fetchById($filter){
		//1.检查参数是否正确-可选
		if (empty($filter)) {
			return "nothing";
		}
		//2.连接数据库查询
		try {
			$result = $this->dao->fetchById($filter);
		} catch (Exception $e) {
			return "error";
		}
		//3.检查查询数据
		if(sizeof($result) == 0){
			return "nothing by query";
		}
		return json_encode($result);
	}
}