<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="app_session")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $session = $doctrine->getRepository(Session::class)->findBy([], ["dateDebut" => "ASC"]);
        return $this->render('session/index.html.twig', [
            'sessions' => $session,
        ]);
    }

    /**
     * @Route("session/add", name="add_session")
     * @Route("session/{id}/edit", name="edit_session")
     */
    public function add(ManagerRegistry $doctrine, Session $session = null, Request $request): Response
    {
        if(!$session) {

            $session = new Session();
        }

        $form = $this->createForm(SessionFormType::class, $session);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();

            $entityManager = $doctrine->getManager();

            $entityManager->persist($session);

            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/add.html.twig', [
            'formAddSession' => $form->createView(),
            'edit' => $session->getId()
        ]);
    }
    /**
     * @Route("/session/{id}/show", name="show_session")
     */
    public function show(ManagerRegistry $doctrine, Session $session): Response
    {
        $session = $doctrine->getRepository(Session::class)->find($session->getId());
        return $this->render('session/show.html.twig', [
            'session' => $session
        ]);


    }

    /**
     * @Route("/session/{id}/delete", name="delete_session")
     */
    public function delete(ManagerRegistry $doctrine, Session $session): Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($session);

        $entityManager->flush();

        return $this->redirectToRoute('app_session');
    }
}
