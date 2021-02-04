<?php

namespace App\DataFixtures;

use App\Entity\Show;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PriceFixtures extends Fixture
{
    const PRICES = [
        ['Adulte', 12],
        ['Enfants > 12 ans', 8],
        ['Enfants < 12 ans', 4],
        ['Groupes (> 10)', 6],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PRICES as $index => $data) {
            $price = new Show();
            $price->setCategory($data[0]);
            $price->setPrice($data[1]);
            $manager->persist($price);
            $this->addReference('price_' . $index, $price);
        }
        $manager->flush();
    }
}
