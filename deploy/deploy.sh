#!/bin/bash
set -euo pipefail

APP_DIR="${APP_DIR:-/opt/offroadperu/backend}"
BRANCH="${BRANCH:-master}"

echo "==> Deploy backend en ${APP_DIR}"

cd "${APP_DIR}"

if [ ! -f .env.laravel.vps ]; then
  echo "ERROR: Falta .env.laravel.vps en el VPS. Crear una sola vez en ${APP_DIR}"
  exit 1
fi

if [ ! -f .env ]; then
  echo "ERROR: Falta .env en el VPS (variables Docker Compose). Crear una sola vez en ${APP_DIR}/.env"
  exit 1
fi

cp .env /tmp/offroad-backend-compose.env.bak

git fetch origin "${BRANCH}"
git reset --hard "origin/${BRANCH}"

mv /tmp/offroad-backend-compose.env.bak .env
cp .env.laravel.vps .env.laravel

COMPOSE_FILES="-f docker-compose.yml"
[ -f docker-compose.traefik.yml ] && COMPOSE_FILES="$COMPOSE_FILES -f docker-compose.traefik.yml"
[ -f docker-compose.ports.yml ] && COMPOSE_FILES="$COMPOSE_FILES -f docker-compose.ports.yml"

docker compose $COMPOSE_FILES pull --ignore-buildable 2>/dev/null || true
docker compose $COMPOSE_FILES build --pull
docker compose $COMPOSE_FILES up -d --force-recreate mysql phpmyadmin laravel

echo "Esperando que Laravel arranque..."
for i in $(seq 1 36); do
  if docker compose $COMPOSE_FILES exec -T laravel php artisan --version >/dev/null 2>&1; then
    break
  fi
  if [ "$i" -eq 36 ]; then
    echo "ERROR: Laravel no respondió a tiempo. Revisar: docker logs offroadperu-laravel"
    exit 1
  fi
  sleep 5
done

docker compose $COMPOSE_FILES exec -T laravel php artisan storage:link --force || true
docker compose $COMPOSE_FILES exec -T laravel php artisan migrate --force --no-interaction
docker compose $COMPOSE_FILES exec -T laravel php artisan config:cache
docker compose $COMPOSE_FILES exec -T laravel php artisan view:cache
docker compose $COMPOSE_FILES exec -T laravel php artisan filament:optimize 2>/dev/null || true

docker image prune -f

echo "==> Backend desplegado correctamente"
