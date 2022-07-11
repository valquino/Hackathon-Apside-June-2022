<?php

namespace App\Controller;

use App\Entity\ControlPoint;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ControlPointRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    // TODO! THIS ROUTE WON'T APPEAR -> SAME NAME AS THE /myprojects ROUTE -> NEED TO CHANGE name
    #[Route('/', name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route('/admin/projects', name: 'app_projects_admin', methods: ['GET'])]
    public function adminProjects(ProjectRepository $projectRepository): Response
    {
        return $this->render('dashboard/projects.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route('/dashboard/projects', name: 'app_projects_dashboard', methods: ['GET'])]
    public function dashboardProjects(): Response
    {
        $projects = $this->getUser()->getAgency()->getProjects();
        return $this->render('dashboard/projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/', name: 'app_all_projects', methods: ['GET'])]
    public function allProjects(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();
        return $this->render('project/allprojects.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/myprojects', name: 'app_project_index', methods: ['GET'])]
    public function myprojects(ProjectRepository $projectRepository, ControlPointRepository $controlPointRepository): Response
    {
        return $this->render('project/allprojects.html.twig', [
            'controlPoints' => $controlPointRepository->findAll(),
            'projects' => $this->getUser()->getProjects(),
        ]);
    }

    #[Route('/project/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProjectRepository $projectRepository, UserRepository $userRepository, ControlPointRepository $controlPointRepository): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->addUser($userRepository->findOneBy(['id' => $this->getUser()->getId()]));
            $project->setCreatedAt(new DateTime());
            $project->setControlPoint($controlPointRepository->findOneBy(['name' => "Lancement"]));
            $projectRepository->add($project, true);

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/project/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/project/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, ProjectRepository $projectRepository): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projectRepository->add($project, true);

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/project/{id}', name: 'app_project_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, ProjectRepository $projectRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $projectRepository->remove($project, true);
        }

        return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
    }
}
