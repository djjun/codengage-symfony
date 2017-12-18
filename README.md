#Symfony

##Start server
```bash
$ composer install
$ docker-compose up -d
$ php app/console server:start
$ php app/console doctrine:migrations:migrate
```