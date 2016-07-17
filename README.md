# DLEMP

**Few features will not be implemented in
this project. See the list below for more
information. Please don't create pull
request to add these features.**
- Only try to implement stateless
services in the project.
    - MySQL will not be made scalable.
    This service is included to allow
    faster setup of development
    environment and allow very basic
    quick production setup. In
    production you should think about
    using managed MySQL from Google or
    AWS. Though we will provide second
    account on MySQL server that will
    have read-only access to the server.
    You can use this account as read-only
    replication of MySQL server.
    - Local storage will not be made
    scalable. You should try to use
    Google Object Storage or S3. Though
    we will provide FakeS3 for you to
    use in development.
- SMTP server will not be provided
during production. Many VPS provider
block SMTP ports(Including Google, AWS
and Digital Ocean). Use service like
Mailgun for SMTP during production.
Though we will provide Mailtrap for you
to use in development.

**How do I run/stop this project**
- Run project
    - ```docker-compose up -d``` - Run project in development mode
        - ```phpunit --exclude-group prod``` - Run unittests in `cmd` container
        - ```vendor/bin/phpunit --exclude-group cmd,prod``` - Run unittests in `phpfpmdev` container
    - ```docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d``` - Run project in production mode
        - ```vendor/bin/phpunit --exclude-group dev,cmd``` - Run unittests in `phpfpm` container
- Stop project
    - ```docker-compose down [--rmi local] -v```
