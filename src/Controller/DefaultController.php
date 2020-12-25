<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

class DefaultController extends AbstractController
{
     /**
     * @Route("/", name="app_index")
     */
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findBy(
            array(),
            ['id' => 'DESC'],
            4
        );
        
        return $this->render('index.html.twig', ["programs" => $programs]);
    }
}
