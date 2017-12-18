<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OrderProductRepository extends EntityRepository
{
    /**
     * @return array
     */
    function search()
    {
        $dql = "
            SELECT
                o
            FROM
                AppBundle:OrderProduct o
        ";

        $query = $this
            ->getEntityManager()
            ->createQuery($dql);

        return $query->getResult();
    }
}
