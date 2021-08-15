<?php

namespace App\DataFixtures;

use App\Entity\Images;
use App\Entity\Tricks;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TricksFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');
        $slugify = new Slugify();

        for ($i = 1; $i <= 20; $i++) {
            $trick = new Tricks();

            $title = $faker->sentence();
//            $slug = $slugify->slugify($title);
            $description = '<p>' . join($faker->paragraphs(5)) . '</p>';

            $trick
                ->setTitle($title)
//                ->setSlug($slug)
                ->setDescription($description);

            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Images();
                $image
                    ->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence)
                    ->setTrick($trick);

                $manager->persist($image);
            }
            $manager->persist($trick);
        }
        $manager->flush();
    }
}
