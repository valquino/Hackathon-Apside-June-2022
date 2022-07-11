<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Entity\Category;
use App\Form\AgencyType;
use App\Repository\AgencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AgencyController extends AbstractController
{
    #[Route('/admin/agencies', name: 'app_agency_index', methods: ['GET'])]
    public function index(AgencyRepository $agencyRepository): Response
    {
        return $this->render('dashboard/agencies.html.twig', [
            'agencies' => $agencyRepository->findAll(),
        ]);
    }

    #[Route('admin/agency/new', name: 'app_agency_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AgencyRepository $agencyRepository): Response
    {
        $agency = new Agency();
        $form = $this->createForm(AgencyType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agencyRepository->add($agency, true);

            return $this->redirectToRoute('app_agency_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/agencies.html.twig', [
            'agencies' => $agencyRepository->findAll(),
            'agency' => $agency,
            'form' => $form,
        ]);
    }

    #[Route('/allagencies', name: 'app_all_agencies', methods: ['GET'])]
    public function allProjects(AgencyRepository $agencyRepository): Response
    {
        $agencies = $agencyRepository->findAll();
        return $this->render('agency/allagencies.html.twig', [
            'agencies' => $agencies,
        ]);
    }

    #[Route('agency/{id}', name: 'app_agency_show', methods: ['GET'])]
    public function show(Agency $agency, Category $category): Response
    {
        return $this->render('agency/show.html.twig', [
            'agency' => $agency,
            'category' => $category,
        ]);
    }

    #[Route('admin/agency/{id}/edit', name: 'app_agency_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agency $agency, AgencyRepository $agencyRepository): Response
    {
        $form = $this->createForm(AgencyType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agencyRepository->add($agency, true);

            return $this->redirectToRoute('app_agency_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/agencies.html.twig', [
            'agencies' => $agencyRepository->findAll(),
            'agency' => $agency,
            'form' => $form,
        ]);
    }

    #[Route('admin/agency/{id}', name: 'app_agency_delete', methods: ['POST'])]
    public function delete(Request $request, Agency $agency, AgencyRepository $agencyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agency->getId(), $request->request->get('_token'))) {
            $agencyRepository->remove($agency, true);
        }

        return $this->redirectToRoute('app_agency_index', [], Response::HTTP_SEE_OTHER);
    }
}
