<?php

namespace AppBundle\Service;

use AppBundle\Entity\Customer;

class CustomerService
{
    public function create($name, $bornAt)
    {
        $customer = new Customer();
        $customer
            ->setName($name)
            ->setBornAt($bornAt);

        $em = $this
            ->getDoctrine()
            ->getManager();


        $em->persist($customer);
        $em->flush();

        return $customer;
    }
}