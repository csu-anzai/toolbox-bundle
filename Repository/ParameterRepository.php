<?php

namespace Atournayre\ToolboxBundle\Repository;

use Atournayre\ToolboxBundle\Entity\Parameter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Parameter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parameter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parameter[]    findAll()
 * @method Parameter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParameterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Parameter::class);
    }

    /**
     * @param string $code
     *
     * @return object|null
     */
    public function findOneByCode(string $code): object
    {
        return $this->findOneBy(['code' => $code]);
    }
}
