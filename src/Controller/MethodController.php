<?php

namespace App\Controller;

use App\Entity\Method;
use App\Form\MethodType;
use App\Repository\MethodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/method')]
class MethodController extends AbstractController
{
    #[Route('/', name: 'app_method_index', methods: ['GET'])]
    public function index(MethodRepository $methodRepository): Response
    {
        return $this->render('method/index.html.twig', [
            'methods' => $methodRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_method_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MethodRepository $methodRepository): Response
    {
        $method = new Method();
        $form = $this->createForm(MethodType::class, $method);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $methodRepository->add($method, true);

            return $this->redirectToRoute('app_method_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('method/new.html.twig', [
            'method' => $method,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_method_show', methods: ['GET'])]
    public function show(Method $method): Response
    {
        return $this->render('method/show.html.twig', [
            'method' => $method,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_method_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Method $method, MethodRepository $methodRepository): Response
    {
        $form = $this->createForm(MethodType::class, $method);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $methodRepository->add($method, true);

            return $this->redirectToRoute('app_method_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('method/edit.html.twig', [
            'method' => $method,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_method_delete', methods: ['POST'])]
    public function delete(Request $request, Method $method, MethodRepository $methodRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$method->getId(), $request->request->get('_token'))) {
            $methodRepository->remove($method, true);
        }

        return $this->redirectToRoute('app_method_index', [], Response::HTTP_SEE_OTHER);
    }
}
