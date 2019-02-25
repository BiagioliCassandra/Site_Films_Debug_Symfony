<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movie;
use App\Entity\Evaluation;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class TestController extends AbstractController
{
    /**
     * fonction fète pr tester ds trucs
     * @Route("/test", name="test")
     */
    // public function test()
    // {
    //     $ms = $this->getDoctrine()->getRepository(Movie::class)->findAll();
    //     //fonction qui essé de calc moyen note flm mais prblm
    //     for ($i=0; $i < count($ms) ; $i) {
    //       $notes = $ms[$i]->getEvaluations()->getGrade();
    //     }
    //     return $this->render('test/index.html.twig', [
    //       "ms" => $ms
    //     ]);
    // }

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
    public function show(Movie $movie)
    {
        return $this->render('test/single.html.twig', [
          "movie" => $movie
        ]);
    }

    /**
     * @Route("/evaluation/{id}", name="evaluation")
     * @IsGranted("ROLE")
     */
    public function rate(Movie $movie, User $user, Request $c)
    {
        $rate = new Evaluation();

        $form = $this->createFormBuilder($rate)
            ->add('comment')
            ->add('grade')
            ->add('sauvegarder', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $rate.setMovie($movie);
          $rate.setUser($user);
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($rate);
          $entityManager->flush();
        }

        return $this->render('test/evaluation.html.twig', [
          "b" => $b,
          "form" => $form->createView()
        ]);
    }
}
