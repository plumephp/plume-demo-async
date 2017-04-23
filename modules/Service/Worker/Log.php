<?php

namespace Service\Worker;

use Plume\Async\Core\Worker;
use Elasticsearch\ClientBuilder;

class Log extends Worker{

    private $client;

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


    public function ($job){
        date_default_timezone_set('UTC');
        $server_es = empty($this->getConfigValue('server_es')) ? '127.0.0.1:9200' : $this->getConfigValue('server_es');
        $hosts = [
            $server_es,
        ];
        $this->client = ClientBuilder::create()
                      ->setRetries(0)
                      ->setHosts($hosts)
                      ->build();
        $msg = $job->workload();
        $msg_json = json_decode($msg, true);

        $params['body'][] = [
            'index' => [
                '_index' => 'plume-'.$msg_json['project'],
                '_type' => 'plog',
            ]
        ];
        $params['body'][] = [
            'ip_remote' => $msg_json['ip_remote'],
            'ip_local' => $msg_json['ip_local'],
            'project' => $msg_json['project'],
            'url' => $msg_json['url'],
            'time_used' => $msg_json['time_used'],
            'time_create' => getUTCTime(),
            'context' => $msg_json['context'],
            'note' => $msg_json['note'],
            'env' => $msg_json['env'],
        ];
        $responses = $this->client->bulk($params);
    }

    private function getUTCTime(){
        return date('Y-m-d\TH:i:s\Z');
    }
}
