<?php

namespace App\Controller;

use App\Entity\Session;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/session/{id}/show", name="show_session")
     */
    public function show(ManagerRegistry $doctrine, Session $session): Response
    {
        $session = $doctrine->getRepository(Session::class)->find($session->getId());
        return $this->render('session/show.html.twig', [
            'session' => $session
        ]);


    }

}
