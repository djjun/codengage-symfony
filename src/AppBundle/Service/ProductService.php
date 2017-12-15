<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Product;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function find($id)
    {
        $repository = $this->em->getRepository(Product::class);

        $product = $repository->find($id);

        return $product;
    }

    public function findOrFail($id)
    {
        $product = $this->find($id);

        if (is_null($product)) {
            throw new NotFoundHttpException("Produto não encontrado.");
        }

        return $product;
    }

    public function search($filter)
    {
        $repository = $this->em->getRepository(Product::class);

        $products = $repository->search($filter);

        return $products;
    }

    public function create($name, $code, $price)
    {
        $this->validate($name, $code, $price);

        $product = new Product();
        $product
            ->setCode($code)
            ->setName($name)
            ->setPrice($price);

        $product = $this->save($product);

        return $product;
    }

    public function update($id, $name, $code, $price)
    {
        $this->validate($name, $code, $price, $id);

        $product = $this->findOrFail($id);

        $product
            ->setCode($code)
            ->setName($name)
            ->setPrice($price);

        $product = $this->save($product);

        return $product;
    }

    public function destroy($id)
    {
        $product = $this->findOrFail($id);

        $this->em->remove($product);
        $this->em->flush();

        return $product;
    }

    public function save(Product $product) {
        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }

    public function codeExists($code, $id = null)
    {
        $repository = $this->em->getRepository(Product::class);

        $product = $repository->findOneByCode($code);

        return !is_null($product) && $product->getId() !== $id;
    }

    public function nameExists($name, $id = null)
    {
        $repository = $this->em->getRepository(Product::class);

        $product = $repository->findOneByName($name);

        return !is_null($product) && $product->getId() !== $id;
    }

    public function validate($name, $code, $price, $id = null)
    {
        if (empty(trim($code))) {
            throw new BadRequestHttpException("O campo 'código' é obrigatório.");
        }

        if (empty(trim($name))) {
            throw new BadRequestHttpException("O campo 'nome' é obrigatório.");
        }

        if (!is_numeric($price)) {
            throw new BadRequestHttpException("O campo 'preço' é obrigatório.");
        }

        if ($price <= 0) {
            throw new BadRequestHttpException("O campo 'preço' deve ser maior que 0.");
        }

        if ($price <= 0) {
            throw new BadRequestHttpException("O campo 'preço' deve conter valor maior que 0.00");
        }

        if ($this->codeExists($code, $id)) {
            throw new BadRequestHttpException("Este código já foi cadastrado.");
        }

        if ($this->nameExists($name, $id)) {
            throw new BadRequestHttpException("Este nome já foi cadastrado.");
        }
    }
}