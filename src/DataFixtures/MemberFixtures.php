<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 15; $i++) {
            $member = new Member();
            $member->setLastname($faker->lastName);
            $member->setFirstname($faker->firstName);
            $member->setUser($this->getReference('user_' . rand(0, 9)));
            $member->setMail($faker->email);
            $member->setBirthday($faker->dateTimeThisCentury);
            $member->setCourse($this->getReference('course_' . rand(0,2)));
            $manager->persist($member);
            $this->addReference('membre_' . $i, $member);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class, CourseFixtures::class];
    }
}
