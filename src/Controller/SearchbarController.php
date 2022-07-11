<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recherche', name: 'search_')]
class SearchbarController extends AbstractController
{
    #[Route('/recherche', name: 'results')]
    public function searchResults(ProjectRepository $projectRepository): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (!empty($_GET['search'])) {
                $projects = $projectRepository->findBySearch($_GET['search']);
            }
        }
        return $this->render('searchbar/index.html.twig', [
            'projects' => $projects ? $projects : [],
        ]);
    }
}
