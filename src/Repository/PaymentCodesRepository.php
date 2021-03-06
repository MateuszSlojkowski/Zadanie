<?php

namespace App\Repository;

use App\Entity\PaymentCodes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaymentCodes>
 *
 * @method PaymentCodes|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentCodes|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentCodes[]    findAll()
 * @method PaymentCodes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentCodesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentCodes::class);
    }

    public function add(PaymentCodes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PaymentCodes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
