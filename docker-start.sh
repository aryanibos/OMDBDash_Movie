#!/bin/bash
set -e

echo "--> Fixing Apache MPM Configuration..."
# Force remove conflicting MPMs
rm -f /etc/apache2/mods-enabled/mpm_event.conf
rm -f /etc/apache2/mods-enabled/mpm_event.load
rm -f /etc/apache2/mods-enabled/mpm_worker.conf
rm -f /etc/apache2/mods-enabled/mpm_worker.load

# Disable them via command just in case
a2dismod mpm_event mpm_worker || true

# Ensure Prefork is enabled
a2enmod mpm_prefork

echo "--> Debugging Environment..."
echo "DB_HOST: ${DB_HOST:-$MYSQLHOST}"
echo "DB_PORT: ${DB_PORT:-$MYSQLPORT}"
echo "DB_DATABASE: ${DB_DATABASE:-$MYSQLDATABASE}"

echo "--> Waiting for database connection..."
# Tunggu sampai MySQL siap (timeout 30 detik)
for i in {1..30}; do
  if php -r "exit(@fsockopen('${DB_HOST:-$MYSQLHOST}', ${DB_PORT:-$MYSQLPORT}) ? 0 : 1);" ; then
    echo "--> Database is UP!"
    break
  fi
  echo "--> Waiting for database (attempt $i)..."
  sleep 1
done

echo "--> Running Database Migrations..."
php artisan migrate --force

echo "--> Starting Apache..."
exec apache2-foreground
