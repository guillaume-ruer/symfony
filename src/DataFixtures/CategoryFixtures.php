<?php
// src/DataFixtures/CategoryFixtures.php
namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture {
    public function load(ObjectManager $manager) {
        // Création des catégories
        for ($i = 0; $i < 2; $i++) {
            $category = new Category();
            $category->setName("Categorie".$i);
            $manager->persist($category);
            $this->addReference("CatRef".$i, $category);
        }
        $manager->flush();
    }
}