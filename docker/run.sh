#!/bin/bash

app_name="cdtu-library"
web_root="/usr/share/nginx/html/shu"
app_image_name="yii-server"

action=$1

function run_app(){
	# run
	docker run -d \
	    -p 127.0.0.1:8082:80 \
	    -v "$web_root":/var/www/html \
	    --name ${app_name} \
	    ${app_image_name}
}

function start(){
	container_num=`docker ps -a --format {{.Names}} --filter name=${app_name} | wc -l`
	if [ ${container_num} == 0 ]; then
		run_app
	fi
	docker start ${app_name}
}

function stop(){
	docker stop ${app_name}
}

if [ "X$action" == "Xstart" ]; then
	start
elif [ "X$action" == "Xstart" ]; then
	stop
elif [ "X$action" == "Xrestart" ]; then
	stop
	start
else
	echo "Usage:"
	echo "  $0 start|stop|restart"
fi

