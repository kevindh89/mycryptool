#!/bin/bash

# Copy .env.dist to .env if it doesn't already exist
cp -n .env.dist .env

docker-compose --project-name mycryptool up -d --build

# Run composer install
docker run -it -v "$PWD":/var/www/mycryptool mycryptool_php-fpm bash -ci "cd /var/www/mycryptool && /usr/local/bin/composer install"

# Run npm install
docker run -it -v "$PWD":/var/www/mycryptool mycryptool_php-fpm bash -ci "cd /var/www/mycryptool && npm install"

# Run webpack Encore to compile css and js
docker run -it -v "$PWD":/var/www/mycryptool mycryptool_php-fpm bash -ci "cd /var/www/mycryptool && ./node_modules/.bin/encore dev"
