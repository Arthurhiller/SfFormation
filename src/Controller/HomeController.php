<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $categorie = $doctrine->getRepository(Categorie::class)->findBy([], ["intitule" => "DESC"]);
        $session = $doctrine->getRepository(Session::class)->findBy([], ["dateDebut" => "ASC"]);
        return $this->render('home/index.html.twig', [
            'homeSessions' => $session,
            'homeCategories' => $categorie
        ]);
    }
    
}
