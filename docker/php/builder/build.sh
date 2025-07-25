#!/bin/bash

TAG="8.4"
TAG_CUSTOM="${TAG}-0.0"
TAG_LATEST="latest"

CI_REGISTRY="aleixp"
IMAGE_NAME="php-${TAG}-builder"
IMAGE="${CI_REGISTRY}/${IMAGE_NAME}"

printf "\e[32m%s\e[0m\n" "Building ${IMAGE_NAME} docker image"

docker buildx inspect custom > /dev/null 2>&1 || { echo "Creating custom base image..."; docker buildx create --name custom --platform linux/amd64,linux/arm64; }

docker buildx build --builder custom --platform linux/amd64,linux/arm64 --pull --push -t ${IMAGE}:${TAG} -t ${IMAGE}:${TAG_LATEST} -t ${IMAGE}:${TAG_CUSTOM} $(dirname $0)

printf "\e[33m%s\e[0m\n" "Done"
