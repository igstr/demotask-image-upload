<?php

namespace AppBundle\Service;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginateService
{
    /**
     * Make paginated queries
     *
     * @param QueryBuilder $queryBuilder
     * @param int $limit Items per page
     * @param int $page Current page number
     *
     * @return Paginator Created paginator
     */
    public function paginate(QueryBuilder $queryBuilder, $limit, $page = 1)
    {
        $paginator = new Paginator($queryBuilder);
        $paginator
            ->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }

    /**
     * Count paginator pages
     *
     * @param Paginator $paginator
     * @param int $limit Items per page
     *
     * @return int
     */
    public function countPages(Paginator $paginator, $limit)
    {
        $count = ceil(count($paginator) / $limit);
        $count = max(1, $count); // No less than 1

        return $count;
    }
}