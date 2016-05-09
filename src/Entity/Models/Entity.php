<?php namespace Entity\Models;

class Entity
{
    protected $core;
    public $customer;
    public $telephone;
    public $email;
    public $address;

    public function __construct()
    {
        $this->core = DB::getInstance();
        $this->customer = new Customer();
        $this->telephone = new Telephone();
        $this->email = new Email();
        $this->address = new Address();
    }

    /*
    SET foreign_key_checks = 0;
    TRUNCATE TABLE `address`;
    TRUNCATE TABLE `address_complement`;
    TRUNCATE TABLE `address_number`;
    TRUNCATE TABLE `customer`;
    TRUNCATE TABLE `customer_address`;
    TRUNCATE TABLE `customer_email`;
    TRUNCATE TABLE `customer_field`;
    TRUNCATE TABLE `customer_filed_value`;
    TRUNCATE TABLE `customer_person`;
    TRUNCATE TABLE `customer_person_juridical`;
    TRUNCATE TABLE `customer_person_natural`;
    TRUNCATE TABLE `customer_telephone`;
    TRUNCATE TABLE `customer_user`;
    TRUNCATE TABLE `telephone`;
    TRUNCATE TABLE `email`;
    */

    public function create($entity = null)
    {
        $return = array();
        /**
         * Salva os dados do cliente no banco de dados
         */
        $return['customer'] = $this->customer->create($entity->person);

        if (!$this->customer->getError()) {
            $return['telephoneComercial'] = $this->telephone->createNumber(
                'comercial',
                $entity->telephone->getNumber('comercial')
            );
            if (!$this->telephone->getError()) {
                $this->customer->createTelephone($this->telephone->getId());
            }

            // $return['celular'] = $this->telephone->createNumber(
            //     'celular',
            //     $entity->telephone->getNumber('celular')
            // );
            // if (!$this->telephone->getError()) {
            //     $this->customer->createTelephone($this->telephone->getId());
            // }

            $return['email'] = $this->email->createAddress(
                'comercial',
                $entity->email->getAddress('comercial')
            );
            if (!$this->email->getError()) {
                $this->customer->createEmail($this->email->getId());
            }

            $return['address'] = $this->address->create($entity->address);
            if (!$this->address->getError()) {
                $this->customer->createAddress(
                    $this->address->getId(),
                    $this->address->getNumberId(),
                    $this->address->getComplementId()
                );
            }

            $return['user'] = $this->customer->createUser($entity->userId);
        }
        return $return;
    }

    public function find($userId = null)
    {
        $entity = new \stdClass();

        $customerUser = $this->customer->getCustomerUser($userId);

        if (!empty($customerUser)) {
            $customer = $this->customer->find($customerUser['id']);

            if (!empty($customer)) {
                $entity->person = new \Entity\Person($customer['primaryDoc']);
                $entity->person
                       ->setFirstName($customer['firstName'])
                       ->setLastName($customer['lastName']);

                $entity->telephone = new \Entity\Telephone\Number($customer['telephoneType'], $customer['telephoneNumber']);
                $entity->email = new \Entity\Email($customer['emailType'], $customer['emailAddress']);

                $entity->address = new \Entity\Address();
                $entity->address
                       ->setType($customer['addressType'])
                       ->setStreet($customer['street'])
                       ->setNumber($customer['number'])
                       ->setComplement($customer['complement'])
                       ->setSuburb($customer['suburb'])
                       ->setZoneCode($customer['zoneCode'])
                       ->setCity($customer['city'])
                       ->setZone($customer['zone'])
                       ->setCountry($customer['country']) // ID Brasil
                       ;
            }
        }

        return $entity;
    }
}
