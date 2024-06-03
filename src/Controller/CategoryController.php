<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'categories_list')]
    public function list(CategoryRepository $categoryRepository): Response
    {
        // Récupérer toutes mes catégories
        // Puis les envoyer à la vue pour un rendu
        $categories = $categoryRepository->findAll();
        // dd($categories);

        return $this->render('category/list.html.twig');
    }
}
