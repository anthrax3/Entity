# Entity

### Entidade Pessoa, Endereço e Telefone.

![GPL](https://img.shields.io/badge/license-GPLv3-lightgrey.svg?style=flat-square)
![PHP](https://img.shields.io/badge/language-PHP%20%3E%3D%205.3-green.svg)
![MySQL](https://img.shields.io/badge/DB-MySQL-blue.svg?style=flat-square)
[![Build Status](https://travis-ci.org/rbarros/Entity.svg?branch=master)](https://travis-ci.org/rbarros/Entity)
[![Code Climate](https://codeclimate.com/github/rbarros/Entity/badges/gpa.svg)](https://codeclimate.com/github/rbarros/Entity)
[![Test Coverage](https://codeclimate.com/github/rbarros/Entity/badges/coverage.svg)](https://codeclimate.com/github/rbarros/Entity/coverage)

Você pode instalar com Composer (recomendado) ou manualmente.

```
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install --prefer-source
```
#Tests

Tests sem Coverage
```
$ vendor/bin/phpunit --configuration phpunit.xml
```

Tests com coverage
```
$ vendor/bin/phpunit --configuration phpunit.xml.dist
```

Coverage codeclimate
```
$ vendor/bin/phpunit --coverage-clover build/logs/clover.xml
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


## Documentation
_(Coming soon)_

## Examples
```php
require 'vendor/autoload.php';

$person = new Entity\Person('42.986.576/0001-10');
$person->setFirstName('Razão Social');
$person->setLastName('Nome Fantasia');

$telephone = new Entity\Telephone\Number('comercial', '0000000000');

$address = new Entity\Address();
$address->setStreet('Street 1')
        ->setNumber('Number 1')
        ->setComplement('Complement 1')
        ->setSuburb('Suburb 1')
        ->setZoneCode('99099000')
        ->setZone('RS')
        ->setCountry('Brasil')
        ;
```

## Release History

* **v1.3.5** - 2016-05-18
   - Fix bug Telephone and Email instances null.

* **v1.3.4** - 2016-05-13
   - Add Code Climate and Test Coverage.
   - Add codeclimate.
   - Fix README tests.
   - Remove composer.lock
   - Fix travis phpunit
   - Fix conflicts phpunit

* **v1.3.3** - 2016-05-13
   - Fix tests juridical
   - Add mask to other numbers

* **v1.3.2** - 2016-05-10
   - Update version 1.3.2
   - Add id number and complement.
   - Alter version phpunit.
   - Fix bug phpunit travis
   - Update phpunit.xml.

* **v1.3.1** - 2016-05-09
   - Update version.
   - Fix bug test Person

* **v1.3.0** - 2016-05-09
   - Add setId and getId Address

* **v1.2.3** - 2016-05-09
   - Fix psr-4 composer travis.

* **v1.2.2** - 2016-05-09
   - Fix psr-4.
   - Fix tests.
   - Add getType email and telephone
   - Fix bug psr-4 composer.json
   - Fix travis.

* **v1.2.1** - 2016-05-09
   - Update version.
   - Update validate juridical.
   - Update test juridical and add mysql.
   - Add db mysql.
   - Fix bug tests/bootstrap
   - Fix bug tests travis.

* **v1.2.0** - 2016-04-20
   - Update version composer.
   - Fix bug tests.
   - Update config travis.
   - Update public/index.php
   - Fix bug README.md
   - Add travis
   - Add Email.

* **v1.1.0** - 2016-04-20
   - Add Address and Telephone.
   - Add FirstName and LastName in person.

* **v1.0.0** - 2016-04-15
   - Update tests.
   - Changed pattern of class.
   - Started person entity.
   - Initial release.

##License

![GPL](http://www.gnu.org/graphics/gplv3-88x31.png)
