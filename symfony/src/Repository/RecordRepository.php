<?php

namespace App\Repository;

use App\Entity\Record;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Record|null find($id, $lockMode = null, $lockVersion = null)
 * @method Record|null findOneBy(array $criteria, array $orderBy = null)
 * @method Record[]    findAll()
 * @method Record[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Record::class);
    }

    /**
     * @param Record $record
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     */
    public function remove(Record $record): void
    {
        $em = $this->getEntityManager();
        $em->remove($record);
        $em->flush();
    }

    /**
     * @param Record $record
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     */
    public function add(Record $record): void
    {
        $em = $this->getEntityManager();
        $em->persist($record);
        $em->flush();
    }

    public function findByNameAndDescription(string $name = '', string $description = '')
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Record r
            WHERE r.name like :name
            AND r.description LIKE :description
            ORDER BY r.artist ASC, r.name ASC'
        )
            ->setParameter('name', "%$name%")
            ->setParameter('description', "%$description%");

        return $query->getResult();

    }
}
