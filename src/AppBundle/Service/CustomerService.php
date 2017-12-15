<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Customer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function find($id)
    {
        $repository = $this->em->getRepository(Customer::class);

        $customer = $repository->find($id);

        return $customer;
    }

    public function findOrFail($id)
    {
        $customer = $this->find($id);

        if (is_null($customer)) {
            throw new NotFoundHttpException("Cliente não encontrado.");
        }

        return $customer;
    }

    public function search($filter)
    {
        $repository = $this->em->getRepository(Customer::class);

        $customers = $repository->search($filter);

        return $customers;
    }

    public function create($name, $bornAt)
    {
        $this->validate($name, $bornAt);

        $customer = new Customer();
        $customer
            ->setName($name)
            ->setBornAt($bornAt);

        $customer = $this->save($customer);

        return $customer;
    }

    public function update($id, $name, $bornAt)
    {
        $this->validate($name, $bornAt, $id);

        $customer = $this->findOrFail($id);

        $customer
            ->setName($name)
            ->setBornAt($bornAt);

        $customer = $this->save($customer);

        return $customer;
    }

    public function destroy($id)
    {
        $customer = $this->findOrFail($id);

        $this->em->remove($customer);
        $this->em->flush();

        return $customer;
    }

    public function save(Customer $customer) {
        $this->em->persist($customer);
        $this->em->flush();

        return $customer;
    }

    public function nameExists($name, $id = null)
    {
        $repository = $this->em->getRepository(Customer::class);

        $customer = $repository->findOneByName($name);

        return !is_null($customer) && $customer->getId() !== $id;
    }

    public function validate($name, $bornAt, $id = null)
    {
        if (empty(trim($name))) {
            throw new BadRequestHttpException("O campo 'nome' é obrigatório.");
        }

        if (empty(trim($bornAt))) {
            throw new BadRequestHttpException("O campo 'data de nascimento' é obrigatório.");
        }

        if ($this->nameExists($name, $id)) {
            throw new BadRequestHttpException("Este nome já foi cadastrado.");
        }
    }
}