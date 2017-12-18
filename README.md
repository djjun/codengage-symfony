# Symfony Teste Codengage
Teste da Codengage para projeto em Symfony Framework.

## Tecnologias usadas
- PHP 7.2
- Symfony 2.7

## Start server
```bash
$ composer install
$ docker-compose up -d
$ php app/console server:start
$ php app/console doctrine:migrations:migrate
```

## Tests
Não foi possivel aplicar os testes nos services, apenas no default.

## Observações
As implementações foram feitas em pouco mais de 8h de trabalho, tendo apenas o básico de aprendizado com symfony nas versões mais novas (< v3).
