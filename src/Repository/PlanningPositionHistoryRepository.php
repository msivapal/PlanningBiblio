<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

use App\Model\PlanningPositionHistory;

class PlanningPositionHistoryRepository extends EntityRepository
{
    public function undoable($date, $site)
    {
        if (!$date || !$site) {
            return array();
        }

        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();

        $history = $qb->select(array('h'))
            ->from(PlanningPositionHistory::class, 'h')
            ->where('h.date = :date')
            ->andWhere('h.site = :site')
            ->andWhere('h.undone = :undone')
            ->andWhere('h.archive = :archive')
            ->setParameter('date', $date)
            ->setParameter('site', $site)
            ->setParameter('undone', 0)
            ->setParameter('archive', 0)
            ->orderBy('h.id', 'DESC')
            ->getQuery()
            ->getArrayResult();

        return $history;
    }

    public function redoable($date, $site)
    {
        if (!$date || !$site) {
            return array();
        }

        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();

        $history = $qb->select(array('h'))
            ->from(PlanningPositionHistory::class, 'h')
            ->where('h.date = :date')
            ->andWhere('h.site = :site')
            ->andWhere('h.undone = :undone')
            ->andWhere('h.archive = :archive')
            ->setParameter('date', $date)
            ->setParameter('site', $site)
            ->setParameter('undone', 1)
            ->setParameter('archive', 0)
            ->orderBy('h.id', 'ASC')
            ->getQuery()
            ->getArrayResult();

        return $history;
    }
}
