<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;

class ProductService
{
    public function create($name, $code, $price)
    {
        $product = new Product();
        $product
            ->setName($name)
            ->setCode($code)
            ->setCode($price);

        $em = $this
            ->getDoctrine()
            ->getManager();


        $em->persist($product);
        $em->flush();

        return $product;
    }
}