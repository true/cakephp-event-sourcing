#!/usr/bin/env bash

sed -i -- 's/^extension=igbinary/;&/' /etc/php/7.0/cli/conf.d/20-igbinary.ini

composer install --no-progress
cp ci/ci.env config/local.env
