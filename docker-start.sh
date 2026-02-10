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

echo "--> Checking Database Variables..."
echo "MYSQLHOST: $MYSQLHOST"
echo "MYSQLPORT: $MYSQLPORT"
echo "DB_HOST: $DB_HOST"
echo "DB_PORT: $DB_PORT"

echo "--> Waiting for database connection (TCP Check)..."
# Tunggu sampai MySQL siap (timeout 60 detik)
for i in {1..60}; do
  TARGET_HOST="${DB_HOST:-$MYSQLHOST}"
  TARGET_PORT="${DB_PORT:-$MYSQLPORT}"
  
  if [ -z "$TARGET_HOST" ] || [ "$TARGET_HOST" = "127.0.0.1" ]; then
    echo "!!! WARNING: DB_HOST is empty or 127.0.0.1. Connection will likely fail !!!"
  fi

  if php -r "exit(@fsockopen('$TARGET_HOST', $TARGET_PORT) ? 0 : 1);" ; then
    echo "--> Connection to $TARGET_HOST:$TARGET_PORT SUCCESS!"
    break
  fi
  echo "--> Attempt $i: Cannot reach $TARGET_HOST:$TARGET_PORT. Retrying..."
  sleep 1
done

echo "--> Running Database Migrations..."
php artisan migrate --force

echo "--> Starting Apache..."
exec apache2-foreground
