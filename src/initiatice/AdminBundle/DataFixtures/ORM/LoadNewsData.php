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
        $n1->setProfile(1);
        $n1->setContent("Les inscriptions des partenaires / communotic à nos ateliers de formations se font maintenant directement sur le questionnaire en ligne : https://limesurvey.unicaen.fr/index.php/376671/lang-fr");
        $n1->setDateAdd(new \DateTime());
        $n1->setDateUpdate(new \DateTime());
        $n1->setMiniature("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426835181&ID_FICHE=42926");
        $n1->setContentImage("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426835480&ID_FICHE=43024");
        $manager->persist($n1);

        $n2 = new News();
        $n2->setTitle("Nouvel Atelier : \"Proposer des activités collaboratives à mes étudiants\"");
        $n2->setType("Atelier");
        $n2->setProfile(2);
        $n2->setAbstract("Nouvel atelier disponible sur moodle");
        $n2->setDateAdd(new \DateTime());
        $n2->setDateUpdate(new \DateTime());
        $n2->setMiniature("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426833966&ID_FICHE=42926");
        $n2->setContentImage("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426835468&ID_FICHE=44151");
        $manager->persist($n2);

        $manager->flush();
    }

}