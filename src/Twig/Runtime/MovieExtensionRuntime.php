<?php

namespace App\Twig\Runtime;

use App\Entity\Movie;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class MovieExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private Environment $environment,
    )
    {
        // Inject dependencies if needed
    }

    public function movieTest($value): string
    {
        return "Bonjour";
    }

    public function formatTime(int $duration): string
    {
        // Modifie movie.duration de secondes en h:m:s
        return ($duration / (60 * 60)) % 60 . ":" . ($duration / 60) % 60 . ":" . ($duration % 60);
    }

    public function formatPrice(Movie $movie): string
    {
        return ($movie->getPrice() / 100) . ' €';
    }

    public function getStarsHtml(Movie $movie): string
    {
        $html = $this->environment->render('partials/_noteStars.html.twig', [
            'movie' => $movie,
        ]);


        return $html;
    }
}
