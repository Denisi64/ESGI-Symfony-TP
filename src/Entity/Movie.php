<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

#[Entity(repositoryClass: MediaRepository::class)]
class Movie extends Media
{
    // Plus besoin de redéclarer le champ id ici

    // Les autres propriétés et méthodes de Movie
}
