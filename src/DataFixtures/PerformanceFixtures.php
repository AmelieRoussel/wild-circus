<?php

namespace App\DataFixtures;

use App\Entity\Performance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PerformanceFixtures extends Fixture implements DependentFixtureInterface
{
    const PERFORMANCES = [
        'Trapèze' => [
            'categories' => ['category_0', 'category_4',],
            'picture' => 'https://i.pinimg.com/originals/83/8c/9c/838c9cf05cd56b234691fe8bc277ec9a.jpg',
        ],
        'Tissu aérien' => [
            'categories' => ['category_0', 'category_4',],
            'picture' => 'https://i.pinimg.com/originals/ee/7a/84/ee7a84d560b13de215b7ed5fab265a2e.jpg',
        ],
        'Clown' => [
            'categories' => ['category_1', 'category_3', 'category_4', 'category_5',],
            'picture' => 'https://www.gannett-cdn.com/presto/2019/07/10/PFTM/86860a60-b91e-444c-85c4-1e1e41101190-Corteo_CLOWN_Costumes_Dominique_Lemieux_2018_Cirque_du_Soleil_Photo_7.jpg',
        ],
        'Funambule' => [
            'categories' => ['category_0', 'category_4',],
            'picture' => 'https://cdn-s-www.leprogres.fr/images/283F3F1C-C61A-4225-90B6-68320C7947B6/NW_detail_M/sur-ses-epaules-a-huit-metres-du-sol-elena-escalera-porte-abdul-danguir-un-numero-perilleux-qu-ils-travaillent-depuis-des-annees-photo-pierre-augros-1576680650.jpg',
        ],
        'Magicien' => [
            'categories' => ['category_2'],
            'picture' => 'http://ugoavecunh.com/wp-content/uploads/2020/07/Magicien-Mariage-Paris-Photobooth-Ugo-avec-un-H-Hugo-Illussionniste-Ile-de-France-75-Toulouse-31-Bordeaux-33-Lyon-69.jpg',
        ],
    ];
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $i=0;
        foreach (self::PERFORMANCES as $name => $data) {
            $performance = new Performance();
            $performance->setName($name);
            $image = $data['picture'];
            $imageName = uniqid() . '.jpg';
            copy($image, __DIR__ . '/../../public/uploads/' . $imageName);
            $performance->setPicture($imageName);
            $performance->setDescription($faker->text(1000));
            foreach ($data['categories'] as $category) {
                $performance->addCategory($this->getReference($category));
            }
            $manager->persist($performance);
            $this->addReference('performance_' . $i, $performance);
            $i++;
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }

}
