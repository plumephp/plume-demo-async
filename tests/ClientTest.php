<?php
$client= new GearmanClient();
$client->addServer('127.0.0.1', 4730);
echo $client->doNormal('Example::TestWorker::reverse', 'Hello World!'), "\n";
// echo $client->doNormal('sleep', 'Hello World!'), "\n";
// echo $client->doBackground('Example::TestWorker::sleep', 'Hello World!'), "\n";
?>