<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Product;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function search($filter)
    {
        $repository = $this->em->getRepository(Product::class);

        $products = $repository->search($filter);

        return $products;
    }

    public function codeExists($code)
    {
        $repository = $this->em->getRepository(Product::class);

        $product = $repository->findOneByCode($code);

        return !is_null($product);
    }

    public function nameExists($name)
    {
        $repository = $this->em->getRepository(Product::class);

        $product = $repository->findOneByName($name);

        return !is_null($product);
    }

    public function create($code, $name, $price)
    {
        if (empty(trim($code))) {
            throw new BadRequestHttpException("O campo 'código' é obrigatório.");
        }

        if (empty(trim($name))) {
            throw new BadRequestHttpException("O campo 'nome' é obrigatório.");
        }

        if (empty(trim($price))) {
            throw new BadRequestHttpException("O campo 'preço' é obrigatório.");
        }

        if ($price > 0) {
            throw new BadRequestHttpException("O campo 'preço' deve conter valor maior que 0.");
        }

        if ($this->codeExists($name)) {
            throw new BadRequestHttpException("Este código já foi cadastrado.");
        }

        if ($this->nameExists($name)) {
            throw new BadRequestHttpException("Este nome já foi cadastrado.");
        }

        $product = new Product();
        $product
            ->setCode($code)
            ->setName($name)
            ->setPrice($price);


        $product = $this->save($product);

        return $product;
    }

    public function save(Product $product) {
        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }
}