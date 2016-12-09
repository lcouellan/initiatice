<?php

namespace initiatice\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use initiatice\AdminBundle\Entity\News;

class LoadNewsData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $n = new News();
        $n->setTitle("ESPACE PARTENAIRES - INSCRIPTION AUX FORMATIONS CEMU");
        $n->setType("Formations");
        $n->setProfile(1);
        $n->setExternalLink("https://www.canal-u.tv/video/centre_d_enseignement_multimedia_universitaire_c_e_m_u/08_learning_pitch_pitchez_votre_outil_pedagogique_en_5_min_jipn_2016.21253");
        $n->setContent("Les inscriptions des partenaires / communotic à nos ateliers de formations se font maintenant directement sur le questionnaire en ligne : https://limesurvey.unicaen.fr/index.php/376671/lang-fr");
        $n->setContentImage("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426835480&ID_FICHE=43024");
        $n->setDateAdd(new \DateTime());
        $manager->persist($n);

        $n = new News();
        $n->setTitle("Nouvel Atelier : \"Proposer des activités collaboratives à mes étudiants\"");
        $n->setType("Atelier");
        $n->setProfile(2);
        $n->setExternalLink("https://www.canal-u.tv/video/centre_d_enseignement_multimedia_universitaire_c_e_m_u/08_learning_pitch_pitchez_votre_outil_pedagogique_en_5_min_jipn_2016.21253");
        $n->setAbstract("Nouvel atelier disponible sur moodle");
        $n->setContentImage("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426835468&ID_FICHE=44151");
        $n->setDateAdd(new \DateTime());
        $manager->persist($n);

        $manager->flush();
    }

}
