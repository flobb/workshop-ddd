# Workshop-DDD

## Prerequisite for development

- [Docker](https://docs.docker.com/)
- [Docker-compose](https://docs.docker.com/)
- [docker-hostmanager](https://github.com/iamluc/docker-hostmanager)

## Install the development environment

- `cp docker-compose.override.yml.dist docker-compose.override.yml`
- Check the values of `docker-compose.override.yml` and change them if needed
- Check the values of `.env` and make a `.env.local` file with your values if needed
- Execute `make install`

Done !!!

The project should be available on: [http://app.workshop-ddd.docker/](http://app.workshop-ddd.docker/) (check your
/etc/hosts files for the right domain).

The RabbitMQ management UI is available on: [http://rabbitmq.workshop-ddd.docker:15672/](http://rabbitmq.workshop-ddd.docker:15672/).

## Running the project

Once installed you can just use `make start` to quickly turn the project up again.

Check the Makefile file for more commands.
