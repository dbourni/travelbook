<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Entity\Travel;
use App\Form\StageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StageController
 * @package App\Controller
 *
 * @Route("/stage")
 */
class StageController extends AbstractController
{
    /**
     * @param $id
     * @param Request $request
     * @return Response
     *
     * @Route("/new/{id}", name="app_stage_new")
     */
    public function new($id, Request $request): Response
    {
        //TODO Remplir le numéro d'ordre
        $stage = new Stage();

        $form = $this->createForm(StageType::class, $stage);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $stage->setTravel($this->getDoctrine()->getManager()->getRepository(Travel::class)->find($id));
            $manager->persist($stage);
            $manager->flush();

            return $this->redirectToRoute('app_travel_view', [
                'id' => $id
            ]);
        }

        return $this->render('stage/new.html.twig',[
            'form' => $form->createView(),
            'travelId' => $id,
            ]
        );
    }

    /**
     * @param $id
     * @param $travelId
     * @return Response
     *
     * @Route("/delete/{id}/{travelId}", name="app_stage_delete")
     */
    public function delete($id, $travelId): Response
    {
        //TODO Demander une confirmation en Bootstrap
        $manager = $this->getDoctrine()->getManager();
        $repo = $manager->getRepository(Stage::class);
        $stage = $repo->find($id);
        $manager->remove($stage);
        $manager->flush();

        return $this->redirectToRoute('app_travel_view', [
            'id' => $travelId
            ]
        );
    }

    /**
     * @param $id
     * @param $travelId
     * @param Request $request
     * @return Response
     *
     * @Route("/edit/{id}/{travelId}", name="app_stage_edit")
     */
    public function edit($id, $travelId, Request $request): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $repo = $manager->getRepository(stage::class);
        $stage = $repo->find($id);

        $form = $this->createForm(StageType::class, $stage);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($stage);
            $manager->flush();

            return $this->redirectToRoute('app_travel_view', [
                    'id' => $travelId
                ]
            );
        }

        return $this->render('stage/new.html.twig',[
                'form' => $form->createView(),
                'travelId' => $travelId,
            ]
        );
    }

    /**
     * @param $id
     * @param $travelId
     * @param $direction
     * @return Response
     *
     * @Route ("/move/{id}/{travelId}/{direction}", name="app_stage_move")
     */
    public function move($id, $travelId, $direction): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $repo = $manager->getRepository(stage::class);
        $stage = $repo->find($id);

        $max = $repo->countForOneTravel($travelId);
        $actual = $stage->getOrderintravel();

        if ($direction == 'up' && $actual < $max){
            $stage->setOrderintravel($actual + 1);
            $next = $repo->findOneBy(['orderintravel' => $actual+1]);
            $next->setOrderintravel($actual);
            $manager->persist($next);
        }

        if ($direction == 'down' && $actual > 1){
            $stage->setOrderintravel($actual - 1);
            $previous = $repo->findOneBy(['orderintravel' => $actual-1]);
            $previous->setOrderintravel($actual);
            $manager->persist($previous);
        }

        $manager->persist($stage);
        $manager->flush();

        return $this->redirectToRoute('app_travel_view', [
                'id' => $travelId
            ]
        );
    }

}
