# Auto Maintenance Tracker

Simple app that can register and track registered cars their maintenance tasks

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

For installing this project you need to have docker and only docker :)

If you want to install project without docker you need to have:
- apache/nginx 
- php 7
- npm
- node
- mysql server
- gulp

### Installing

1. Clone project on your local PC
```bash
git clone "https://github.com/igariok1990/auto-maintenance-tracker"
```
2. Rename this file: db.env.dist
```bash
mv db.env.dist db.env
```
3. Add in your local PC, in hosts: 
```
127.0.0.1    auto.local
```
4. Run form project root:
```bash
sh init.sh
```

Now you can access your project:
```
http://auto.local
```

### Angular build
Build js (prod mode)
```bash
cd resource/auto-app
npm run build:prod:aot
```
Note:
For dev mode you have to run that:
```bash
cd resource/auto-app
npm start
```
And add in your config/autoload/local.php
```php
    'angular_development_mode' => true
```

```
## Running the tests

You can run tests easy inside docker container:

1. Running unit tests:
```bash
docker-compose -f docker-compose-tests.yml run unit
```
2. Running functional tests:
```bash
docker-compose -f docker-compose-tests.yml run functional
```

### Coding Standard
For coding standard I used codesniffer

How to run it:
```bash
docker run --rm -v $(pwd):/app -v ~/.ssh:/root/.ssh composer/composer run cs-check
```
Automatically fix:
```bash
docker run --rm -v $(pwd):/app -v ~/.ssh:/root/.ssh composer/composer run cs-fix
```

## Deployment

Deploying this app on server running docker is quite easy (you have to run installation steps)

## Built With

* [Zend Framework](https://framework.zend.com/learn) - The web framework used for server side
* [Doctrine](http://docs.doctrine-project.org/en/latest/) -  PHP libraries focused on providing persistence services and related functionality
* [HAL](http://stateless.co/hal_specification.html) - Rest API format
* [Angular](https://angular.io/docs) - The web framework used for UI
* [Angular Material](https://material.angular.io/) - Material design componets for angular
* [webpack](http://webpack.github.io/docs/) - For building angular app
* [Docker](https://docs.docker.com/) - For running project/tests


## Authors

* **Igor Ciobanu** - [igariok1990](https://github.com/igariok1990)

## License

This project is licensed under the MIT License.

## Database Schema

![](database/db_schema.jpg?raw=true)

