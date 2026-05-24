#!/bin/bash
set -euo pipefail

APP_DIR="${APP_DIR:-/opt/offroadperu/backend}"
BRANCH="${BRANCH:-master}"

echo "==> Deploy backend en ${APP_DIR}"

cd "${APP_DIR}"

git fetch origin "${BRANCH}"
git reset --hard "origin/${BRANCH}"

COMPOSE_FILES="-f docker-compose.yml"
[ -f docker-compose.traefik.yml ] && COMPOSE_FILES="$COMPOSE_FILES -f docker-compose.traefik.yml"
[ -f docker-compose.ports.yml ] && COMPOSE_FILES="$COMPOSE_FILES -f docker-compose.ports.yml"

docker compose $COMPOSE_FILES pull --ignore-buildable 2>/dev/null || true
docker compose $COMPOSE_FILES build --pull
docker compose $COMPOSE_FILES up -d mysql phpmyadmin laravel

docker compose $COMPOSE_FILES exec -T laravel php artisan storage:link --force || true
docker compose $COMPOSE_FILES exec -T laravel php artisan migrate --force --no-interaction
docker compose $COMPOSE_FILES exec -T laravel php artisan config:cache
docker compose $COMPOSE_FILES exec -T laravel php artisan route:cache
docker compose $COMPOSE_FILES exec -T laravel php artisan view:cache

docker image prune -f

echo "==> Backend desplegado correctamente"
