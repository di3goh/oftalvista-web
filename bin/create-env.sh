#!/bin/sh
set -eu

if [ -f .env ]; then
  echo '.env ya existe; no se modificó.'
  exit 0
fi

umask 077
app_key=$(openssl rand -hex 32)
database_password=$(openssl rand -base64 30 | tr -d '\n/=+')
admin_password=$(openssl rand -base64 30 | tr -d '\n/=+')
pgadmin_password=$(openssl rand -base64 30 | tr -d '\n/=+')

sed \
  -e "s|^APP_KEY=.*|APP_KEY=$app_key|" \
  -e "s|^APP_PORT=.*|APP_PORT=8090|" \
  -e "s|^POSTGRES_PASSWORD=.*|POSTGRES_PASSWORD=$database_password|" \
  -e "s|^ADMIN_PASSWORD=.*|ADMIN_PASSWORD=$admin_password|" \
  -e "s|^PGADMIN_PORT=.*|PGADMIN_PORT=5051|" \
  -e "s|^PGADMIN_PASSWORD=.*|PGADMIN_PASSWORD=$pgadmin_password|" \
  .env.example > .env

echo '.env creado con secretos aleatorios y permisos restringidos.'
