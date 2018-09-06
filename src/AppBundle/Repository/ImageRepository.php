<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Paginate through all images
     *
     * @param int $limit Items per page
     * @param int $page Current page
     * @param string $order Sort order, either 'ASC' or 'DESC'
     *
     * @return Paginator
     */
    public function paginateAll($limit, $page = 1, $order = 'ASC')
    {
        $queryBuilder = $this->createQueryBuilder('i');
        $queryBuilder->orderBy('i.id', $order);
        $paginator = new Paginator($queryBuilder);
        $paginator
            ->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }
}
