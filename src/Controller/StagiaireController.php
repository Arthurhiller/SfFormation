<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StagiaireController extends AbstractController
{
    /**
     * @Route("/stagiaire", name="app_stagiaire")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $stagiaire = $doctrine->getRepository(Stagiaire::class)->findBy([], ["nom" => "DESC"]);
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaire,
        ]);
    }

    /**
     * @Route("/stagiaire/{id}/show", name="show_stagiaire")
     */
    public function show(ManagerRegistry $doctrine, Stagiaire $stagiaire): Response
    {
        $stagiaire = $doctrine->getRepository(Stagiaire::class)->find($stagiaire->getId());
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire
        ]);
    }

}
