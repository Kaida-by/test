<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Profile;
use App\Entity\User;
use App\Repository\ProductRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($i . '@mail.ru');
            $user->setPassword($i . 'qwertyqwerty');

            for ($j = 0; $j < 2; $j++) {
                $product = new Product();
                $product->setTitle('Title ' . rand(1, 100));
                $product->setDescription('descr ' . rand(1, 100));
                $user->addProduct($product);
            }

            $manager->persist($user);

            $profile = new Profile();
            $profile->setUser($user);
            $format = "Y,m,d";
            $time = "2009,2,26";
            $date = \DateTime::createFromFormat($format, $time);
            $profile->setBirthDate($date);
            $profile->setPhone('123456789');
            $user->setProfile($profile);

            $manager->persist($profile);
        }
        //$user->removeProduct($product);
        $manager->remove($user);
        $manager->flush();
    }
}
