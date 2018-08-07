<?php

namespace App\Repository;

use App\Entity\TimeEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TimeEntryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TimeEntry::class);
    }

    /**
     * An export entry hasn't already been exported and has a Milestone.
     *
     * @return array
     */
    public function findAllExportEntries()
    {
        return $this->createQueryBuilder('t')
            ->where('t.exported = :value')->setParameter('value', 0)
            ->andWhere('t.milestone IS NOT NULL')
            ->getQuery()
            ->getResult()
        ;
    }
}
