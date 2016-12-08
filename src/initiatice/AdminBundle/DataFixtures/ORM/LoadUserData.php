<?php

namespace initiatice\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use initiatice\AdminBundle\Entity\User;

class LoadAdminData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $u = new User();
        $u->setUsername('admin');
        $u->setPlainPassword('admin');
        $u->setEmail("admin@mail.com");
        $u->setEnabled(true);
        $manager->persist($u);

        $manager->flush();
    }
}