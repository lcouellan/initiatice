<?php
/**
 * Created by PhpStorm.
 * User: Logan
 * Date: 07/12/2016
 * Time: 10:31
 */

namespace initiatice\AdminBundle\DataFixtures\ORM\Forum;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use initiatice\AdminBundle\Entity\ForumQuestion;

/**
 * Forum questions fixtures
 * Class LoadQuestionData
 * @package initiatice\AdminBundle\DataFixtures\ORM\Forum
 */
class LoadQuestionData implements FixtureInterface
{
    /**
     * Load fixtures
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $q = new ForumQuestion();
        $q->setUserId(1);
        $q->setTitle('Comment améliorer mes cours ?');
        $q->setContent('Bonjour, je viens vers vous car je mes étudiants ne sont pas aussi captivés que je le souhaiterai lors de mes cours d\'économie, les cours sont le lundi matin de 8h à 13h, nous faisons un CM de 3h suivi d\'un TD de 2h, pouvez-vous m\'aider ?');
        $q->setDateAdd(new \DateTime());
        $q->setDateUpdate(new \DateTime());
        $manager->persist($q);

        $q = new ForumQuestion();
        $q->setUserId(2);
        $q->setTitle('Pourquoi mes élèves ne viennent pas aux cours de 18h ?');
        $q->setContent('Tout est dans le titre');
        $q->setDateAdd(new \DateTime());
        $q->setDateUpdate(new \DateTime());
        $manager->persist($q);

        $manager->flush();
    }
}