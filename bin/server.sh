#!/bin/bash
# check your parameter number
if [ $# -lt 2 ]
	then
		echo 'Please check your parameter like [start|stop] [moduleName] [dev|test|pro]'
		exit
fi
# init
php_cmd="php "
moduleName=$2
log=$2.out
env=$3
if [ ! $env ]
then
    indexFile=index_dev.php
    env=dev
else
    indexFile=index_$env.php
fi
# show info
echo "PHP CMD : " $php_cmd "\c"
echo " | Module Name : " $2 "\c"
echo " | Env Name : " $env

# delay function
initWorker(){
    echo $1 "\c"
    for i in {1..3}  
    do  
        sleep 1
        echo ".\c"
    done  
    echo "\n" ......... workers status .........
    gearadmin --status
}

# start module
if [ "$1"  = "start" ]
then
    echo index file is ./modules/$moduleName/$indexFile
    nohup $php_cmd ./modules/$moduleName/$indexFile &>$log&
    initWorker $1
    exit
fi

##stop module
if [ "$1"  = "stop" ]
then
    ps -ef  |grep /modules/$moduleName/$indexFile |grep -v grep |awk '{print $2}'  |while read pid
    do
        kill -9 $pid
    done
    initWorker $1
fi
