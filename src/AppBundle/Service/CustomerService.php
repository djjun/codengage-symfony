<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Customer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CustomerService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function search($filter)
    {
        $repository = $this->em->getRepository(Customer::class);

        $customers = $repository->search($filter);

        return $customers;
    }

    public function nameExists($name)
    {
        $repository = $this->em->getRepository(Customer::class);

        $customer = $repository->findOneByName($name);

        return !is_null($customer);
    }

    public function create($name, $bornAt)
    {
        if (empty(trim($name))) {
            throw new BadRequestHttpException("O campo 'nome' é obrigatório.");
        }

        if (empty(trim($bornAt))) {
            throw new BadRequestHttpException("O campo 'data de nascimento' é obrigatório.");
        }

        if ($this->nameExists($name)) {
            throw new BadRequestHttpException("Este nome já foi cadastrado.");
        }

        $customer = new Customer();
        $customer
            ->setName($name)
            ->setBornAt($bornAt);


        $customer = $this->save($customer);

        return $customer;
    }

    public function save(Customer $customer) {
        $this->em->persist($customer);
        $this->em->flush();

        return $customer;
    }
}