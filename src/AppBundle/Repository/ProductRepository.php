<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /**
     * @param string $filter
     * @return array
     */
    function search($filter)
    {
        $dql = "
            SELECT
                p
            FROM
                AppBundle:Product p
            WHERE
                LOWER(p.code) LIKE LOWER(:search) OR 
                LOWER(p.name) LIKE LOWER(:search) OR 
                p.price LIKE :search
        ";

        $query = $this
            ->getEntityManager()
            ->createQuery($dql);

        $query->setParameter('search', "%$filter%");

        return $query->getResult();
    }
}
