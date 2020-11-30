PROJECT = upsw.cc
COMPOSE_FILE = docker-compose.yml

.PHONY: start
start:
	docker-compose \
 -f $(COMPOSE_FILE) -p $(PROJECT) up -d --build


.PHONY: logs
logs:
	docker-compose -f $(COMPOSE_FILE) -p $(PROJECT) logs


.PHONY: bash
bash:
	docker exec -it upswcc_api-server_1 /bin/bash


.PHONY: exec
exec2:
	docker exec -it ${name} /bin/bash


.PHONY: restart
restart:
	docker-compose -f $(COMPOSE_FILE) -p $(PROJECT) kill && \
	docker-compose -f $(COMPOSE_FILE) -p $(PROJECT) rm -f && \
	docker-compose \
 -f $(COMPOSE_FILE) -p $(PROJECT) up -d --build


.PHONY: reset
reset:
	rm -rf infra/db/data/* && \
	touch infra/db/data/.gitkeep && \
	docker-compose -f $(COMPOSE_FILE) -p $(PROJECT) kill && \
	docker-compose -f $(COMPOSE_FILE) -p $(PROJECT) rm -f && \
	docker-compose \
 -f $(COMPOSE_FILE) -p $(PROJECT) up -d --build


.PHONY: gen-ide-helper
gen-ide-helper:
	docker-compose run --rm app php artisan optimize:clear
	docker-compose run --rm app php artisan ide-helper:generate


.PHONY: test
test:
	docker-compose -f $(COMPOSE_FILE) -p $(PROJECT) run --rm api-server php artisan optimize:clear
	docker-compose -f $(COMPOSE_FILE) -p $(PROJECT) run --rm api-server php artisan migrate:refresh --seed --env=testing
	docker-compose -f $(COMPOSE_FILE) -p $(PROJECT) run --rm api-server vendor/bin/phpunit


.PHONY: down
down:
	docker-compose -f $(COMPOSE_FILE) -p $(PROJECT) down --volumes


.PHONY: kill
kill:
	docker-compose -f $(COMPOSE_FILE) -p $(PROJECT) kill


.PHONY: ps
ps:
	docker-compose -f $(COMPOSE_FILE) -p $(PROJECT) ps
