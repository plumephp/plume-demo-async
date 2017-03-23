<?php

namespace Example\Worker;

//框架类
use Plume\Async\Core\Daemon;

class TestDaemon extends Daemon{

	//Daemon通过构造方法初始化系统参数
	public function __construct($env) {
		//__CLASS__参数 指定日志文件名，可以自定义
        parent::__construct(__DIR__, __CLASS__, $env);
    }

    public function run(){
        while(true){
            sleep(1);
            echo "just run ...";
            $this->log('Run Method', 'TestDaemon Run ...');
        }
    }
}