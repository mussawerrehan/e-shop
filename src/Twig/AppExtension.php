<?php

namespace App\Twig;

use App\Repository\CategoryRepository;
use App\Repository\ShopRepository;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class AppExtension
 * @package App\Twig
 * @property ShopRepository $shopRepository
 * @property CategoryRepository $categoryRepository
 */
class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{
    /**
     * AppExtension constructor.
     * @param ShopRepository $shopRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ShopRepository $shopRepository, CategoryRepository $categoryRepository)
    {
        $this->shopRepository = $shopRepository;
        $this->categoryRepository = $categoryRepository;

    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('shop_sidebar', [$this, 'getShopSidebar'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    /**
     * @return array
     */
    public function getShopSidebar()
    {
        return [
            'shops' => $this->shopRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
        ];
    }

    /**
     * @return array|string[]
     */
    public static function getSubscribedServices()
    {
        return [
            CategoryRepository::class,
            ShopRepository::class,
        ];
    }
}
