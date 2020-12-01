<?php


namespace App\Service;


use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductHelper
{


    public function getCtegoryRelatedProducts(CategoryRepository $categoryRepository)
    {
        // $products = $categoryRepository->findAll()->where
    }

}