<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderProduct;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OrderService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function search($filter)
    {
        $repository = $this->em->getRepository(Order::class);

        $order = $repository->search($filter);

        return $order;
    }

    public function create($name, $bornAt)
    {
        if (empty(trim($name))) {
            throw new BadRequestHttpException("O campo 'nome' é obrigatório.");
        }

        if (empty(trim($bornAt))) {
            throw new BadRequestHttpException("O campo 'data de nascimento' é obrigatório.");
        }

        $order = new Order();
        $order
            ->setName($name)
            ->setBornAt($bornAt);


        $order = $this->save($order);

        return $order;
    }

    public function save(Order $order) {
        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }
}