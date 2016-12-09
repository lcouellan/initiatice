<?php

namespace initiatice\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use initiatice\AdminBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
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

        $u = new User();
        $e = $encoderFactory->getEncoder($u);
        $u->setFirstname('Laurence');
        $u->setLastname('Dupont');
        $u->setPlainPassword('Laurence');
        $u->setPassword($e->encodePassword($u->getPlainPassword(), $u->getSalt()));
        $u->setEmail("laurence@mail.com");
        $u->setDescription('Je suis Laurence passionnée d\'informatique et experte Moodle, contactez-moi si besoin');
        $u->setProfile(1);
        $u->setEnabled(true);
        $u->setToken(bin2hex(random_bytes(48)));
        $u->setDateAdd(new \DateTime());
        $u->setDateUpdate(new \DateTime());
        $manager->persist($u);

        $u = new User();
        $e = $encoderFactory->getEncoder($u);
        $u->setFirstname('Gwendoline');
        $u->setLastname('Dumont');
        $u->setPlainPassword('Gwendoline');
        $u->setPassword($e->encodePassword($u->getPlainPassword(), $u->getSalt()));
        $u->setEmail("gwendoline@mail.com");
        $u->setProfile(1);
        $u->setEnabled(true);
        $u->setToken(bin2hex(random_bytes(48)));
        $u->setDateAdd(new \DateTime());
        $u->setDateUpdate(new \DateTime());
        $manager->persist($u);

        $u = new User();
        $e = $encoderFactory->getEncoder($u);
        $u->setFirstname('Stéphanie');
        $u->setLastname('Durant');
        $u->setPlainPassword('Stéphanie');
        $u->setPassword($e->encodePassword($u->getPlainPassword(), $u->getSalt()));
        $u->setEmail("stephanie@mail.com");
        $u->setProfile(1);
        $u->setEnabled(true);
        $u->setToken(bin2hex(random_bytes(48)));
        $u->setDateAdd(new \DateTime());
        $u->setDateUpdate(new \DateTime());
        $manager->persist($u);

        $u = new User();
        $e = $encoderFactory->getEncoder($u);
        $u->setFirstname('Lucien');
        $u->setLastname('Lebeau');
        $u->setPlainPassword('Lucien');
        $u->setPassword($e->encodePassword($u->getPlainPassword(), $u->getSalt()));
        $u->setEmail("lucien@mail.com");
        $u->setProfile(1);
        $u->setEnabled(true);
        $u->setToken(bin2hex(random_bytes(48)));
        $u->setDateAdd(new \DateTime());
        $u->setDateUpdate(new \DateTime());
        $manager->persist($u);

        $manager->flush();
    }
}