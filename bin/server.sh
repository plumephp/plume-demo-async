#!/bin/bash
# check your parameter number
if [ $# -lt 2 ]
	then
		echo 'Please check your parameter like [start|stop] [moduleName] [dev|test|pro]'
		exit
	else
		echo $2' module will '$1
fi
# init
php_cmd="php "
moduleName=$2
log=$2.out
env=$3
echo php commond is $php_cmd
if [ ! $env ]
then
    indexFile=index_dev.php
    env=dev
else
    indexFile=index_$env.php
fi
# start module
if [ "$1"  = "start" ]
then
    echo index file is ./modules/$moduleName/$indexFile
    echo start[$env] ...
    #$php_cmd ./modules/$moduleName/index_$env.php
    nohup $php_cmd ./modules/$moduleName/$indexFile &>$log&
    echo end ...
    exit
fi

##stop module
if [ "$1"  = "stop" ]
then
    echo stop[$env] ...
    ps -ef  |grep /modules/$moduleName/$indexFile |grep -v grep |awk '{print $2}'  |while read pid
    do
        kill -9 $pid
    done
    echo end ...
fi
