#!/bin/sh

echo "Debug: Listado de hosts en red:"
getent hosts

echo "Probando resolución de php..."

while ! getent hosts php; do
  echo "waiting for php"
  sleep 1
done

echo "php resuelto, arrancando nginx"
/docker-entrypoint.sh nginx -g 'daemon off;'
