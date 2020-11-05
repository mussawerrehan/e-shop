<?php


namespace App\Service;


use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationHelper
{
    private $passwordEncoder;
    private $doctrineHelper;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, DoctrineHelper $doctrineHelper)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->doctrineHelper = $doctrineHelper;
    }

    public function AddUser($form)
    {
        $user = new User();
        // dd($form);
        $user->setEmail($form['email']);
        $user->setRoles(array($form['roles']));
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $form['password']
        ));
        $this->doctrineHelper->AddToDb($user);
    }
}