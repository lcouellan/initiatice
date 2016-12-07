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

class LoadQuestionData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $e1 = new ForumQuestion();
        $e1->setPseudo('Laurence');
        $e1->setTitle('Comment améliorer mes cours ?');
        $e1->setContent('Bonjour, je viens vers vous car je mes étudiants ne sont pas aussi captivés que je le souhaiterai lors de mes cours d\'économie, les cours sont le lundi matin de 8h à 13h, nous faisons un CM de 3h suivi d\'un TD de 2h, pouvez-vous m\'aider ?');
        $e1->setDateAdd(new \DateTime());
        $e1->setDateUpdate(new \DateTime());
        $manager->persist($e1);

        $e2 = new ForumQuestion();
        $e2->setPseudo('Gwendoline');
        $e2->setTitle('Pourquoi mes élèves ne viennent pas aux cours de 18h ?');
        $e2->setContent('Tout est dans le titre');
        $e2->setDateAdd(new \DateTime());
        $e2->setDateUpdate(new \DateTime());
        $manager->persist($e2);

        $manager->flush();
    }
}