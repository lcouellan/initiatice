<?php

namespace initiatice\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use initiatice\AdminBundle\Entity\Admin;

/**
 * Admin (moderator) fixtures
 * Class LoadAdminData
 * @package initiatice\AdminBundle\DataFixtures\ORM
 */
class LoadAdminData implements FixtureInterface
{
    /**
     * Load fixtures
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $u = new Admin();
        $u->setUsername('admin');
        $u->setPlainPassword('admin');
        $u->setEmail("admin@mail.com");
        $u->setEnabled(true);
        $manager->persist($u);

        $manager->flush();
    }
}