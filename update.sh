#!/bin/sh

git pull origin main

docker build -t registry.gitlab.com/gitops-widi/container-registry/segarbox/laravel:php8.0-fpm .
docker push registry.gitlab.com/gitops-widi/container-registry/segarbox/laravel:php8.0-fpm
docker service update --force segarbox_app

docker rmi $(docker images --filter "dangling=true" -q --no-trunc)


