<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    const COURSES = [
        ['Mercredi : 10:00', 'Enfants < 6 ans', 120],
        ['Samedi : 10:00', 'Enfants < 15 ans', 150],
        ['Dimanche : 10:00', 'Adulte', 200],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::COURSES as $index => $data) {
            $course = new Course();
            $course->setCategory($data[1]);
            $course->setTime($data[0]);
            $course->setPrice($data[2]);
            $manager->persist($course);
            $this->addReference('course_' . $index, $course);
        }
        $manager->flush();
    }
}
