<?php

namespace App\Repository;

use App\Entity\InvoiceHeader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InvoiceHeader>
 *
 * @method InvoiceHeader|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvoiceHeader|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvoiceHeader[]    findAll()
 * @method InvoiceHeader[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceHeaderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvoiceHeader::class);
    }

    public function add(InvoiceHeader $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InvoiceHeader $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
