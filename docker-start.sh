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

echo "--> Running Database Migrations..."
php artisan migrate --force

echo "--> Starting Apache..."
exec apache2-foreground
