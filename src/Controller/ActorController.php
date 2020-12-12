<?php

namespace App\Controller;

use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Actor;


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
     * @Route("/show/{id}", methods={"GET"}, name="show")
     * @return Response a response instance
     */
    public function show(Actor $actor): Response
    {
        return $this->render('actor/show.html.twig', ['actor' => $actor]);
    }
}
