<?php

namespace initiatice\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use initiatice\AdminBundle\Entity\Event;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $e1 = new Event();
        $e1->setTitle('Le champ des possibles avec Moodle');
        $e1->setType("Café'TICE");
        $e1->setPlace('Belvedère, bâtiment D · campus 1');
        $e1->setDateStart(new \DateTime('2015-10-04'));
        $e1->setDateEnd(new \DateTime('2015-10-04'));
        $e1->setDateAdd(new \DateTime());
        $e1->setDateUpdate(new \DateTime());
        $e1->setMiniature("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426835181&ID_FICHE=42926");
        $e1->setContentImage("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426835480&ID_FICHE=43024");
        $manager->persist($e1);

        $e2 = new Event();
        $e2->setTitle("Journée d'Innovations Pédagogiques 2016");
        $e2->setType("JIPN");
        $e2->setAbstract("Les JIPN Les Journées d'Innovations Pédagogiques Normandes sont organisées annuellement en collaboration avec la Région Normandie (Réseau Communotic).");
        $e2->setContent("À l’ère du numérique, les enseignants doivent faire face à de nouvelles problématiques : l’évolution des outils numériques, la massification des enseignements, le profil des étudiants, le changement des attitudes et des mentalités. Ils doivent s'adapter à un nouveau public (Digital Natives) dont le rapport au savoir, à l'apprentissage a évolué. Comment réinventer ses pratiques pédagogiques ? Comment innover en pédagogie ?

Ces 2 jours JIPN 2016 ont été l’occasion d'échanger sur les outils pédagogiques, les nouvelles formes d'apprentissage avec un focus sur l'évaluation mais également d’imaginer les pratiques pédagogiques innovantes.

La première journée était dédiée aux partages d'expériences. Nous avons eu le privilège de recevoir Marcel Lebrun en \"guest star\" pour l'ouverture de ces conférences sur la thématique \" « L’école » dans une société numérique ! Et si on parlait d’apprentissage ?\".  Marcel Lebrun, docteur en Sciences, est professeur en technologies de l'éducation et conseiller pédagogique à l'Université catholique de Louvain.
La seconde journée était dédiée aux ateliers.

Toutes les conférences ont été captées, vous pouvez les revoir sur Canal-U :
http://www.canal-u.tv/producteurs/centre_d_enseignement_multimedia_universitaire_c_e_m_u/cemu/jipn2016");
        $e2->setPlace('Amphi Pierre Daure - Campus 1');
        $e2->setDateStart(new \DateTime('2016-03-29'));
        $e2->setDateEnd(new \DateTime('2016-03-30'));
        $e2->setDateAdd(new \DateTime());
        $e2->setDateUpdate(new \DateTime());
        $e2->setMiniature("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426833966&ID_FICHE=42926");
        $e2->setContentImage("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426835468&ID_FICHE=44151");
        $manager->persist($e2);


        $manager->flush();
    }
}