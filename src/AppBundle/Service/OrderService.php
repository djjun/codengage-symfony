<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

class OrderService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}