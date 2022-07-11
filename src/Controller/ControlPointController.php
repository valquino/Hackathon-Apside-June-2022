<?php

namespace App\Controller;

use App\Entity\ControlPoint;
use App\Form\ControlPointType;
use App\Repository\ControlPointRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/control/point')]
class ControlPointController extends AbstractController
{
    #[Route('/', name: 'app_control_point_index', methods: ['GET'])]
    public function index(ControlPointRepository $controlPointRepository): Response
    {
        return $this->render('control_point/index.html.twig', [
            'control_points' => $controlPointRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_control_point_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ControlPointRepository $controlPointRepository): Response
    {
        $controlPoint = new ControlPoint();
        $form = $this->createForm(ControlPointType::class, $controlPoint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $controlPointRepository->add($controlPoint, true);

            return $this->redirectToRoute('app_control_point_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('control_point/new.html.twig', [
            'control_point' => $controlPoint,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_control_point_show', methods: ['GET'])]
    public function show(ControlPoint $controlPoint): Response
    {
        return $this->render('control_point/show.html.twig', [
            'control_point' => $controlPoint,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_control_point_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ControlPoint $controlPoint, ControlPointRepository $controlPointRepository): Response
    {
        $form = $this->createForm(ControlPointType::class, $controlPoint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $controlPointRepository->add($controlPoint, true);

            return $this->redirectToRoute('app_control_point_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('control_point/edit.html.twig', [
            'control_point' => $controlPoint,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_control_point_delete', methods: ['POST'])]
    public function delete(Request $request, ControlPoint $controlPoint, ControlPointRepository $controlPointRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$controlPoint->getId(), $request->request->get('_token'))) {
            $controlPointRepository->remove($controlPoint, true);
        }

        return $this->redirectToRoute('app_control_point_index', [], Response::HTTP_SEE_OTHER);
    }
}
