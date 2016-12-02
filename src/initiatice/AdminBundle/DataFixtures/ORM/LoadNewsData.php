<?php

namespace initiatice\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use initiatice\AdminBundle\Entity\News;


class LoadNewsData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $n1 = new News();
        $n1->setTitle("ESPACE PARTENAIRES - INSCRIPTION AUX FORMATIONS CEMU");
        $n1->setType("Formations");
        $n1->setContent("Les inscriptions des partenaires / communotic à nos ateliers de formations se font maintenant directement sur le questionnaire en ligne : https://limesurvey.unicaen.fr/index.php/376671/lang-fr");

        $n1->setDateAdd(new \DateTime());
        $n1->setDateUpdate(new \DateTime());

        $manager->persist($n1);

        $n2 = new News();
        $n2->setTitle("Nouvel Atelier : \"Proposer des activités collaboratives à mes étudiants\"");
        $n2->setType("Atelier");
        $n2->setAbstract("Nouvel atelier disponible sur moodle");

        $n2->setDateAdd(new \DateTime());
        $n2->setDateUpdate(new \DateTime());

        $manager->persist($n2);

        $manager->flush();
    }

}