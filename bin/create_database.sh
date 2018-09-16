#!/usr/bin/env bash

php console doctrine:migrations:migrate
php console doctrine:fixtures:load --purge-with-truncate
