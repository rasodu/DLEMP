COMPOSE=docker-compose

.PHONY: all test mostlyclean clean

include .env

vendor: composer.json | all
	docker exec --user=$$(id -u):$$(id -g) dlemp_cmd_1 composer install

all:
	$(COMPOSE) build
	$(COMPOSE) up -d

test: vendor
	case "$(COMPOSE_FILE)" in \
		*"prod.yml"*) \
			docker exec --user=$$(id -u):$$(id -g) dlemp_phpfpm_1 vendor/bin/phpunit --exclude-group=dev,cmd;; \
		*) \
			docker exec --user=$$(id -u):$$(id -g) dlemp_cmd_1 phpunit --exclude-group=prod \
			&& docker exec --user=$$(id -u):$$(id -g) dlemp_phpfpm_1 vendor/bin/phpunit --exclude-group=cmd,prod;; \
	esac

mostlyclean:
	$(COMPOSE) down -v

#Don't remove images from repository because they may be used by other projects on the same machine
clean:
	$(COMPOSE) down -v --rmi local
	$(RM) -r vendor
