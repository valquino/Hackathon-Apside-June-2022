<?php

namespace App\Controller;

use App\Entity\Stack;
use App\Form\StackType;
use App\Repository\StackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stack')]
class StackController extends AbstractController
{
    #[Route('/', name: 'app_stack_index', methods: ['GET'])]
    public function index(StackRepository $stackRepository): Response
    {
        return $this->render('stack/index.html.twig', [
            'stacks' => $stackRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stack_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StackRepository $stackRepository): Response
    {
        $stack = new Stack();
        $form = $this->createForm(StackType::class, $stack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stackRepository->add($stack, true);

            return $this->redirectToRoute('app_stack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stack/new.html.twig', [
            'stack' => $stack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stack_show', methods: ['GET'])]
    public function show(Stack $stack): Response
    {
        return $this->render('stack/show.html.twig', [
            'stack' => $stack,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stack_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stack $stack, StackRepository $stackRepository): Response
    {
        $form = $this->createForm(StackType::class, $stack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stackRepository->add($stack, true);

            return $this->redirectToRoute('app_stack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stack/edit.html.twig', [
            'stack' => $stack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stack_delete', methods: ['POST'])]
    public function delete(Request $request, Stack $stack, StackRepository $stackRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stack->getId(), $request->request->get('_token'))) {
            $stackRepository->remove($stack, true);
        }

        return $this->redirectToRoute('app_stack_index', [], Response::HTTP_SEE_OTHER);
    }
}
