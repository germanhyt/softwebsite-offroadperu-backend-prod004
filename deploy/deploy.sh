#!/bin/bash
set -euo pipefail

APP_DIR="${APP_DIR:-/opt/offroadperu/backend}"
BRANCH="${BRANCH:-master}"

echo "==> Deploy backend en ${APP_DIR}"

cd "${APP_DIR}"

git fetch origin "${BRANCH}"
git reset --hard "origin/${BRANCH}"

docker compose pull --ignore-buildable 2>/dev/null || true
docker compose build --pull
docker compose up -d

docker compose exec -T laravel php artisan migrate --force --no-interaction
docker compose exec -T laravel php artisan config:cache
docker compose exec -T laravel php artisan route:cache
docker compose exec -T laravel php artisan view:cache

docker image prune -f

echo "==> Backend desplegado correctamente"
