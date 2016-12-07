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
use initiatice\AdminBundle\Entity\ForumComment;


class LoadCommentData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $e1 = new ForumComment();
        $e1->setPseudo('Stéphanie');
        $e1->setContent('Bonjour, vous ne devriez pas faire cours le lundi matin.');
        $e1->setQuestionId(1);
        $e1->setDateAdd(new \DateTime());
        $e1->setDateUpdate(new \DateTime());
        $manager->persist($e1);

        $e2 = new ForumComment();
        $e2->setPseudo('Lucien');
        $e2->setContent('Bonjour, avez vous essayé de mettre le CM le matin, et le TD un autre jour ?');
        $e2->setQuestionId(1);
        $e2->setDateAdd(new \DateTime());
        $e2->setDateUpdate(new \DateTime());
        $manager->persist($e2);

        $manager->flush();
    }
}