#!/bin/bash

if ! type -P "composer" &>/dev/null; then
    echo "You must install composer and add it to your PATH : https://getcomposer.org/download/"
    exit 1
fi
composer install

mkdir -p build/log/apache2/fradoos.local
mkdir -p build/log/fradoos.local
mkdir -p build/data/fradoos
chmod -R 777 build/log

docker-compose up