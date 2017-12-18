<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderProduct;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function find($id)
    {
        $repository = $this->em->getRepository(Order::class);

        $order = $repository->find($id);

        return $order;
    }

    public function findOrFail($id)
    {
        $order = $this->find($id);

        if (is_null($order)) {
            throw new NotFoundHttpException("Pedido não encontrado.");
        }

        return $order;
    }

    public function search($filter)
    {
        $repository = $this->em->getRepository(Order::class);

        $order = $repository->search($filter);

        return $order;
    }

    public function getProduts()
    {
        $repository = $this->em->getRepository(OrderProduct::class);

        $order = $repository->search();

        return $order;
    }

    public function create()
    {

        $order = new Order();

        $order = $this->save($order);

        return $order;
    }

    public function createProduct($product, $quantity, $discount, $price)
    {

        $order = new OrderProduct();

        $total = ($price*$quantity) - (($price*$quantity)*($discount/100));
        $order
            ->setName($product)
            ->setQuantity($quantity)
            ->setQuantity($discount)
            ->setPrice($price)
            ->setTotal($total);

        $order = $this->save($order);

        return $order;
    }

    public function update($id, $name, $code, $price)
    {
        $this->validate($name, $code, $price, $id);

        $order = $this->findOrFail($id);

        $order
            ->setCode($code)
            ->setName($name)
            ->setPrice($price);

        $order = $this->save($order);

        return $order;
    }

    public function destroy($id)
    {
        $order = $this->findOrFail($id);

        $this->em->remove($order);
        $this->em->flush();

        return $order;
    }

    public function save(Order $order) {
        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }

    public function codeExists($code, $id = null)
    {
        $repository = $this->em->getRepository(Order::class);

        $order = $repository->findOneByCode($code);

        return !is_null($order) && $order->getId() !== $id;
    }

    public function nameExists($name, $id = null)
    {
        $repository = $this->em->getRepository(Order::class);

        $order = $repository->findOneByName($name);

        return !is_null($order) && $order->getId() !== $id;
    }

}