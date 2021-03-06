<?php

namespace App\Controller;

use App\Service\ProductService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController {

    private ProductService $productService;

    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


    /**
     * @Route("/{id<\d+>}", name="product_details")
     * @param int $id
     * @return Response
     */
    public function details(int $id){
        return $this->render("product/details.html.twig", [
            "product" => $this->productService->getOneById($id)
        ]);
    }

    /**
     * @Route("/", name="product_list")
     * @return Response
     */
    public function list(LoggerInterface $logger){
        
        $logger->debug('on est passé dans list');
        
        return $this->render("product/list.html.twig", [
            "productList" => $this->productService->getAll(),
            "title" => "Liste de tous les produits",
            "categoryList" => $this->productService->getDistinctCategories(),
            "currentCategory" => null
        ]);
    }

    /**
     * @Route("/by-category/{category}",
     *         name="product_by_category")
     * @param string $category
     * @return Response
     */
    public function byCategory(string $category){
        return $this->render("product/list.html.twig", [
            "productList" => $this->productService->getAllByCategory($category),
            "title" => "Liste des produits dans la catégorie : $category",
            "categoryList" => $this->productService->getDistinctCategories(),
            "currentCategory" => $category
        ]);
    }

}
