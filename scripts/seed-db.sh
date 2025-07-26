#!/bin/bash

if [ -f .env ]; then
    DB_USER=$(grep -E '^DB_USER=' .env | cut -d '=' -f2-)
    DB_PASSWORD=$(grep -E '^DB_PASSWORD=' .env | cut -d '=' -f2-)
    DB_NAME=$(grep -E '^DB_NAME=' .env | cut -d '=' -f2-)
else
  echo "missing .env file"
  exit 1
fi

OVERWRITE=false
for arg in "$@"; do
  case $arg in
    --overwrite)
      OVERWRITE=true
      shift
      ;;
  esac
done


if [ "$OVERWRITE" = true ]; then
  echo "Wiping data, please wait..."
  docker compose exec -T mysql mysql -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" <<EOF >/dev/null 2>&1
DELETE FROM promotions;
DELETE FROM prices;
DELETE FROM products;
VACUUM;
EOF
  echo "Data wiped successfully."
fi

echo "Generating data..."
    docker compose exec -T php bash -c \
    "bin/console app:import-promotions-from-json ; php bin/console app:import-products-from-json"
echo "Import finished successfully"
