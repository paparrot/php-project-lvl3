start:
	php artisan serve

console:
	php artisan tinker

setup:
	composer install
	php artisan migrate
	npm install

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
	php artisan test-coverage
