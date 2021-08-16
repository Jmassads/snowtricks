<?php

namespace App\DataFixtures;

use App\Entity\Images;
use App\Entity\Tricks;
use App\Entity\Users;
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

        $users = [];


        // Nous gerons les utilisateurs
        for ($i = 1; $i <= 10; $i++) {
            $user = new Users();
            $description = '<p>' . join($faker->paragraphs(5)) . '</p>';

            $user->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPicture($faker->imageUrl(1000, 350))
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription($description)
                ->setHash('password');

            $manager->persist($user);
            $users[] = $user;
        }

        // Nous gerons les figures
        for ($i = 1; $i <= 10; $i++) {
            $trick = new Tricks();
            $user = $users[mt_rand(0, count($users) - 1)];
            $title = $faker->sentence();
            $description = '<p>' . join($faker->paragraphs(5)) . '</p>';

            $trick
                ->setTitle($title)
                ->setCoverImage($faker->imageUrl(1000, 350))
                ->setDescription($description)
                ->setAuthor($user);


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
