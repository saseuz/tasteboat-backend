#!/bin/bash
set -e

# Cache configuration and routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in foreground
exec apache2-foreground
