<?php

namespace App\Controller;

use App\Service\RegistrationHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index(): Response
    {
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @return Response
     */
    public function register(Request $request, RegistrationHelper $registrationHelper): Response
    {
        if($request->getMethod() == 'POST')
        {
            $form = $request->request->all();
            $registrationHelper->AddUser($form);
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/register.html.twig');
    }
}
