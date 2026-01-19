<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categorie/{id}', name: 'app_category_list')]

    public function list(Category $category): Response
    {
        $products = $category->getProducts();
        return $this->render('category/list.html.twig', [
            'category' =>  $category,
            'products' => $products

        ]);
    }
}
