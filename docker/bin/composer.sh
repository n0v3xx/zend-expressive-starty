#!/bin/bash

########################################################################################################################
### Docker Composer
########################################################################################################################
# run composer commands directly in docker container

DIR=`dirname $(readlink -f $0)`

# include config
source "$DIR/config.sh"

BIN_DIR=`dirname $(readlink -f $0)`
ROOT_DIR=`dirname $BIN_DIR`

cd "$ROOT_DIR"

sudo docker exec -itu $(id -u) "$CONTAINER_WEB" php -d memory_limit=-1 ./build/bin/composer.phar "$@"
