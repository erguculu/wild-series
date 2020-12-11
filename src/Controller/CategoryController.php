<?php

namespace App\Controller; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Entity\Category;
use App\Entity\Program;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request; 
/**
* @Route("/categories", name="category_")
*/

class CategoryController extends AbstractController
{
    
    /**
     * @Route("/",  name = "index")
     * 
     * @return Response a response instance
     */   

    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll("categories");

             return $this->render(
                'category/index.html.twig',
                ['categories' => $categories]
            );
            
    }

     /**
     * The controller for the category add form
     * Display the form or deal with it
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request) : Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
          // Deal with the submitted data
        // Get the Entity Manager
        $entityManager = $this->getDoctrine()->getManager();
        // Persist Category Object
        $entityManager->persist($category);
        // Flush the persisted object
        $entityManager->flush();
        // Finally redirect to categories list
        return $this->redirectToRoute('category_index');
        }
        // Render the form
        return $this->render('category/new.html.twig', ["form" => $form->createView()]);
    }
    /**
     * @Route("/{categoryName}", name="show")
     * @return Response
    */
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findBy(['name' => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException("There is not  : " . $categoryName . "in the  category table");
        }

        $programs = $programRepository->findBy(['category' => $category], ['id' => 'DESC'], 3);

        return $this->render('category/show.html.twig', ['programs' => $programs]);
    }


}
