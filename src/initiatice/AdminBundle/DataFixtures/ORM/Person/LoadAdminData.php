<?php

namespace initiatice\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use initiatice\AdminBundle\Entity\Admin;

class LoadAdminData implements FixtureInterface
{
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