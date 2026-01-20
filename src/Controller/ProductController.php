<?php

namespace App\Controller;

use App\Form\ProductFormType;
use App\Security\Voter\ProductVoter;
use App\Repository\ProductRepository;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/admin/products/ajout', name: 'admin_product_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Convertir le prix en centimes
            $product->setPrice($product->getPrice() * 100);

            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit ajouté avec succès');

            return $this->redirectToRoute('admin_product_index');
        }

        return $this->render('admin/product/add.html.twig', [
            'form' => $form->createView(),
        ]);
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
        // dd($this->getUser(), $this->getUser()->getRoles());
        $this->denyAccessUnlessGranted(ProductVoter::DELETE, $product);
        $manager->remove($product);
        $manager->flush();

        return $this->redirectToRoute('admin_product_index');
    }
}
