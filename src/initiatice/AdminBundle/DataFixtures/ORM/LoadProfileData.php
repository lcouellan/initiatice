<?php

namespace initiatice\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use initiatice\AdminBundle\Entity\Profile;

class LoadProfileData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $e1 = new Profile();
        $e1->setName('Unicaen');
        $manager->persist($e1);

        $e2 = new Profile();
        $e2->setName('Communotic');
        $manager->persist($e2);

        $e3 = new Profile();
        $e3->setName('Extérieur');
        $manager->persist($e3);

        $manager->flush();
    }
}