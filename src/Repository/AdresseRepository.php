<?php

namespace App\Repository;

use App\Entity\Adresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method Adresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adresse[]    findAll()
 * @method Adresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adresse::class);
    }

    // /**
    //  * @return Adresse[] Returns an array of Adresse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Adresse
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * On récupère le résultat d'une requête basée sur une table
     * @param $libelle
     * @return mixed
     */
    public function ncFindPerso1()
    {

        $rsm = new ResultSetMapping();
        //on construit le résultat
        //Dans quelle entity ?
        $rsm->addEntityResult("App\Entity\Ville", "v");
        //pour quels champs dans cette entity?
        $rsm->addFieldResult("v", "idd", "id");
        $rsm->addFieldResult("v", "coddd", "codePostal");
        $rsm->addFieldResult("v", "libb", "libelle");

        $query = $this->getEntityManager()->createNativeQuery('select v.id as idd, v.libelle as libb, v.code_postal as coddd from ville v', $rsm);

        return $query->getResult(AbstractQuery::HYDRATE_OBJECT);

    }

    public function ncFindPerso2()
    {
        $rsm = new ResultSetMapping();
        //on construit le résultat
        //Danq quelle entity ?
        $rsm->addEntityResult("App\Entity\Adresse","adr");
        //pour quels champs dans cette entity ?
        $rsm->addFieldResult("adr","id","id");
        $rsm->addFieldResult("adr", "libelle","libelle");

        $rsm->addMetaResult("adr","id_ville","idVille",true);

        $query = $this->getEntityManager()->createNativeQuery('select * from adresse adr', $rsm);

        return $query->getArrayResult();
    }

    /**
     * On récupère le résultat d'une requête basée sur une table
     * @param $libelle
     * @return mixed
     */
    public function ncFindPerso3()
    {
        $rsm = new ResultSetMapping();
        //on construit le résultat
        //Dans quelle entity ?
        $rsm->addEntityResult("App\Entity\Adresse", "adr");
        //pour quels champs dans cette entity?
        $rsm->addFieldResult("adr", "id_adresse", "id");

        $rsm->addFieldResult("adr", "libelle_addr", "libelle");
        //pour les champs qui participent à une contrainte de clé étrangère, lien vers autre table
        $rsm->addMetaResult("adr", "idville", "idVille",true);

        //seconde entité qui est jointe à la première
        $rsm->addJoinedEntityResult("App\Entity\Ville","v","adr","idVille");
        $rsm->addFieldResult("v", "id_ville", "id");
        $rsm->addFieldResult("v", "code_postal_ville", "codePostal");
        $rsm->addFieldResult("v", "libelle_ville", "libelle");

        $rsm->addMetaResult("v","id","id",true);
        $rsm->addMetaResult("v","idVille","idVille",true);

        $query = $this->getEntityManager()->createNativeQuery('select a.id as id_adresse,a.libelle as libelle_addr, a.id_ville as idville, v.id as id_ville, v.libelle as libelle_ville, v.code_postal as code_postal_ville 
                                                                    from ville v 
                                                                    inner join adresse a on a.id_ville=v.id   ', $rsm);

        return $query->getScalarResult();//
    }

    /**
     * @return mixed
     */
    public function ncFindAdresseDql1(){
        $req= $this->getEntityManager()->createQuery("select a from App\Entity\Adresse a");
        return $req->getResult();
    }

    /**
     * @return mixed
     */
    public function ncFindAdresseDql2(){
        $req= $this->getEntityManager()->createQuery("select a from App\Entity\Adresse a
                                                       where a.libelle like 'a%'");
        return $req->getResult();
    }

    /**
     * @return mixed
     */
    public function ncFindAdresseDql3(){
        $req= $this->getEntityManager()->createQuery("select a from App\Entity\Adresse a inner join App\Entity\Ville v
                                                       where a.libelle like 'c%' and v.id=a.idVille");
        return $req->getResult();
    }



}
