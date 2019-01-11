#!/bin/sh

export YII_ENV_DEV=true

php -c php-local.ini -S 127.0.0.1:9999 -t web
