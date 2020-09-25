<?php
// src/DataFixtures/DealFixtures.php
namespace App\DataFixtures;

use App\Entity\Deal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DealFixtures extends Fixture {
    public function load(ObjectManager $manager) {
        // Création des deals
        for ($i = 0; $i < 4; $i++) {
            $deal = new Deal();
            $deal->setName("Deal".$i);
            $deal->setDescription("Description".$i);
            $deal->setPrice(mt_rand(10, 100));
            $deal->setEnable(false);
            if ($i%2 == 0) {
                $deal->addCategory($this->getReference("CatRef0"));
            } else {
                $deal->addCategory($this->getReference("CatRef1"));
            }
            $manager->persist($deal);
        }
        $manager->flush();
    }
}