<?php

namespace AppBundle\Entity;

/**
 * BaucheRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BaucheRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByParams($causa, $area, $destino, $desde, $hasta){
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select("b")
            ->from("AppBundle:Bauche","b");
        if ($causa != -1) {
            $query->innerJoin("b.causa", "c");
        }
        $query->where("b.id IS NOT NULL");


        if ($area !=-1) {
            $query->andWhere('b.area =:area')
                ->setParameter("area", $area);
        }
        if ($destino !=-1) {
            $query->andWhere('b.destino =:destino')
                ->setParameter("destino", $destino);
        }
        if ($causa !=-1) {
            $query->andWhere('c.id =:causa')
                ->setParameter("causa", $causa);
        }

return $query->getQuery()->getResult();
    }
}
