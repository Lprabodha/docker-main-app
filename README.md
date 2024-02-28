Docker Main App

This is a Docker-based environment configured for php development.

## .env

```shell
APP_IMAGE = demo-php
APP_VOLUMES_SRC=./app
NGINX_PORT=8082
MYSQL_PORT=3307
UID=1000

SITE_URL = http://localhost:8082

MYSQL_ROOT_PASSWORD=password
MYSQL_DATABASE=test_database
MYSQL_USER=qr_user
MYSQL_PASSWORD=password
```
