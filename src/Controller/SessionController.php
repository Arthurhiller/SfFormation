<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Programme;
use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionFormType;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
            'form' => $form->createView(),
            'sessionId' => $session->getId(),
        ]);
    }
    /**
     * @Route("/session/{id}/show", name="show_session")
     * 
     */
    public function show(ManagerRegistry $doctrine, Session $session, SessionRepository $sr): Response
    {
        // $moduleProgramme = $sr->findProgrammeModule($session->getId());
        $programmes = $sr->findProgrammes($session->getId());
        $inscrits = $sr->findInscrit($session->getId());
        $nonInscrits = $sr->findNonInscrits($session->getId());
        $session = $doctrine->getRepository(Session::class)->find($session->getId());
        return $this->render('session/show.html.twig', [
            'session' => $session,
            'nonInscrits' => $nonInscrits,
            'inscrits' => $inscrits,
            'programmes' => $programmes,
            // 'modulesProgramme' => $moduleProgramme
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


    /**
     * @Route("/session/addStagiaire/{idSe}/{idSt}", name="add_stagiaire_session", requirements={"idSe"="\d+", "idSt"="\d+"})
     * @ParamConverter("session", options={"mapping": {"idSe": "id"}})
     * @ParamConverter("stagiaire", options={"mapping": {"idSt": "id"}})
     */
    public function addStagiaire(ManagerRegistry $doctrine, Session $session, Stagiaire $stagiaire): Response
    {
        $entityManager = $doctrine->getManager();

        $session->addStagiaire($stagiaire);

        $entityManager->persist($session);

        $entityManager->flush();

        return $this->redirectToRoute('show_session', [
            'id' => $session->getId()
        ]);
    }

    /**
     * @Route("/session/removeStagiaire/{idSe}/{idSt}", name="remove_stagiaire_session", requirements={"idSe"="\d+", "idSt"="\d+"})
     * @ParamConverter("session", options={"mapping": {"idSe": "id"}})
     * @ParamConverter("stagiaire", options={"mapping": {"idSt": "id"}})
     */
    public function removeStagiaire(ManagerRegistry $doctrine, Session $session, Stagiaire $stagiaire): Response
    {
        $entityManager = $doctrine->getManager();

        $session->removeStagiaire($stagiaire);

        $entityManager->persist($session);

        $entityManager->flush();

        return $this->redirectToRoute('show_session', [
            'id' => $session->getId()
        ]);
    }

    // /**
    //  * @Route("/session/addProgramme/{idSe}/{idPro}", name="add_programme_session", requirements={"idSe"="\d+", "idPro"="\d+"})
    //  * @ParamConverter("session", options={"mapping": {"idSe": "id"}})
    //  * @ParamConverter("programme", options={"mapping": {"idPro": "id"}})
    //  */
    // public function addProgramme(ManagerRegistry $doctrine, Session $session, Programme $programme): Response
    // {
    //     $entityManager = $doctrine->getManager();

    //     $session->removeProgramme($programme);

    //     $entityManager->persist($session);

    //     $entityManager->flush();

    //     return $this->redirectToRoute('show_session', [
    //         'id' => $session->getId()
    //     ]);
    // }

    // /**
    //  * @Route("/session/removeProgramme/{idSe}/{idPro}", name="remove_programme_session", requirements={"idSe"="\d+", "idPro"="\d+"})
    //  * @ParamConverter("session", options={"mapping": {"idSe": "id"}})
    //  * @ParamConverter("programme", options={"mapping": {"idPro": "id"}})
    //  */
    // public function removeProgramme(ManagerRegistry $doctrine, Session $session, Programme $programme): Response
    // {
    //     $entityManager = $doctrine->getManager();

    //     $session->removeProgramme($programme);

    //     $entityManager->persist($session);

    //     $entityManager->flush();

    //     return $this->redirectToRoute('show_session', [
            
    //         'id' => $session->getId()
    //     ]);
    // }
}
