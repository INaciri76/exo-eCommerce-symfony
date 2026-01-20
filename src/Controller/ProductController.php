<?php

namespace App\Controller;

use App\Security\Voter\ProductVoter;
use App\Repository\ProductRepository;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/produit/{id}', name: 'app_product_detail')]
    public function detail(Product $product): Response
    {
        return $this->render('product/detail.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/admin/products', name: 'admin_product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin/product/index.html.twig', ['products' => $productRepository->findAll()]);
    }

    #[Route('/admin/products/add', name: 'admin_product_add')]
    public function add(): Response
    {
        $this->denyAccessUnlessGranted('PRODUCT_EDIT');
        return $this->render('admin/product/add.html.twig');
        

    }

    #[Route('/admin/products/edit/{id}', name: 'admin_product_edit')]
    public function edit(Product $product): Response
    {
        $this->denyAccessUnlessGranted(ProductVoter::EDIT, $product);
        return $this->render('admin/product/edit.html.twig', ['product' => $product]);
    }

    #[Route('/admin/products/delete/{id}', name: 'admin_product_delete')]
    public function delete(Product $product, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted(ProductVoter::DELETE, $product);
        $manager->remove($product);
        $manager->flush();

        return $this->redirectToRoute('admin_product_index');
    }   

}