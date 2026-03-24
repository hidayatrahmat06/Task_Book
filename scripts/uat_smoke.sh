#!/usr/bin/env bash
set -euo pipefail

PORT="${1:-8000}"
HOST="127.0.0.1"
BASE_URL="http://${HOST}:${PORT}"
SERVER_LOG="/tmp/task_book_uat_server.log"

echo "[1/4] Reset database + seed data..."
php artisan migrate:fresh --seed >/dev/null

echo "[2/4] Run automated tests..."
php artisan test

echo "[3/4] Start local server for smoke check..."
php artisan serve --host="${HOST}" --port="${PORT}" >"${SERVER_LOG}" 2>&1 &
SERVER_PID=$!

cleanup() {
  kill "${SERVER_PID}" >/dev/null 2>&1 || true
}
trap cleanup EXIT

echo "[4/4] Validate key guest endpoints..."
SERVER_READY=0
for _ in $(seq 1 20); do
  if curl -sSfI "${BASE_URL}/login" >/dev/null 2>&1; then
    SERVER_READY=1
    break
  fi
  sleep 1
done

if [ "${SERVER_READY}" -ne 1 ]; then
  echo "Gagal: server tidak siap di ${BASE_URL}."
  echo "Cek log: ${SERVER_LOG}"
  exit 1
fi

LOGIN_STATUS="$(curl -sI "${BASE_URL}/login" | head -n 1)"
REGISTER_STATUS="$(curl -sI "${BASE_URL}/register" | head -n 1)"
HOME_STATUS="$(curl -sI "${BASE_URL}/" | head -n 1)"

echo "Login   : ${LOGIN_STATUS}"
echo "Register: ${REGISTER_STATUS}"
echo "Home    : ${HOME_STATUS}"
echo "Done. Server-side smoke test selesai."
