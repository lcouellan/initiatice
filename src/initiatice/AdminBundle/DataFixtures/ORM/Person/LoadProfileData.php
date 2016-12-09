<?php

namespace initiatice\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use initiatice\AdminBundle\Entity\Profile;

class LoadProfileData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $p = new Profile();
        $p->setName('Unicaen');
        $manager->persist($p);

        $p = new Profile();
        $p->setName('Communotic');
        $manager->persist($p);

        $p = new Profile();
        $p->setName('Extérieur');
        $manager->persist($p);

        $manager->flush();
    }
}