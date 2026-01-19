<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products', name: 'products_')]
final class ProductController extends AbstractController
{
    #[Route('/{id}', name: 'detail')]
    public function detail(Product $product): Response
    {
        // dd($product);
        return $this->render('product/detail.html.twig', [ 'product' => $product, ]);
        
    }
}
