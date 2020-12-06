<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

/**
* @Route("/programs", name="program_")
*/
class ProgramController extends AbstractController
{
    /**
     * Show all rows from Program’s entity
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(ProgramRepository $programRepository): Response
    {
         $programs = $programRepository->findAll();
         return $this->render(
             'program/index.html.twig',
             ['programs' => $programs]
         );
    }

   /**
     * @Route("/{id<^[0-9]+$>}", name="show")
     * @return Response
     */
    public function show(int $id):Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);

        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findAll();


        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

      /**
     * Getting a program and season by id
     *
     * @Route("{programId}/seasons/{seasonId} }", methods={"GET"}, name="season_show")
     * @return Response
     */

    public function showSeason(int $programId, int $seasonId): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $programId]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$programId.' found in program\'s table.'
            );
        }

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['Program' => $programId, 'id' => $seasonId]);
            

        if (!$season) {
            throw $this->createNotFoundException(
                'No season with id : '.$seasonId.' found for program with id ' .$programId.' in season\'s table.'
            );
        }

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }

    /**
     *  * Getting a program, season and episode by id
     * @Route("{programId}/seasons/{seasonId}/episodes/{episodeId}", name="episode_show")
     * @return Response
     */
    public function showEpisode(int $programId, int $seasonId, int $episodeId): Response
    {

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $programId]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$programId.' found in program\'s table.'
            );
        }

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['Program' => $programId, 'id' => $seasonId]);
            

        if (!$season) {
            throw $this->createNotFoundException(
                'No season with id : '.$seasonId.' found for program with id ' .$programId.' in season\'s table.'
            );
        }
        $episode = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findOneBy(['season' => $seasonId, 'id' =>$episodeId]);
            

        if (!$episode) {
            throw $this->createNotFoundException(
                'No episode with id : '.$episodeId.' found for seaon with id ' .$seasonId.' in episode\'s table.'
            );
        }
        return $this->render('program/episode_show.html.twig', [
            'season' => $seasonId,
            'Program' => $programId,
            'episode' => $episodeId,
        ]);
    }
}