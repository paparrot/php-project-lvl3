start:
	php artisan serve

install:
	composer install
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