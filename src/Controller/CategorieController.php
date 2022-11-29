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
}
