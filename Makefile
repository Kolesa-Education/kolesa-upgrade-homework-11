# запустить локальный веб-сервер
serve:
	php -S localhost:8080
# запустить тесты
test:
	composer exec --verbose phpunit tests
