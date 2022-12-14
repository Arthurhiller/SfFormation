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
        $session = new Session();

        $categorie = $doctrine->getRepository(Categorie::class)->findBy([], ["intitule" => "DESC"]);
        $nbPlaceReserver = $session->getNbPlaceReserver();
        $nbPlaceDisponible = $session->getNbPlaceDisponible();
        $session = $doctrine->getRepository(Session::class)->findBy([], ["dateDebut" => "ASC"]);
        return $this->render('home/index.html.twig', [
            'homeSessions' => $session,
            'nbPlaceReserve' => $nbPlaceReserver,
            'nbPlaceDisponible' => $nbPlaceDisponible,
            'homeCategories' => $categorie
        ]);
    }
    
}
