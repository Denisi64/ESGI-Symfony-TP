<?php

namespace App\DataFixtures;

use App\Entity\Language;
use App\Entity\Movie;
use App\Entity\Serie;
use App\Enum\MediaTypeEnum; // Correct use statement
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create some Movie entities
        $movie1 = new Movie();
        $movie1->setTitle('Media Title 1');
        $movie1->setLongDescription('Description for Media 1');
        $movie1->setShortDescription('Short description for Media 1');
        $movie1->setReleaseDate(new \DateTimeImmutable('2023-01-01'));
        $movie1->setCoverImage('cover_image_1.jpg');
        $movie1->setMediaType(MediaTypeEnum::MOVIE); // Set the media type

        // Create some Serie entities
        $serie1 = new Serie();
        $serie1->setTitle('Media Title 2');
        $serie1->setLongDescription('Description for Media 2');
        $serie1->setShortDescription('Short description for Media 2');
        $serie1->setReleaseDate(new \DateTimeImmutable('2023-02-01'));
        $serie1->setCoverImage('cover_image_2.jpg');
        $serie1->setMediaType(MediaTypeEnum::SERIE); // Set the media type

        // Persist Media entities
        $manager->persist($movie1);
        $manager->persist($serie1);

        // Create a Language entity
        $language = new Language();
        $language->setName('English');
        $language->setCode('EN');

        // Associate Media entities with the Language entity
        $movie1->setMediaLanguage(new ArrayCollection([$language]));
        $serie1->setMediaLanguage(new ArrayCollection([$language]));

        // Persist Language entity
        $manager->persist($language);

        // Flush all changes to the database
        $manager->flush();
    }
}