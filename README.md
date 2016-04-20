# Entity
### Entidade Pessoa, Endereço e Telefone.

Você pode instalar com Composer (recomendado) ou manualmente.

```
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install --prefer-source
```
#Tests

Tests sem Coverage

```
$ bin/phpunit --configuration phpunit.xml
```
Tests com coverage
```
$ bin/phpunit --configuration phpunit.xml.dist
```

# Todo
- Person
 - Adicionar Container em Person
 - Adicionar extensão para validação
 - Adicionar tradução para o retorno dos erros
 - Adicionar mascaras para os idiomas
- Telephone
 - Adicionar tradução para o retorno dos erros
 - Adicionar mascaras para os idiomas
