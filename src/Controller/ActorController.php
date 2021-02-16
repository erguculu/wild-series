<?php

namespace App\Controller;

use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Actor;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ActorType;


/**
 * @Route("/actor", name="actor_")
 */
class ActorController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response a response instance
     */
    public function index(ActorRepository $actorRepository): Response
    {
        $actors = $actorRepository->findAll();
        return $this->render('actor/index.html.twig', ['actors' => $actors]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actor);
            $entityManager->flush();

            $this->addFlash('success', 'The new actor has been created');

            return $this->redirectToRoute('actor_index');
        }

        return $this->render('actor/new.html.twig', [
            'season' => $actor,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", methods={"GET"}, name="show")
     * @return Response a response instance
     */
    public function show(Actor $actor): Response
    {
        return $this->render('actor/show.html.twig', ['actor' => $actor]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Actor $actor): Response
    {
        $form = $this->createForm(SeasonType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Votre saison a été bien editée');

            return $this->redirectToRoute('actor_index');
        }

        return $this->render('Actor/edit.html.twig', [
            'season' => $actor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Actor $actor
     * @return Response
     */
    public function delete(Request $request, Actor $actor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actor);
            $entityManager->flush();

            $this->addFlash('danger', 'Votre saison a été bien suprimée');
        }

        return $this->redirectToRoute('actor_index');
    }

}
