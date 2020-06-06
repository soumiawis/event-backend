<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function login(AuthenticationUtils $utils )
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('admin_account/index.html.twig',  [
            'hasError' => $error !== null,
            'username' => $username

        ]);
    }

    /**
     * @Route("/logout", name="admin_logout")
     */
    public function logout(){
        // ....rien ! merci symfony
    }
}
