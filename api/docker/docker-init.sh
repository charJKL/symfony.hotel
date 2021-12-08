#!/bin/sh
set -e

echo "Run init script:"
cd /var/www/bin

until php console doctrine:query:sql "select 1" >/dev/null 2>&1; do
	(>&2 echo "Waiting for MySQL to be ready...")
	sleep 10
done

echo "- php console doctrine:migrations:migrate --no-interaction"
php console doctrine:migrations:migrate --no-interaction 2>/dev/null

echo "- php console doctrine:migrations:migrate --no-interaction --env=test"
php console doctrine:migrations:migrate --no-interaction --env=test 2>/dev/null

cd /usr/local/bin
exec /usr/local/bin/docker-php-entrypoint "apache2-foreground $@"