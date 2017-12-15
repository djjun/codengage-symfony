<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    /**
     * @param string $filter
     * @return array
     */
    function search($filter)
    {
        $dql = "
            SELECT
                o
            FROM
                AppBundle:Order o
            WHERE
                LOWER(o.number) LIKE LOWER(:search)
        ";

        $query = $this
            ->getEntityManager()
            ->createQuery($dql);

        $query->setParameter('search', "%$filter%");

        return $query->getResult();
    }
}
