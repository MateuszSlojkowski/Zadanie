<?php

namespace App\Repository;

use App\Entity\InvoiceLines;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InvoiceLines>
 *
 * @method InvoiceLines|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvoiceLines|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvoiceLines[]    findAll()
 * @method InvoiceLines[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceLinesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvoiceLines::class);
    }

    public function add(InvoiceLines $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InvoiceLines $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
