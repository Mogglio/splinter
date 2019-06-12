<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ConfigurationRepository extends EntityRepository
{
    public function getConfigurationByBaseOs($image_os)
    {
        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.base_os = :image_os')
            ->setParameter('image_os', $image_os)
            ->getQuery();
        return $qb->execute();
    }
}