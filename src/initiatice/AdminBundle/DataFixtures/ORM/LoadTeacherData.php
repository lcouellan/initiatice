<?php

namespace initiatice\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use initiatice\AdminBundle\Entity\Teacher;

class LoadTeacherData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $encoderFactory = $this->container->get('security.encoder_factory');

        $t = new Teacher();
        $e = $encoderFactory->getEncoder($t);
        $t->setFirstname('Laurence');
        $t->setLastname('Dupont');
        $t->setPlainPassword('Laurence');
        $t->setPassword($e->encodePassword($t->getPlainPassword(), $t->getSalt()));
        $t->setEmail("laurence@mail.com");
        $t->setProfile(1);
        $t->setEnabled(true);
        $t->setDateAdd(new \DateTime());
        $t->setDateUpdate(new \DateTime());
        $manager->persist($t);

        $t = new Teacher();
        $e = $encoderFactory->getEncoder($t);
        $t->setFirstname('Gwendoline');
        $t->setLastname('Dumont');
        $t->setPlainPassword('Gwendoline');
        $t->setPassword($e->encodePassword($t->getPlainPassword(), $t->getSalt()));
        $t->setEmail("gwendoline@mail.com");
        $t->setProfile(1);
        $t->setEnabled(true);
        $t->setDateAdd(new \DateTime());
        $t->setDateUpdate(new \DateTime());
        $manager->persist($t);

        $manager->flush();
    }
}