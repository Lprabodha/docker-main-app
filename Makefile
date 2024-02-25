up: network app mail

mail:
	cd ../mail/ && ./vendor/bin/sail up -d --remove-orphans

app: network
	docker compose up -d --remove-orphans

network:
	docker network inspect qr_app_network >/dev/null 2>&1 || \
	docker network create --driver bridge qr_app_network
