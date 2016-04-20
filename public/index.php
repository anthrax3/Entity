<?php
require __DIR__.'/../tests/bootstrap.php';
echo "<pre>";
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
echo "</pre>";
