<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieFormType;
use Symfony\Component\Form\FormTypeInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/categorie/add", name="add_categorie")
     * @Route("/categorie/{id}/edit", name="edit_categorie")
     */
    public function add(ManagerRegistry $doctrine, Categorie $categorie = null, Request $request): Response
    {   
        // Vérifie si une categorie existe (pour l'édit)
        if(!$categorie) {

            $categorie = new Categorie();
        }

        // Crée le formulaire de l'entité Categorie
        $form = $this->createForm(CategorieFormType::class, $categorie);
        // Quand une action est effectué -> recupère la requette
        $form->handleRequest($request);

        // Vérifie si le form est submit et si il est valide
        if($form->isSubmitted() && $form->isValid()) {
            
            // Stock dans l'object categorie les data du formulaire
            $categorie = $form->getData();

            // Instancie le entity manager
            $entityManager = $doctrine->getManager();

            // Prépare la rêquete avant l'envoie en BDD
            $entityManager->persist($categorie);

            // Envois les données en BDD
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie');
        }

        return $this->render('categorie/add.html.twig', [

            'formAddCategorie' => $form->createView(),
            'edit' => $categorie->getId()
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

    /**
     * @Route("/categorie/{id}/delete", name="delete_categorie")
     */
    public function delete(ManagerRegistry $doctrine, Categorie $categorie): Response
    {
        // Instancie l'entity manager
        $entityManager = $doctrine->getManager();
        
        // Fait appelle à la méthod remove 
        $entityManager->remove($categorie);

        // Envoie la requête en BDD
        $entityManager->flush();

        return $this->redirectToRoute('app_categorie');
    }
}
