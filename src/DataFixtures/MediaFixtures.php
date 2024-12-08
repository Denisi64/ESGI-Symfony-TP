<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Entity\Serie;
use App\Enum\MediaTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MediaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $mediaTypes = [MediaTypeEnum::MOVIE, MediaTypeEnum::SERIE];

        for ($i = 0; $i < 10; $i++) {
            $mediaType = $mediaTypes[array_rand($mediaTypes)];
            if ($mediaType === MediaTypeEnum::MOVIE) {
                $media = new Movie();
            } else {
                $media = new Serie();
            }

            $media->setTitle("Media Title {$i}");
            $media->setLongDescription("Description for media {$i}");
            $media->setShortDescription("Short description for media {$i}");
            $media->setMediaType($mediaType);
            $media->setReleaseDate(new \DateTime());
            $media->setCoverImage("cover_image_{$i}.jpg");

            $manager->persist($media);
        }

        $manager->flush();
    }
}