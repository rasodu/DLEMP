#declare variables
include .env
COMPOSE = docker-compose
PHONY =


#these rules can be run during production of development mode

	#install composer dependency
vendor: composer.json | all
	docker exec --user=$$(id -u):$$(id -g) dlemp_cmd_1 composer install

	#install npm dependency
node_modules: package.json
	-npm install

	#build and start containers
PHONY += all
all: node_modules
	$(COMPOSE) build
	$(COMPOSE) up -d

	#run unittests
PHONY += test
test: vendor
	case "$(COMPOSE_FILE)" in \
		*"prod.yml"*) \
			docker exec --user=www-data:www-data dlemp_phpfpm_1 vendor/bin/phpunit --exclude-group=dev,cmd;; \
		*) \
			docker exec --user=$$(id -u):$$(id -g) dlemp_cmd_1 phpunit --exclude-group=prod \
			&& docker exec --user=$$(id -u):$$(id -g) dlemp_phpfpm_1 vendor/bin/phpunit --exclude-group=cmd,prod;; \
	esac

	#same as 'make test' but tuns the command automatically every time a file is changed.
PHONY += test-watch
test-watch:
	node node_modules/gulp/bin/gulp.js test-watch

	#remove container, network and volumes
PHONY += mostlyclean
mostlyclean:
	$(COMPOSE) down -v

	#remove container, network, volumes and locally build image. Don`t remove images that were downloaded from repository because they may be used by other projects on the machine
PHONY += clean
clean:
	$(COMPOSE) down -v --rmi local
	-$(RM) -r vendor
	-$(RM) -r node_modules
	-$(RM) -r public/app-documentation
	#-$(RM) -r public/phpunit-coverage


#these rules can only be run during development mode. They run inside cmd container.

	#enter to cmd container
PHONY += enter
enter:
	docker-compose exec --user=$$(id -u):$$(id -g) cmd bash

	#detect violations of a PSR2 coding standard
PHONY += codesniffer
codesniffer:
	docker-compose exec --user=$$(id -u):$$(id -g) cmd phpcs tests/ public/

	#automatically correct PSR2 coding standard violations
PHONY += codebeautifierandfixer
codebeautifierandfixer:
	docker-compose exec --user=$$(id -u):$$(id -g) cmd phpcbf tests/ public/

	#generate documentation from unittest code
public/app-documentation: tests
	#phpdoc template:list
	#'--template=zend' doesn't work https://github.com/gomoob/grunt-phpdocumentor/issues/12
	docker exec --user=$$(id -u):$$(id -g) dlemp_cmd_1 phpdoc -d tests/ -t public/app-documentation/

	#placeholder rule for generating code coverage report
#public/phpunit-coverage: app
#	docker exec --user=$$(id -u):$$(id -g) dlemp_cmd_1 phpunit --coverage-html public/phpunit-coverage


#declare the contents of the PHONY variable as phony.
.PHONY: $(PHONY)
