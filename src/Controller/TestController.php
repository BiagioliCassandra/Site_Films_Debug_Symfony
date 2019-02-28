<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Evaluation;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;


class TestController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();
        return $this->render('test/index.html.twig', [
          "movies" => $movies
        ]);
    }

    /**
     * @Route("/single/{id}", name="single")
     */
    public function show($id)
    {        
      $movie = $this->getDoctrine()->getRepository(Movie::class)->find($id);
      $evaluations = $movie->getEvaluations();
      $average = "Ce film n'a pas encore de notes";
      
      foreach($evaluations as $key => $evaluation) {
        $grade = $evaluation->getGrade();
        if(!empty($grade))   {
          $average = $movie->getAverage();
        }
      }

      return $this->render('test/single.html.twig', [
        "movie" => $movie,
        "average" => $average 
      ]);
    }

    /**
     * @Route("/evaluation/{id}", name="evaluation", methods={"POST", "GET"})
     * @IsGranted("ROLE_USER")
     */
    public function rate(Movie $movie, Request $request)
    {
        $rate = new Evaluation();

        $form = $this->createFormBuilder($rate)
            ->add('comment', TextareaType::class)
            ->add('grade', ChoiceType::class, [
              'choices' => [
                  '0' => 0,
                  '1' => 1,
                  '2' => 2,
                  '3' => 3,
                  '4' => 4,
                  '5' => 5,
                  '6' => 6,
                  '7' => 7,
                  '8' => 8,
                  '9' => 9,
                  '10' => 10
              ]])  
            ->add('sauvegarder', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $rate = $form->getData();
          $user = $this->getUser();
          $rate->setMovie($movie);
          $rate->setUser($user);
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($rate);
          $entityManager->flush();

          return $this->redirectToRoute('index');
        }

        return $this->render('test/evaluation.html.twig', [
          "movie" => $movie,
          "form" => $form->createView()
        ]);
    }
}
