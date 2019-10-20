<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        CategoryRepository $categoryRepository,

        Request $request,
        PaginatorInterface $paginator
    )
    {
        $categories = $categoryRepository->findAll();
        $pagination = $paginator->paginate(
            $categories,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'pagination' => $pagination,
            'partial' => 'main/_category.html.twig'
        ]);
    }
    /**
     * @Route("product_listing/{category}", name="product_listing")
     */
    public function product_listing(int $category,
        Request $request,
        ProductRepository $productRepository,
        PaginatorInterface $paginator
    )
    {
        $products = $productRepository->findByCategory($category);

        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('main/index.html.twig', [
            'pagination' => $pagination,
            'partial' => 'main/_product.html.twig'
        ]);
    }
    /**
     * @Route("product_info/{product}", name="product_info")
     */
    public function product_info(int $product,Request $request, ProductRepository $productRepository)
    {
        $product = $productRepository->find($product);
        return $this->render('main/product.html.twig', [
            'product' => $product
        ]);
    }
}
