#!/bin/bash

if [ "$TEST_TYPE" = "unit" ]
then
  ./vendor/bin/phpunit -c tests/phpunit.xml
elif [ "$TEST_TYPE" = "functional" ]
then

    while [ 1 ]
    do
        MIGRATION="$(bash ./docker/wait-for-it.sh db_test:3306 -t 5 -s -- ./vendor/bin/doctrine-module migrations:migrate -n)"
        if [ -z "$MIGRATION" ]
        then
              echo "Mysql is not ready"
        else
              echo "Mysql is ready"
              ./vendor/bin/phpunit -c tests/phpfunctional.xml
              exit
        fi
    done

fi
