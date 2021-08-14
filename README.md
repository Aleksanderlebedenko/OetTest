docker-symfony
==============

This is a complete stack for running Symfony 5 (latest version), PHP8 using docker-compose tool.

# Installation

First, clone this repository:

```bash
$ git clone git@github.com:Aleksanderlebedenko/OetTest.git
```

Then, run:

```bash
$ docker-compose up
```

You are done, you can visit your Symfony application on the following URL: `http://symfony.localhost`

_Note :_ you can rebuild all Docker images by running:

```bash
$ docker-compose build
```
# Environment Customizations

# Read logs

You can access Nginx and Symfony application logs in the following directories on your host machine:

* `logs/nginx`
* `logs/symfony`

# Use xdebug!

Start by updating your docker-compose .env file with `PHP_XDEBUG_MODE=debug` (or any other configuration you need as seen in the [Xdebug documentation](https://xdebug.org/docs/all_settings#mode)).
You will need to re-build the php container for this value to take effect.

Configure your IDE to use port 5902 for XDebug.
Docker versions below 18.03.1 don't support the Docker variable `host.docker.internal`.  
In that case you'd have to swap out `host.docker.internal` with your machine IP address in php-fpm/xdebug.ini.
