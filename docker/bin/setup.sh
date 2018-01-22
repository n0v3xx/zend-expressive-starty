#!/bin/bash

set -e

########################################################################################################################
### Start Docker Setup
########################################################################################################################

DIR=`dirname $(readlink -f $0)`
DOCKER_DIR=`dirname $DIR`
PROJECT_ROOT=`dirname $DOCKER_DIR`

USER_ID=$(id -u)
GROUP_ID=$(id -g)

# load docker config variables for this specific project
source "$DIR/config.sh"

ENV_SOURCE="$PROJECT_ROOT/.env.dist"
ENV_DESTINATION="$PROJECT_ROOT/.env"

cp "$ENV_SOURCE" "$ENV_DESTINATION"

sed -i -r "s|###USER_ID###|$USER_ID|g" "$ENV_DESTINATION"
sed -i -r "s|###GROUP_ID###|$GROUP_ID|g" "$ENV_DESTINATION"

# create log folder
echo "===> Create log folder"
mkdir -p log && chmod 777 log

sudo docker-compose -f ${DOCKER_DIR}/php71/docker-compose.yml up -d

# replace xdebug IP
echo "==> Replace xdebug remote host with ipadress of docker host"
REMOTE_HOST=$(hostname -I | awk '{print $1}')
echo "Your remote host ip address is $REMOTE_HOST"
XDEBUG_INI="/etc/php/7.1/fpm/conf.d/99-docker.ini"
sudo docker exec -it ${CONTAINER_WEB} sed -i -r "s/xdebug\.remote_host=(\b[0-9]{1,3}\.){3}[0-9]{1,3}\b/xdebug.remote_host=$REMOTE_HOST"/ "$XDEBUG_INI"

sudo docker-compose -f ${DOCKER_DIR}/php71/docker-compose.yml restart

# run deplyoment
#sudo docker exec -itu $(id -u) "$CONTAINER_WEB" ./docker/bin/phing.sh "$PHING_CONFIGURATION"