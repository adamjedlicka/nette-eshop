# Eshop

## Installation

    touch config/local.neon

    docker-compose up --build

    docker-compose exec app php vendor/bin/phinx migrate

    docker-compose exec app php vendor/bin/phinx seed:run
