<?php

namespace App\JoboardBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * JobRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JobRepository extends EntityRepository
{
    public function getActiveJobs($categoryId = null, $max = null)
    {
        $qb = $this->createQueryBuilder('j')
            ->where('j.expires_at > :date')
            ->setParameter('date', date('Y-m-d H:i:s', time()))
            ->orderBy('j.expires_at', 'DESC');

        if($max) {
            $qb->setMaxResults($max);
        }

        if($categoryId) {
            $qb->andWhere('j.category = :category_id')
                ->setParameter('category_id', $categoryId);
        }

        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function getActiveJob($id)
    {
        $query = $this->createQueryBuilder('j')
            ->where('j.id = :id')
            ->setParameter('id', $id)
            ->andWhere('j.expires_at > :date')
            ->setParameter('date', date('Y-m-d H:i:s', time()))
            ->setMaxResults(1)
            ->getQuery();

        try {
            $job = $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $job = null;
        }

        return $job;
    }

    public function countActiveJobs($categoryId = null)
    {
        $qb = $this->createQueryBuilder('j')
            ->select('count(j.id)')
            ->where('j.expires_at > :date')
            ->setParameter('date', date('Y-m-d H:i:s', time()));

        if($categoryId)
        {
            $qb->andWhere('j.category = :category_id')
                ->setParameter('category_id', $categoryId);
        }

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

}
