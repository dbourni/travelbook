<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Entity\Travel;
use App\Form\TravelType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TravelController
 * @package App\Controller
 *
 * @Route("/travel")
 */
class TravelController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route("/list", name="app_travel_list")
     */
    public function list(): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $repo = $manager->getRepository(travel::class);
        $travels = $repo->findAll();

        return $this->render('travel/list.html.twig', [
            'travels' => $travels,
        ]);
    }

    /**
     * @param $id
     * @return Response
     *
     * @Route("/view/{id}", name="app_travel_view")
     */
    public function view($id): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $repoTravel = $manager->getRepository(travel::class);
        $travel = $repoTravel->find($id);

        $repoStage = $manager->getRepository(Stage::class);
        $stages = $repoStage->findBy(['travel' => $travel->getId()], ['orderintravel' => 'ASC']);

        return $this->render('travel/view.html.twig', [
            'travel' => $travel,
            'stages' => $stages,
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return Response
     *
     * @Route("/edit/{id}", name="app_travel_edit")
     */
    public function edit($id, Request $request): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $repo = $manager->getRepository(travel::class);
        $travel = $repo->find($id);

        $form = $this->createForm(TravelType::class, $travel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($travel);
            $manager->flush();

            return $this->redirectToRoute('app_travel_list');
        }

        return $this->render('travel/edit.html.twig', [
            'form' => $form->createView(),
            'travel' => $travel,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="app_travel_new")
     */
    public function new(Request $request): Response
    {
        $travel = new Travel();

        $form = $this->createForm(TravelType::class, $travel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($travel);
            $manager->flush();

            return $this->redirectToRoute('app_travel_list');
        }

        return $this->render('travel/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $id
     * @return Response
     *
     * @Route("/delete/{id}", name="app_travel_delete")
     */
    public function delete($id): Response
    {
        //TODO Demander une confirmation en Bootstrap
        $manager = $this->getDoctrine()->getManager();
        $repo = $manager->getRepository(travel::class);
        $travel = $repo->find($id);
        $manager->remove($travel);
        $manager->flush();

        return $this->redirectToRoute('app_travel_list');
    }
}
