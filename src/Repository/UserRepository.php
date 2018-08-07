<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    private $queryStorage = array();

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $key = serialize($criteria);

        if (!isset($this->queryStorage[$key])) {
            $this->queryStorage[$key] = parent::findOneBy($criteria, $orderBy);
        }
        return $this->queryStorage[$key];
    }
}
