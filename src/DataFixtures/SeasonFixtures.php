<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');

        for ($i = 0; $i <= 5; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                $season = new Season();
                $season->setNumber($j);
                $season->setYear($faker->year($min = 1950, $max = 2020));
                $season->setDescription($faker->realText($maxNbChars = 255));
                $season->setProgram($this->getReference('program_' . $i));
                $manager->persist($season);
                $this->addReference('program_' . $i .'season_' . $j, $season);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}