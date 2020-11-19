<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{

    public function __construct()
    {
    }

    public function load(ObjectManager $manager)
    {
        $country = new Country();
        $country->setName('Argentina');
        $country->setCode('ARG');

        $manager->persist($country);
        $manager->flush();


    }
}
