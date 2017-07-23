#!/usr/bin/env bash

docker-compose up -d --build
echo "Install composer"
docker exec automaintenancetracker_web_1 composer install
echo "Install npm package for angular"
docker exec automaintenancetracker_web_1 npm install --prefix ./resources/auto-app/
echo "Build prod mode"
docker exec automaintenancetracker_web_1 npm run build:prod:aot --prefix ./resources/auto-app/

while [ 1 ]
do
    MIGRATION="$(docker exec automaintenancetracker_web_1 bash ./docker/wait-for-it.sh db:3306 -t 5 -s -- ./vendor/bin/doctrine-module migrations:migrate -n)"
    if [ -z "$MIGRATION" ]
    then
          echo "Mysql is not ready"
    else
          echo "Mysql is ready"
          exit
    fi
done