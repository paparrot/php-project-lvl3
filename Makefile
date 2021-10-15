start:
	php artisan serve

setup:
	composer install
	cp -n .env.example .env
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	npm install

log:
	tail -f storage/logs/laravel.log

console:
	php artisan tinker

migrate:
	php artisan migrate

migrate-reset:
	php artisan migrate:reset

deploy:
	git push heroku

watch:
	npm run watch

lint:
	composer exec phpcs

lint-fix:
	composer exec phpcbf

test:
	php artisan test

test-coverage:
	php artisan test --coverage-clover build/logs/clover.xml
