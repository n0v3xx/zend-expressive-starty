#!/bin/bash
#########################################
############## Docker Config ############
#########################################

# Alias
DOCKER_ALIAS="start_"

# WEB
CONTAINER_WEB="start_php71"
CONTAINER_WEB_SERVICE="start_php71"

# REDIS
CONTAINER_REDIS="start_redis"
CONTAINER_MEM_IMAGE="memcached:1.4"

# XHGUI
CONTAINER_XHGUI="start_xhgui"
CONTAINER_XHGUI_IMAGE="cv21/xhgui:latest"

# dbCore
CONTAINER_DBCORE="start_dbcore"
CONTAINER_DBCORE_IMAGE="mysql:5.6"