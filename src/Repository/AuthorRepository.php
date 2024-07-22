<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
        * @return Author[] Returns an array of Author objects
        */
    public function withoutBooks(): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.books', 'b')
            ->where('b.id IS NULL')
            ->getQuery()
            ->getResult()
        ;
    }
}
