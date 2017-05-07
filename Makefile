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
all: docker_build_images node_modules
	$(COMPOSE) up -d

PHONY += docker_build_images
docker_build_images:
	#images pushed to docker hub
	docker build --build-arg DLEMP_BASE_DIR=$(DLEMP_BASE_DIR) --build-arg DLEMP_PHP_VERSION=${DLEMP_PHP_VERSION} --tag rasodu/phpfpmdevlaravel:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/$(DLEMP_PHP_VERSION)phpfpmdevlaravel .
	docker build --tag rasodu/cmdlaravel:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/cmd .
	docker run --rm --user=$$(id -u):$$(id -g) -v $$(pwd):/usr/share/nginx/WEBAPP rasodu/cmdlaravel:dev composer install
	docker build --build-arg DLEMP_BASE_DIR=$(DLEMP_BASE_DIR) --build-arg DLEMP_PHP_VERSION=${DLEMP_PHP_VERSION} --tag rasodu/phpfpmlaravel:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/$(DLEMP_PHP_VERSION)phpfpmlaravel .
	docker build --build-arg DLEMP_BASE_DIR=$(DLEMP_BASE_DIR) --tag rasodu/httpbackendlaravelnginx:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/httpbackendlaravelnginx .
	docker build --build-arg DLEMP_BASE_DIR=$(DLEMP_BASE_DIR) --tag rasodu/httpsnginx:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/httpsnginx .
	docker build --build-arg DLEMP_BASE_DIR=$(DLEMP_BASE_DIR) --tag rasodu/httpnginx:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/httpnginx .
	docker build --build-arg DLEMP_BASE_DIR=$(DLEMP_BASE_DIR) --tag rasodu/cron:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/cron .
	docker build --build-arg DLEMP_BASE_DIR=$(DLEMP_BASE_DIR) --tag rasodu/broadcasterlaravelechoserver:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/broadcasterlaravelechoserver .
	docker build --build-arg DLEMP_BASE_DIR=$(DLEMP_BASE_DIR) --tag rasodu/pusherlaravel:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/pusherlaravel .
	docker build --build-arg DLEMP_BASE_DIR=$(DLEMP_BASE_DIR) --tag rasodu/s3mock:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/s3mock .
	docker build --build-arg DLEMP_BASE_DIR=$(DLEMP_BASE_DIR) --tag rasodu/certbot:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/httpnginx .
	#images not pushed to docker hub
	docker build --build-arg DLEMP_BASE_DIR=$(DLEMP_BASE_DIR) --tag rasodu/6nodejs:dev -f $(DLEMP_BASE_DIR)docker/dockerfile/6nodejs .


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
