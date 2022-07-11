<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\JobRepository;
use App\Repository\AgencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user_index', methods: ['GET'])]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/allUsers.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/admin/employees', name: 'app_user_admin', methods: ['GET'])]
    public function adminUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('dashboard/employees.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/dashboard/employees', name: 'app_user_dashboard', methods: ['GET'])]
    public function dashboardUsers(): Response
    {
        $users = $this->getUser()->getAgency()->getUsers();
        return $this->render('dashboard/employees.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setIsAvailable(true);
            $user->setIsAdmin(true);
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(User $user, AgencyRepository $agencyRepository): Response
    {
        $agencies = $agencyRepository->findAll();
        $roles = [
            'Super Admin' => 'ROLE_SUPER_ADMIN',
            'Administrateur' => 'ROLE_ADMIN',
            'Utilisateur' => 'ROLE_USER',
        ];

        return $this->render('user/show.html.twig', [
            'user'      => $user,
            'agencies'  => $agencies,
            'roles'     => $roles,
        ]);
    }

    #[Route('/user/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $currentUser = $this->getUser();
        $form = $this->createForm(
            UserType::class,
            $user,
            [
                'role' => $currentUser->getRoles()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        $roles = [
            'Super Admin' => 'ROLE_SUPER_ADMIN',
            'Administrateur' => 'ROLE_ADMIN',
            'Utilisateur' => 'ROLE_USER',
        ];

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'roles' => $roles,
            'form' => $form,
        ]);
    }

    #[Route('/admin/employees/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_dashboard', [], Response::HTTP_SEE_OTHER);
    }

    // Check if an user is authorized to access to a profil page
    public function hasProfileAccess(User $user, $currentUser): bool|Response
    {
        $userId = $user->getId();
        if ($currentUser === null) {
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }
        $currentUserId = $currentUser->getId();
        $currentUserRole = $currentUser->getRoles();
        if (
            !in_array('ROLE_ADMIN', $currentUserRole) &&
            $currentUserId !== $userId
        ) {
            return false;
        }
        return true;
    }
}
