#!/usr/bin/env bash
path=`pwd`/vendor
case "$1" in
    start)
        if [ ! -d $path ]; then
            ln -s ../vendor/ $path
        fi
        echo "start http server"
        php HttpServer.php >/dev/null 2>&1 &
        #php HttpServer.php  &
    ;;
    stop)
        echo "stop http server"
        httpServer=$(ps -ef|grep 'php HttpServer.php'|grep -v "grep"|awk -F " " '{print $2}'|sort)
        kill -9 $httpServer
    ;;
    *)
    echo "invalid options"
    ;;
esac