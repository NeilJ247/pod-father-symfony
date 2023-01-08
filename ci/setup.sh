#!/usr/bin/env sh
set -e

ENV=$1

bin/console doctrine:database:create --env="${ENV}"
bin/console doctrine:migrations:migrate --env="${ENV}"
bin/console doctrine:fixtures:load --env="${ENV}"