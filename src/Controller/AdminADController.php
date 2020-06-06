<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminADController extends AbstractController
{
    /**
     * @Route("/admin/ads", name="admin_ads_index")
     */
    public function index(EntityManagerInterface $em)
    {
        $repo = $em->getRepository(User::class);

        return $this->render('admin_ad/index.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }


}
