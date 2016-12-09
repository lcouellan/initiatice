<?php

namespace initiatice\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use initiatice\AdminBundle\Entity\Event;

class LoadEventData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $e = new Event();
        $e->setTitle('Le champ des possibles avec Moodle');
        $e->setType("Café'TICE");
        $e->setProfile(1);
        $e->setAbstract("Premier Cafe'TICE de l'année");
        $e->setPlace('Belvedère, bâtiment D · campus 1');
        $e->setLatitude(49.181318);
        $e->setLongitude(-0.373289);
        $e->setDateStart(new \DateTime('2015-10-04'));
        $e->setContentImage("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426835480&ID_FICHE=43024");
        $e->setExternalLink("https://www.canal-u.tv/video/centre_d_enseignement_multimedia_universitaire_c_e_m_u/08_learning_pitch_pitchez_votre_outil_pedagogique_en_5_min_jipn_2016.21253");
        $e->setDateAdd(new \DateTime());
        $e->setDateUpdate(new \DateTime());
        $manager->persist($e);

        $e = new Event();
        $e->setTitle("Journée d'Innovations Pédagogiques 2016");
        $e->setType("JIPN");
        $e->setProfile(2);
        $e->setAbstract("Les JIPN Les Journées d'Innovations Pédagogiques Normandes sont organisées annuellement en collaboration avec la Région Normandie (Réseau Communotic).");
        $e->setContent("À l’ère du numérique, les enseignants doivent faire face à de nouvelles problématiques : l’évolution des outils numériques, la massification des enseignements, le profil des étudiants, le changement des attitudes et des mentalités. Ils doivent s'adapter à un nouveau public (Digital Natives) dont le rapport au savoir, à l'apprentissage a évolué. Comment réinventer ses pratiques pédagogiques ? Comment innover en pédagogie ?

Ces 2 jours JIPN 2016 ont été l’occasion d'échanger sur les outils pédagogiques, les nouvelles formes d'apprentissage avec un focus sur l'évaluation mais également d’imaginer les pratiques pédagogiques innovantes.

La première journée était dédiée aux partages d'expériences. Nous avons eu le privilège de recevoir Marcel Lebrun en \"guest star\" pour l'ouverture de ces conférences sur la thématique \" « L’école » dans une société numérique ! Et si on parlait d’apprentissage ?\".  Marcel Lebrun, docteur en Sciences, est professeur en technologies de l'éducation et conseiller pédagogique à l'Université catholique de Louvain.
La seconde journée était dédiée aux ateliers.

Toutes les conférences ont été captées, vous pouvez les revoir sur Canal-U :
http://www.canal-u.tv/producteurs/centre_d_enseignement_multimedia_universitaire_c_e_m_u/cemu/jipn2016");
        $e->setPlace('Amphi Pierre Daure - Campus 1'); 
        $e->setLatitude(49.176318);
        $e->setLongitude(-0.376289);
        $e->setDateStart(new \DateTime('2016-03-29'));
        $e->setContentImage("http://cemu.unicaen.fr/servlet/com.univ.collaboratif.utils.LectureFichiergw?ID_FICHIER=1339426835468&ID_FICHE=44151");
        $e->setExternalLink('https://www.canal-u.tv/video/centre_d_enseignement_multimedia_universitaire_c_e_m_u/08_learning_pitch_pitchez_votre_outil_pedagogique_en_5_min_jipn_2016.21253');
        $e->setDateAdd(new \DateTime());
        $e->setDateUpdate(new \DateTime());
        $manager->persist($e);

        $manager->flush();
    }
}
