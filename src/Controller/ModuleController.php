<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    /**
     * @Route("/module", name="app_module")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $module = $doctrine->getRepository(Module::class)->findBy([], ['intitule' => "ASC"]);
        return $this->render('module/index.html.twig', [
            'modules' => $module,
        ]);
    }

    /**
     * @Route("/module/add", name="add_module")
     * @Route("/module/{id}/edit", name="edit_module")
     */
    public function add(ManagerRegistry $doctrine, Module $module = null, Request $request): Response
    {
        if(!$module) {

            $module = new Module();
        }
        // Créer le formulaire de l'entité Module
        $form = $this->createForm(ModuleFormType::class, $module);
        // Regarde si l'action request est envoyé
        $form->handleRequest($request);
        // Si le form est submit ET que les données sont valides
        if($form->isSubmitted() && $form->isValid()) {

            // Récupère les data du formulaire
            $module = $form->getData();

            // Instancie l'entityManager
            $entityManager = $doctrine->getManager();

            // Prépare la requête avec les datas stocké dans module
            $entityManager->persist($module);
            // Envoie les données en BDD
            $entityManager->flush();

            $this->redirectToRoute('app_module');
        }

        return $this->render('module/add.html.twig', [

            'formAddModule' => $form->createView(),
            'edit' => $module->getId()
        ]);
    }

    /**
     * @Route("/module/{id}/show", name="show_module")
     */
    public function show(ManagerRegistry $doctrine, Module $module): Response
    {
        $module = $doctrine->getRepository(Module::class)->find($module->getId());
        return $this->render('module/show.html.twig', [
            'module' => $module
        ]);
    }

    /**
     * @Route("/module/{id}/delete", name="delete_module")
     */
    public function delete(ManagerRegistry $doctrine, Module $module): Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($module);

        $entityManager->flush();

        return $this->redirectToRoute('app_module');
    }
}
