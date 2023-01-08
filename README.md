# PodFather - Jobs API

## Setting up

```
composer install

./ci/setup.sh dev

symfony server:start
```

```
./ci/setup.sh dev
```

## Running tests

Functional/Unit tests:

```
./ci/setup.sh dev

./vendor/bin/phpunit
```

API Testing

This project uses behat to test the API.  

**Note:** There is an issue to resolve in that the behat tests are running against the dev environment instead of test.  So please ensure the dev environment is setup.

```
./vendor/bin/behat
```