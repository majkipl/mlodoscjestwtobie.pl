#!/bin/bash

chown -R www-data:www-data /var/www/html/public
chown -R www-data:www-data /var/www/html/storage
chmod -R 777 /var/www/html/public
chmod -R 777 /var/www/html/storage


composer install --no-interaction --no-progress

php artisan key:generate            # generujemy klucz
php artisan migrate:fresh --seed    # robimy migracje wraz z seed'ami #
php artisan cache:clear             # czyścimy cache
php artisan config:clear            # czyścimy konfiguracje
php artisan route:clear             # czyścimy routing

cd public
ln -sf ../storage/app/ storage

# utrzymuje kontener przy życiu - nie zamyka apache
# wyświetla logi apacha
exec docker-php-entrypoint apache2-foreground
