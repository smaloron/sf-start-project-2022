<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController {

    private ProductRepository $repository;

    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService,
                                ProductRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @Route("/{id<\d+>}", name="product_details")
     * @param int $id
     * @return Response
     */
    public function details(int $id){
        return $this->render("product/details.html.twig", [
            "product" => $this->repository->findOneById($id)
        ]);
    }

    /**
     * @Route("/", name="product_list")
     * @return Response
     */
    public function list(LoggerInterface $logger){
        
        $logger->debug('on est passé dans list');
        
        return $this->render("product/list.html.twig", [
            "productList" => $this->repository->findAll(),
            "title" => "Liste de tous les produits",
            "categoryList" => $this->repository->getDistinctCategories(),
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
            "productList" => $this->repository->findBy(["category" => $category]),
            "title" => "Liste des produits dans la catégorie : $category",
            "categoryList" => $this->repository->getDistinctCategories(),
            "currentCategory" => $category
        ]);
    }

    /**
     * @Route("/delete/{id<\d+>}", name="product_delete")
     * @param int $id
     * @param EntityManagerInterface $manager
     * @return RedirectResponse|NotFoundHttpException
     */
    public function deleteOne(int $id, EntityManagerInterface $manager): RedirectResponse|NotFoundHttpException{
        $product = $this->repository->findOneBy(["id" => $id]);
        if(! $product) {
            return $this->createNotFoundException("Ce produit n'existe pas");
        }

        $manager->remove($product);

        $manager->flush();

        return $this->redirectToRoute("product_list");

    }

    /**
     * @Route("/new", name="product_new")
     * @Route("/edit/{id<\d+>}", name="product_edit")
     */
    public function addOrEditProduct(
        Request $request,
        EntityManagerInterface $manager,
        int $id = null): NotFoundHttpException|RedirectResponse|Response
    {
        if($id !== null){
            // Récupération d'un produit existant
            $product = $this->repository->findOneById($id);

            // test de produit non trouvé
            if(! $product){
                return $this->createNotFoundException("Produit non trouvé");
            }
        } else {
            // Instanciation d'un produit vide
            $product = new Product();
        }

        // Création du formulaire
        $form = $this->createForm(
            ProductType::class,
            $product
        );

        // Hydratation du formulaire avec la requête HTTP
        // Cette opération hydrate également l'éventuelle
        // entité liée et effectue les validations définies
        // au niveau du formulaire ou de l'entité
        $form->handleRequest($request);

        // Traitement du formulaire si celui-ci est posté
        // et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()){
            // Sauvegarde de l'entité dans la BD
            $manager->persist($product);
            $manager->flush();

            // Redirection vers la liste des produits
            return $this->redirectToRoute("product_list");
        }

        return $this->render("product/form.html.twig", [
            "productForm" => $form->createView()
        ]);
    }

}
