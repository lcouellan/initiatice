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

/**
 * Forum comments fixtures
 * Class LoadCommentData
 * @package initiatice\AdminBundle\DataFixtures\ORM\Forum
 */
class LoadCommentData implements FixtureInterface
{
    /**
     * Load fixtures
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $e = new ForumComment();
        $e->setUserId(3);
        $e->setContent('Bonjour, vous ne devriez pas faire cours le lundi matin.');
        $e->setQuestionId(1);
        $e->setDateAdd(new \DateTime());
        $e->setDateUpdate(new \DateTime());
        $manager->persist($e);

        $e = new ForumComment();
        $e->setUserId(4);
        $e->setContent('Bonjour, avez vous essayé de mettre le CM le matin, et le TD un autre jour ?');
        $e->setQuestionId(1);
        $e->setDateAdd(new \DateTime());
        $e->setDateUpdate(new \DateTime());
        $manager->persist($e);

        $manager->flush();
    }
}
