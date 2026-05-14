#!/bin/sh
set -e

# Fix permissions for storage and bootstrap/cache to ensure www-data can write
# This handles cases where files are created with root ownership (e.g., view compilation)
echo "🔧 Fixing storage permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
find /var/www/html/storage /var/www/html/bootstrap/cache -type d -exec chmod 775 {} +
find /var/www/html/storage /var/www/html/bootstrap/cache -type f -exec chmod 664 {} +

# Run Laravel optimizations
echo "🚀 Running Laravel optimizations..."
gosu www-data php artisan optimize

# Fix permissions again after optimize (views might be compiled as root)
echo "🔧 Fixing permissions after optimize..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
find /var/www/html/storage /var/www/html/bootstrap/cache -type d -exec chmod 775 {} +
find /var/www/html/storage /var/www/html/bootstrap/cache -type f -exec chmod 664 {} +

# Execute the CMD
echo "🎬 Starting Supervisor..."
exec "$@"
