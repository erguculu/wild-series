<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use  Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public const ACTORS = [
                'Andrew Lincoln',
                'Norman Reedus',
                'Steven Yeun ',
                'Jeffrey Dean Morgan',
                'Danai Gurira ',
                'Christian Serratos ',
                'Josh McDermitt',
    ];
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');

        foreach(self::ACTORS as $key => $actorName){
        $actor = new Actor();
        $actor->setFirstName($actorName);
        $actor->addProgram($this->getReference('program_0'));

        }

        for ($i = 0; $i <= 50; $i++) {
            $actor = new Actor();
            $actor->setFirstName($faker->firstname);
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween($min = 0, $max = 5)));
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween($min = 0, $max = 5)));
            $manager->persist($actor);
        }

        $manager->flush();
    }

    public function getDependencies()  
    {
        return [ProgramFixtures::class];  
    }
}