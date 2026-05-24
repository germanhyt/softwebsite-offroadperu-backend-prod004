#!/bin/bash
set -euo pipefail

BACKEND_REPO="${BACKEND_REPO:-https://github.com/germanhyt/softwebsite-offroadperu-backend-prod004.git}"
FRONTEND_REPO="${FRONTEND_REPO:-https://github.com/germanhyt/softwebsite-offroadperu-frontend-prod004.git}"
BASE_DIR="${BASE_DIR:-/opt/offroadperu}"

echo "==> Preparando VPS Offroad Peru"

apt-get update
apt-get install -y git curl

if ! command -v docker >/dev/null 2>&1; then
    curl -fsSL https://get.docker.com | sh
fi

systemctl enable docker
systemctl start docker

mkdir -p "${BASE_DIR}/backend" "${BASE_DIR}/frontend"

if [ ! -d "${BASE_DIR}/backend/.git" ]; then
    git clone "${BACKEND_REPO}" "${BASE_DIR}/backend"
fi

if [ ! -d "${BASE_DIR}/frontend/.git" ]; then
    git clone "${FRONTEND_REPO}" "${BASE_DIR}/frontend"
fi

chmod +x "${BASE_DIR}/backend/deploy/deploy.sh" 2>/dev/null || true
chmod +x "${BASE_DIR}/frontend/deploy/deploy.sh" 2>/dev/null || true

echo ""
echo "Siguiente paso manual:"
echo "1. Crear ${BASE_DIR}/backend/.env desde .env.docker.example"
echo "2. Ejecutar: php artisan key:generate --show  (local) y pegar APP_KEY en .env del VPS"
echo "3. Crear ${BASE_DIR}/frontend/.env desde .env.production.example"
echo "4. Desplegar backend:  cd ${BASE_DIR}/backend && docker compose up -d --build"
echo "5. Desplegar frontend: cd ${BASE_DIR}/frontend && docker compose up -d --build"
echo ""
echo "DNS requerido (apuntar al VPS 2.24.123.124):"
echo "  - admin.offroadperu.com.pe"
echo "  - www.offroadperu.com.pe"
echo "  - offroadperu.com.pe"
