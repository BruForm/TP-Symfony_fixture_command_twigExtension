<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\MovieExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MovieExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('movie_test', [MovieExtensionRuntime::class, 'movieTest']),
            new TwigFilter('format_time', [MovieExtensionRuntime::class, 'formatTime']),
            new TwigFilter('format_price', [MovieExtensionRuntime::class, 'formatPrice']),
            new TwigFilter('get_stars_html', [MovieExtensionRuntime::class, 'getStarsHtml']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [MovieExtensionRuntime::class, 'doSomething']),
        ];
    }
}
