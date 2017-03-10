<?php
//定义函数数据
$funcs = array(
	array('key'=>'Example::TestWorker::demoLog','value'=>'HelloWorld'),
	array('key'=>'Example::TestWorker::demoDB','value'=>'id0'),
	array('key'=>'Example::TestWorker::demoRedis','value'=>'TestKey'),
	array('key'=>'Example::TestWorker::demoConfig','value'=>'null'),
	array('key'=>'Example::TestWorker::demoSys','value'=>'null'),
	array('key'=>'Example::TestWorker::demoDestroy','value'=>'null'));

for ($i=0; $i < count($funcs); $i++) {
	echo '['.$i.'] - '.$funcs[$i]['key'].' - '.$funcs[$i]['value'].PHP_EOL;
}

//选择需要执行的函数
fwrite(STDOUT, "Select your Function Number: ".PHP_EOL); 

// 获取选择参数
$number = (int)trim(fgets(STDIN));

// 打印提示信息
fwrite(STDOUT, $funcs[$number]['key']." will be run ...");

$client= new GearmanClient();
$client->addServer('127.0.0.1', 4730);
echo $client->doNormal($funcs[$number]['key'], $funcs[$number]['value']), "\n";
// echo $client->doBackground($funcs[$number]['key'], $funcs[$number]['value']), "\n";
?>


