#!/usr/bin/env bash
path=`pwd`
vendor=$path/vendor
composer=$path/composer.json
case "$1" in
    start)
        if [ ! -d $vendor ]; then
            ln -s ../vendor/ $vendor
        fi
        if [ ! -f $composer ]; then
            ln -s ../composer.json $composer
        fi
        echo "start http server"
        php mockServer/HttpServer.php >/dev/null 2>&1 &
        #php HttpServer.php  &
    ;;
    stop)
        echo "stop http server"
        httpServer=$(ps -ef|grep 'php mockServer/HttpServer.php'|grep -v "grep"|awk -F " " '{print $2}'|sort)
        kill -9 $httpServer
    ;;
    *)
    echo "invalid options"
    ;;
esac