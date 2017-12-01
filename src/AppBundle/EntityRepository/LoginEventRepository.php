<?php

namespace AppBundle\EntityRepository;

use AppBundle\Entity\User;

class LoginEventRepository extends \Doctrine\ORM\EntityRepository
{
    public function countLoginAttempts(User $user, \DateTime $since = null, $successfulLogin = true)
    {
        $qb = $this
            ->createQueryBuilder('le')
            ->where('le.user = :user')
            ->setParameter('user', $user)
            ->select('COUNT(le.id) AS login_count')
            ->andWhere('le.successful = :success')
            ->setParameter('success', (bool)$successfulLogin)
        ;

        if ($since !== null) {
            $qb
                ->andWhere('le.datetime >= :date_time')
                ->setParameter('date_time', $since)
            ;
        }

        return $qb
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function getLastFailedLogins(User $user, $count)
    {
        $qb = $this
            ->createQueryBuilder('le')
            ->andWhere('le.user = :user')
            ->setParameter('user', $user)
            ->andWhere('le.successful = false')
            ->setMaxResults($count)
        ;

        return $qb
            ->getQuery()
            ->execute()
        ;
    }
}
