<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\DoctrineHelper;
use App\Service\UploaderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $shop = $this->getUser()->getShop();
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findBy(['shop_id' => $shop]),
        ]);
    }

    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request,UploaderHelper $uploaderHelper, DoctrineHelper $doctrineHelper): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['iconImage']->getData();

            if($uploadedFile)
            {
                $newFileName = $uploaderHelper->uploadImage($uploadedFile, UploaderHelper::CATEGORY_ICON);
                $category->setIcon($newFileName);
            }
            $category->setShopId($this->getUser()->getShop());
            $doctrineHelper->AddToDb($category);

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Category $category,UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['iconImage']->getData();

            if($uploadedFile)
            {
                $newFileName = $uploaderHelper->uploadImage($uploadedFile, UploaderHelper::CATEGORY_ICON);
                $category->setIcon($newFileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Category $category, DoctrineHelper $doctrineHelper): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $doctrineHelper->DeleteFromDb($category);
        }

        return $this->redirectToRoute('category_index');
    }

    /**
     * @Route("/list/{id}", name="category_show_home", methods={"GET"})
     */
    public function showProducts(Category $category): Response
    {
        return $this->render('home/index.html.twig', [
            'products' => $category->getProducts(),
            'controller_name' => 'HomeController',
        ]);
    }


    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
