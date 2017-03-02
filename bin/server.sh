#!/bin/bash
# check your parameter number
if [ "$#" != "2" ]
	then
		echo 'Please check your parameter like [start|stop] [moduleName]'
		exit
	else
		echo $2' module will '$1
fi
# init
php_cmd="php "
moduleName=$2
log=$2.out 
echo php commond is $php_cmd
# start module
if [ "$1"  = "start" ]
then
    echo index file is ./modules/$moduleName/index_dev.php
    echo start ...
    #$php_cmd ./modules/$moduleName/index_dev.php
    nohup $php_cmd ./modules/$moduleName/index_dev.php &>$log&
    echo end ...
    exit
fi

##stop module
if [ "$1"  = "stop" ]
then
	echo stop ...
    ps -ef  |grep /modules/$moduleName/index_dev.php |grep -v grep |awk '{print $2}'  |while read pid
        do
            kill -9 $pid
        done
    echo end ...
fi