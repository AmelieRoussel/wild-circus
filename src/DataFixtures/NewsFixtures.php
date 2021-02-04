<?php

namespace App\DataFixtures;

use App\Entity\News;
use App\Entity\Performance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class NewsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i=0; $i < 10; $i++) {
            $news = new News();
            $news->setTitle($faker->sentence);
            $image = 'https://loremflickr.com/400/450/';
            $imageName = uniqid() . '.jpg';
            copy($image, __DIR__ . '/../../public/uploads/' . $imageName);
            $news->setIllustration($imageName);
            $news->setContent($faker->text(1200));
            $news->setPresentation($faker->text);
            $manager->persist($news);
            $this->addReference('news_' . $i, $news);
        }

        $manager->flush();
    }
}
