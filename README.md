# php_console

## О проекте

В разработке.

Библиотека создания консольных команд.

## Использование

Проект имеет [единую точку входа](app.php).

При необходимости для удобства тестирования и дальнейшей разработки можно с помощью `docker compose`
поднять локальные микросервисы, которые находятся в папке `docker`
([reverse proxy](docker/nginx-dev-proxy/docker-compose.yml)
и [сам php-сервер](docker/test-php-console/docker-compose.yml))
