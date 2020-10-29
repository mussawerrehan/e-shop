<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\ShopType;
use App\Entity\User;
use App\Repository\ShopRepository;
use App\Service\UploaderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shop")
 */
class ShopController extends AbstractController
{
    /**
     * @Route("/", name="shop_index", methods={"GET"})
     */
    public function index(ShopRepository $shopRepository): Response
    {
        return $this->render('shop/index.html.twig', [
            'shops' => $shopRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="shop_new", methods={"GET","POST"})
     */
    public function new(Request $request, UploaderHelper $uploaderHelper): Response
    {
        $shop = new Shop();
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['iconImage']->getData();

            if ($uploadedFile) {
                $newFileName = $uploaderHelper->uploadShopIcon($uploadedFile);
                $shop->setIcon($newFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shop);
            $entityManager->flush();
            $this->addFlash('success', 'Shop Added successfully');
            return $this->redirectToRoute('shop_index');
        }

        return $this->render('shop/new.html.twig', [
            'shop' => $shop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shop_show", methods={"GET"})
     */
    public function show(Shop $shop): Response
    {
        return $this->render('shop/show.html.twig', [
            'shop' => $shop,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shop_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Shop $shop, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['iconImage']->getData();

            if ($uploadedFile) {
                $newFileName = $uploaderHelper->uploadShopIcon($uploadedFile);
                $shop->setIcon($newFileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shop_index');
        }

        return $this->render('shop/edit.html.twig', [
            'shop' => $shop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shop_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Shop $shop): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shop->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shop_index');
    }
}
