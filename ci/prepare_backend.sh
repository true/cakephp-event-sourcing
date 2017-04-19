#!/usr/bin/env bash

# Install composer dependencies
curl --silent --show-error https://getcomposer.org/installer | php
cp composer.phar /usr/local/bin/composer
