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

#### Recommendation for updating base image and other software installed in final images
- **Philosophy**
    - Developers care about PHP version in phpfpm/phpfpmdev/cmd image and Node.js version in cmd image. Version of these software effects the code that developers write. We refer these kinds of softwares as *core services/softwares*.
    - Developer don't care about the versions of services that don't directly effect their code. For example, version of NGINX used in http/https and version of Node.js used in pusher don't directly effect the code that the developers are writing. Developers just want these services to work without knowing details about these services. We will refer to these kind of software as *supporting services/software*.
    - This project aims to build stable development environment. Therefore we will use stable base for *supporting services/softwares* to make sure that they work without any kind of hiccup. Use LTS components to build them if possible.
- **Individual components**
    - **Core software**
        - Version of **php** image used *phpfpm*, *phpfpmdev* and *cmd* : We support all major versions of PHP that are not in 'End of life'. We will support one minor version for each major version of PHP. (If people want to use older version of PHP(minor or major), then they may use old version of this package.) http://php.net/supported-versions.php
        - Versin of **Node.js** installed on *cmd* : Not decided yet
    - **Supporting software**
        - Version of **NGINX** image used to build *http* and *https* : Each even minor number of NGINX release is stable version of NGINX and each odd minor number release of NGINX is mainline version of NGINX. We will use stable release NGINX for these two services.
        - Version of **Node.js** image used to build *pusher* : Only use LTS releases. LTS release is used after they enter 'Active LTS' state. https://github.com/nodejs/LTS
        - Version of **alpine** image used in *cron* : This service is not internet facing. So we will not update it frequently.
        - Version of **letsencypt** image used in *certbot* : This service is not internet facing. So we will not update it frequently.
