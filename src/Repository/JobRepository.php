<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Job>
 *
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository implements JobRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    public function save(Job $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Job $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCustomerId(): array
    {
        // TODO: Implement findByCustomerId() method.

        return [];
    }

    public function findAllJobs(JobSearchCriteria $searchCriteria = null): array
    {
        $queryBuilder = $this->createQueryBuilder('j')
            ->select(['j', 'c', 's'])
            ->join('j.customer', 'c')
            ->join('j.site', 's');

        if (!is_null($searchCriteria)) {
            $count = 0;
            foreach ($searchCriteria->getCriterias() as $field => $criteria) {
                // TODO should ensure these are safe
                $operator = key($criteria);
                $value = $criteria[$operator];

                $queryBuilder
                    ->andWhere("$field $operator :value_" . $count)
                    ->setParameter("value_" . $count, $value);

                $count++;
            }
        }

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }
}
