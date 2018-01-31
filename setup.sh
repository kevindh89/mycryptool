#!/bin/bash

# Start docker machine
docker-machine start default
eval $(docker-machine env)

# Copy .env.dist to .env if it doesn't already exist
cp -n .env.dist .env

docker-compose up -d --build

# Run composer install
docker run -it -v "$PWD":/var/www/mycryptool mycryptool_php-fpm bash -ci "cd /var/www/mycryptool && /usr/local/bin/composer install"

# Run db migrations
docker run -it -v "$PWD":/var/www/mycryptool mycryptool_php-fpm bash -ci "cd /var/www/mycryptool && bin/console --no-interaction doctrine:migrations:migrate"

# Run npm install
docker run -it -v "$PWD":/var/www/mycryptool mycryptool_php-fpm bash -ci "cd /var/www/mycryptool && npm install"

# Run webpack Encore to compile css and js
docker run -it -v "$PWD":/var/www/mycryptool mycryptool_php-fpm bash -ci "cd /var/www/mycryptool && ./node_modules/.bin/encore dev"
