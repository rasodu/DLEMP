#### Install Software
- *Required*
    - **git**
    - **docker-compose** : 1.8.1 or newer.
    - **docker** : any locally installed version of docker supported by installed docker-compose. (We need to install docker locally because we are using docker volume.)
    - **/etc/hosts** : add an entry '127.0.0.1	webapp.dev' to point webapp.dev to docker host.
- *Optional*
    - **make** : 3.81.1 or newer
    - **bash** : commands in Makefile may not work correctly on a shell other than bash.

#### Coding Style
- **PHP** : We use PSR2 code for all PHP code in the project
