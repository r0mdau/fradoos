#!/bin/bash

php composer.phar install

mkdir -p build/log/apache2/fradoos.local
mkdir -p build/log/fradoos.local
mkdir -p build/data/fradoos
chmod -R 777 build/log

docker-compose up