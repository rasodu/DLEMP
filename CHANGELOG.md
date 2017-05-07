# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

### Changed
- Pull Letsencrypt latest image because tag no longer exist(2017-04-23)
- Entry point for the PHPFPM image is cleared(because at this point AWS Elastic Beanstalk doesn't support clearing this field. So it is not possible to change command for the image if entrypoint for the image is not cleared.)(2017-02-23)
- Add DynamoDB for local development(2017-02-18)
- Turn off access log in PHPFPM(2017-02-18)
- Pusher ports changed (2017-01-28)
- Some of the service name changed (2016-12-10)
- nginxhttps service is split into nginxhttps and httpbackend (2016-12-05)

### Added
- docker-compose no longer responsible for building images(2017-05-06)
- PHP 7.1 support is added (2017-01-28)
- Laravel Echo server support is added (2017-01-26)
- Nodejs server support is added (2017-01-22)
- Added CHANGELOG.md file (2016-11-14)
- Support for make build system is added (2016-11-14)
- Increase NGINX cgi timeout (2016-10-31)
- Downgrade elasticsearch to version 2.4.1 (2016-10-30)
- Letsencrypt official docker image is used (2016-10-30)
- Set default execution time in NGINX and phpfpm (2016-10-29)
- Default time on php.ini is set to UTC (2016-10-29)
- Elasticsearch(version 5.0.0) container is added.

### Fixed
- DynamoDB unit test is complete (2017-02-26)
