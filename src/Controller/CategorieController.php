<?php

namespace App\Controller;

use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_categorie")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $categorie = $doctrine->getRepository(Categorie::class)->findBy([], ["intitule" => "DESC"]);
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorie,
        ]);
    }

    /**
     * @Route("/categorie/{id}/show", name="show_categorie")
     */
    public function show(ManagerRegistry $doctrine, Categorie $categorie)
    {
        $categorie = $doctrine->getRepository(Categorie::class)->find($categorie->getId());
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie
        ]);
    }
}
