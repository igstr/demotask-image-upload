<?php

namespace AppBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get all images in specified order
     *
     * @param string $order Sort order, either 'ASC' or 'DESC'
     *
     * @return QueryBuilder
     */
    public function getAllInOrder($order = 'ASC')
    {
        $queryBuilder = $this->createQueryBuilder('i');
        $queryBuilder->orderBy('i.id', $order);

        return $queryBuilder;
    }
}
