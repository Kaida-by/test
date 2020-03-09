<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Profile;
use App\Entity\User;
use App\Repository\ProductRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class AppFixtures extends Fixture
{
    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setTitle('product ' . $i);
            $product->setDescription('rand text: ' . rand(1, 100));
            $manager->persist($product);
            $manager->flush();
        }
            for ($i = 0; $i < 10; $i++) {

                $user = new User();
                $user->setEmail($i . '@mail.ru');
                $user->setPassword($i . 'qwertyqwerty');

                if (isset($product)) {
                    $user->addProduct($manager->getRepository(Product::class)->find(rand(1, 10)));
                    $user->addProduct($manager->getRepository(Product::class)->find(rand(1, 10)));
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

                $manager->flush();
            }
    }
}
