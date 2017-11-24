<?php

namespace Hgabka\KunstmaanPopupBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PopupRepository extends EntityRepository
{
    public function getPopups($locale)
    {
        return $this->getPopupsQb($locale)
                    ->getQuery()
                    ->getResult()
            ;
    }

    public function countPopups($locale)
    {
        return $this->getPopupsQb($locale)
                    ->select('COUNT(b.id)')
                    ->getQuery()
                    ->getSingleScalarResult()
            ;
    }

    protected function getPopupsQb($locale)
    {
        return $this
            ->createQueryBuilder('b')
            ->leftJoin('b.media', ' m')
            ->andWhere('b.start IS NULL OR b.start <= :now')
            ->andWhere('b.end IS NULL OR b.end >= :now')
            ->setParameter('now', new \DateTime())
            ->andWhere('b.locale = :locale OR b.locale IS NULL')
            ->andWhere('b.media IS NOT NULL OR b.html IS NOT NULL')
            ->setParameter(':locale', $locale)
        ;
    }
}
