<?php

namespace Service\Worker;

use Plume\Async\Core\Worker;

class Log extends Worker{

    public function __construct($env){
        parent::__construct(__DIR__, __CLASS__, $env);
    }

    public function asyncLog($job){
        $msg = $job->workload();
        $msg_json = json_decode($msg, true);
        $project_name = $msg_json['project_name'];
        $env = $msg_json['env'];
        $fileName = $msg_json['fileName'];
        $title = $msg_json['title'];
        $info = $msg_json['info'];
        $level = $msg_json['level'];
        $dir = $this->plume('plume.root.path').'var/logs/'.$project_name."/".$env."/".date('Y-m-d') .'/';
        if(!is_dir($dir)){
            mkdir($dir, 0777, true);
        }
        $file = $dir.$fileName.'.log';
    	$date = date('Y/m/d H:i:s', time());
    	$infoJSON = json_encode($info, JSON_UNESCAPED_UNICODE);
    	$log = "[" . $date . "] - " . $level . " - " . $title . " - " . $infoJSON. "\r\n\r\n";
    	file_put_contents($file, $log, FILE_APPEND); 
    }
}
