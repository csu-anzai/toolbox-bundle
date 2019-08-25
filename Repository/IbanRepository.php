<?php

namespace Atournayre\ToolboxBundle\Repository;

use Atournayre\ToolboxBundle\Entity\Iban;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Iban|null find($id, $lockMode = null, $lockVersion = null)
 * @method Iban|null findOneBy(array $criteria, array $orderBy = null)
 * @method Iban[]    findAll()
 * @method Iban[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IbanRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Iban::class);
    }
}
