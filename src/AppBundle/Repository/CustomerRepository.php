<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    /**
     * @param string $filter
     * @return array
     */
    function search($filter)
    {
        $dql = "
            SELECT
                c
            FROM
                AppBundle:Customer c
            WHERE
                LOWER(c.name) LIKE LOWER(:search) OR 
                c.bornAt LIKE :search
        ";

        $query = $this
            ->getEntityManager()
            ->createQuery($dql);

        $query->setParameter('search', "%$filter%");

        return $query->getResult();
    }
}
