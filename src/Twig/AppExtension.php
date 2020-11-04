<?php

namespace App\Twig;

use App\Repository\CategoryRepository;
use App\Repository\ShopRepository;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('shop_sidebar', [$this, 'getShopSidebar'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function getShopSidebar(\Twig_Environment $twig)
    {
        $shopRepository = $this->get(ShopRepository::class);
        $categoryRepository = $this->get(CategoryRepository::class);

        return $twig->render('/inc/sidebar.html.twig', [
            'shops' => $shopRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }
    public static function getSubscribedServices()
    {
        return [
            CategoryRepository::class,
            ShopRepository::class,
        ];
    }
}
