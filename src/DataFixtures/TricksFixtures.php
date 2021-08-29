<?php

namespace App\DataFixtures;

use App\Entity\Images;
use App\Entity\Tricks;
use App\Entity\Users;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TricksFixtures extends Fixture

{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');
        $slugify = new Slugify();

        $users = [];
        $genres = ['male', 'female'];
        $genre = $faker->randomElement($genres);

        $picture = 'https://randomuser.me/api/portraits/';
        $pictureId = $faker->numberBetween(1, 90) . '.jpg';
        if ($genre == "male") {
            $picture = $picture . 'men/' . $pictureId;
        } else {
            $picture = $picture . 'women/' . $pictureId;
        }
        // Nous gérons les utilisateurs
        for ($i = 1; $i <= 10; $i++) {
            $user = new Users();
            $description = '<p>' . join($faker->paragraphs(5)) . '</p>';

            $hash = $this->encoder->encodePassword($user, 'password');
            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName)
                ->setPicture($picture)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription($description)
                ->setHash($hash);

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
                ->setCoverImage($faker->imageUrl(1920, 350))
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
