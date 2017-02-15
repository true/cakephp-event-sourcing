#!/usr/bin/env bash

# Install required packages
# zlib1g-dev libicu-dev g++     - Requirements for intl extention
# unzip                         - Used to speed-up composer install
apt-get install zlib1g-dev libicu-dev g++ unzip  -yqq

# Install required PHP extensions
docker-php-ext-configure intl
docker-php-ext-install -j4 pdo_mysql intl

composer install
cp ci/ci.env config/local.env
