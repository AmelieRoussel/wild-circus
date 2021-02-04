<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    const COURSES = [
        'Mercredi' => '10:00',
        'Samedi' => '10:00',
    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::COURSES as $day => $hour) {
            $course = new Course();
            $course->setDay($day);
            $course->setHour($hour);
            $manager->persist($course);
            $this->addReference('course_' . $i, $course);
            $i++;
        }
        $manager->flush();
    }
}
