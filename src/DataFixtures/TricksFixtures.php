<?php

namespace App\DataFixtures;

use App\Entity\Tricks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TricksFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i= 1; $i <= 20; $i++){
            $trick = new Tricks();

            $trick
                ->setTitle("Titre de la figure numéro $i")
                ->setSlug("trick$i")
                ->setDescription("description de la figure");
            $manager->persist($trick);
        }
        $manager->flush();
    }
}
