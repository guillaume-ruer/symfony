<?php
// src/DataFixtures/UserFixtures.php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        // Création des users

        $admin = new User();
        $admin->setUsername('admin');
        $adminPassword = 'admin';
        $encoded = $this->encoder->encodePassword($admin, $adminPassword);
        $admin->setPassword($encoded);
        $admin->setRoles(['ROLE_ADMIN']);

        $user = new User();
        $user->setUsername('user');
        $userPassword = 'user';
        $encoded = $this->encoder->encodePassword($user, $userPassword);
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_USER']);

        $manager->persist($admin);
        $manager->persist($user);
        $manager->flush();
    }
}
