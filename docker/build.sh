#!/bin/bash

app_image_name="yii-server"

docker images php:5.6-apache | grep 5.6-apache
if [ $? -ne 0 ]; then
	docker pull php:5.6-apache
fi

# build:
docker build -t ${app_image_name} -f Server-Dockerfile .
