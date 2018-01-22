#!/bin/bash

# unset export
unset XDEBUG_CONFIG

# execute command
$(dirname $0)/../vendor/bin/php-cs-fixer fix --verbose --allow-risky=yes --config $(dirname $0)/../.php_cs.dist
