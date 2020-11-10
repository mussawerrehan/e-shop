<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home_index")
     */
    public function index(ProductRepository $productRepository,ShopRepository $shopRepository, CategoryRepository $categoryRepository): Response
    {

        return $this->render('home/index.html.twig', [
            'products' => $productRepository->findAll(),
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/upload/test", name="upload_test")
     */
    public function temporaryUploadAction()
    {

    }
}
