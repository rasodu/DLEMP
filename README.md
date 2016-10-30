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
    - Uncomment ```COMPOSE_FILE``` for development ```.env```, then run ```docker-compose up -d``` - Run project in development mode
        - ```phpunit --exclude-group prod``` - Run unittests in `cmd` container
        - ```vendor/bin/phpunit --exclude-group cmd,prod``` - Run unittests in `phpfpmdev` container
    - Uncomment ```COMPOSE_FILE``` for production ```.env```, then run ```docker-compose up -d``` - Run project in production mode
        - ```vendor/bin/phpunit --exclude-group dev,cmd``` - Run unittests in `phpfpm` container
- Stop project
    - ```docker-compose down [--rmi local] -v```


**Explain script execution time limit**
|    | NGINX | phpfpm | cli
| --- | --- | --- | --- |
| Production | 10 minutes | 1 minutes | Unlimited |
| Development | 10 minutes | 10 minute | Unlimited |
- NGINX connection that download large static files over slow connection may stay open for up to 10 minutes.
- phpfpm execution time during production will be limited to 60 seconds. You should queue time consuming tasks.
```
//Optionally if you want to increase execution time for a single script, then you may always use
set_time_limit(<time-in-seconds>)
// or
ini_set('max_execution_time', <time-in-seconds>)
```
- Laravel queue that run using cli will execute without any time limit.
- xDebug may run for up to 10 minutes during development.
