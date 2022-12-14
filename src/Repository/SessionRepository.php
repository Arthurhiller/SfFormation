<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function add(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findInscrit($session_id)
    {
        $entityManager = $this->getEntityManager();
        // Récupère la méthode createQueryBuilder()
        $sub = $entityManager->createQueryBuilder();
        
        // Stock le createQueryBuilder dans $qb
        $qb = $sub;
            // Select tous les stagiaires
        $qb->select('s')
            // Qui sont dans l'entity stagiaire avec un allias 's'
            ->from('App\Entity\Stagiaire', 's')
            // Jointure sur la table stagiaire.session avec un allias 'se'
            ->leftJoin('s.sessions', 'se')
            // Quand : stagiaire.session = id
            ->where('se.id = :id');

        $sub = $entityManager->createQueryBuilder();
            // Select tous les stagiaires
        $sub->select('st')
            // Qui sont dans l'entity stagiaire avec un allias 'st'
            ->from('App\Entity\Stagiaire', 'st')
            // Quand il n'y à pas stagaire.id
            ->where($sub->expr()->in('st.id', $qb->getDQL()))
            // Déclare le paramètre de la requête (contre les injections SQL)
            ->setParameter('id', $session_id)
            // Trier par les noms des stagiaires
            ->orderBy('st.nom');
        
        $query = $sub->getQuery();
        return $query->getResult();
    }

    public function findNonInscrits($session_id)
    {
        // Récupère l'entityManager
        $entityManager = $this->getEntityManager();
        // Récupère la méthode createQueryBuilder()
        $sub = $entityManager->createQueryBuilder();
        
        // Stock le createQueryBuilder dans $qb
        $qb = $sub;
            // Select tous les stagiaires
        $qb->select('s')
            // Qui sont dans l'entity stagiaire avec un allias 's'
            ->from('App\Entity\Stagiaire', 's')
            // Jointure sur la table stagiaire.session avec un allias 'se'
            ->leftJoin('s.sessions', 'se')
            // Quand : stagiaire.session = id
            ->where('se.id = :id');

        $sub = $entityManager->createQueryBuilder();
            // Select tous les stagiaires
        $sub->select('st')
            // Qui sont dans l'entity stagiaire avec un allias 'st'
            ->from('App\Entity\Stagiaire', 'st')
            // Quand il n'y à pas stagaire.id
            ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
            // Déclare le paramètre de la requête (contre les injections SQL)
            ->setParameter('id', $session_id)
            // Trier par les noms des stagiaires
            ->orderBy('st.nom');
        
        $query = $sub->getQuery();
        return $query->getResult();
    }

    public function findProgrammes($session_id)
    {
        // Récupère l'entityManager
        $entityManager = $this->getEntityManager();
        // Récupère la méthode createQueryBuilder()
        $sub = $entityManager->createQueryBuilder();
        
        // Stock le createQueryBuilder dans $qb
        $qb = $sub;
            // Select tous les programmes
        $qb->select('p')
            // Qui sont dans l'entity programme avec un allias 'p'
            ->from('App\Entity\Programme', 'p')
            // Jointure sur la table programme.session avec un allias 'se'
            ->leftJoin('p.sessions', 'se')
            // Quand : programme.session = id
            ->where('se.id = :id');

        $sub = $entityManager->createQueryBuilder();
            // Select tous les les programmes
        $sub->select('pr')
            // Qui sont dans l'entity programme avec un allias 'pr'
            ->from('App\Entity\Programme', 'pr')
            // Quand il y à un  programme.id
            ->where($sub->expr()->in('pr.id', $qb->getDQL()))
            // Déclare le paramètre de la requête (contre les injections SQL)
            ->setParameter('id', $session_id)
            // Trier par les noms des stagiaires
            ->orderBy('pr.nbJour');
        
        $query = $sub->getQuery();
        return $query->getResult();

    }

    // public function findProgrammeModule($programme_id)
    // {
    //     // Récupère l'entityManager
    //     $entityManager = $this->getEntityManager();
    //     // Récupère la méthode createQueryBuilder()
    //     $sub = $entityManager->createQueryBuilder();
                
    //     // Stock le createQueryBuilder dans $qb
    //     $qb = $sub;
    //     // Select tous les programmes
    //     $qb->select('m')
    //     // Qui sont dans l'entity programmes avec un allias 'p'
    //     ->from('App\Entity\Module', 'm')
    //     // Jointure sur la table programme.sessions avec un allias 'se'
    //     ->leftJoin('m.programmes', 'mp')
    //     // Quand : programme.sessions = id
    //     ->where('mp.id = :id');
        
    //     $sub = $entityManager->createQueryBuilder();
    //     // Select tous les programmes
    //     $sub->select('mo')
    //     // Qui sont dans l'entity programme avec un allias 'pr'
    //     ->from('App\Entity\Module', 'mo')
    //     // Quand il n'y à pas programme.id
    //     ->where($sub->expr()->notIn('mo.id', $qb->getDQL()))
    //     // Déclare le paramètre de la requête (contre les injections SQL)
    //     ->setParameter('id', $programme_id)
    //     // Trier par le nbJours
    //     ->orderBy('mo.intitule');
                
    //     $query = $sub->getQuery();
    //     return $query->getResult();
    // }
}
