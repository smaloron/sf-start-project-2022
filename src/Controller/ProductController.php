<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/product/{id<\d+>}", name="product_details")
     * @param int $id
     * @return Response
     */
    public function details(int $id){
        return $this->render("product/details.html.twig", [
            "product" => $this->productService->getOneById($id)
        ]);
    }

    /**
     * @Route("/product", name="product_list")
     * @return Response
     */
    public function list(){
        return $this->render("product/list.html.twig", [
            "productList" => $this->productService->getAll()
        ]);
    }

    /**
     * @Route("/product/by-category/{category}",
     *         name="product_by_category")
     * @param string $category
     */
    public function byCategory(string $category){

    }

}
