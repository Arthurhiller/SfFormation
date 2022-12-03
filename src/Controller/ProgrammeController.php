<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Programme;
use App\Form\ProgrammeFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProgrammeController extends AbstractController
{


    /**
     * @Route("/programme", name="app_programme")
     */
    public function index(ManagerRegistry $doctrine, Programme $programme = null)
    {
        $programme = $doctrine->getRepository(Programme::class)->findAll();
        return $this->render('programme/index.html.twig', [
            'programmes' => $programme
        ]);
    }


    /**
     * @Route("/programme/add", name="add_programme")
     */
    public function add(ManagerRegistry $doctrine, Programme $programme = null, Request $request): Response
    {
        
        
        $form = $this->createForm(ProgrammeFormType::class, $programme);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $programme = $form->getData();

            $entityManager = $doctrine->getManager();

            $entityManager->persist($programme);

            $entityManager->flush();

            return $this->redirectToRoute('app_programme');
        }

        return $this->render('programme/add.html.twig', [
            'formAddProgramme' => $form->createView()
        ]);

    }

}
