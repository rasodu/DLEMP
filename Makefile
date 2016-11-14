COMPOSE=docker-compose

.PHONY: all test mostlyclean clean enter codeanalytics codefix

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
	-$(RM) -r vendor
	-$(RM) -r public/app-documentation
	#-$(RM) -r public/phpunit-coverage

enter:
	docker-compose exec --user=$$(id -u):$$(id -g) cmd bash

codeanalytics:
	docker-compose exec --user=$$(id -u):$$(id -g) cmd phpcs tests/ public/

codefix:
	docker-compose exec --user=$$(id -u):$$(id -g) cmd phpcbf tests/ public/

public/app-documentation: tests
	#phpdoc template:list
	#'--template=zend' doesn't work https://github.com/gomoob/grunt-phpdocumentor/issues/12
	docker exec --user=$$(id -u):$$(id -g) dlemp_cmd_1 phpdoc -d tests/ -t public/app-documentation/

#public/phpunit-coverage: app
#	docker exec --user=$$(id -u):$$(id -g) dlemp_cmd_1 phpunit --coverage-html public/phpunit-coverage
