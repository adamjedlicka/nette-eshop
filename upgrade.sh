#!/usr/bin/env bash

set -e

echo "=> stopping the application"

docker-compose down

echo "=> pulling new version"

git pull

echo "=> removing old cache"

rm -rf temp/cache

echo "=> starting new version"

docker-compose up --build -d

echo "=> migrating database"

docker-compose exec app php vendor/bin/phinx migrate

echo "=> done"
