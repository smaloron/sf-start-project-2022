<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/blog')]
class BlogController extends AbstractController
{
    private ArticleRepository $repository;

    /**
     * @param ArticleRepository $repository
     */
    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }


    #[Route('/', name: 'blog_home')]
    public function index(): Response
    {
        $articleList = $this->repository->findBy([],['createdAt' => 'DESC'], 4);

        return $this->render('blog/index.html.twig', [
            'articleList' => $articleList
        ]);
    }

    #[Route('/details/{id<\d+>}', name: 'blog_details')]
    public function details(
        EntityManagerInterface $manager,
        Request $request,
        int $id = null): Response{
        $article = $this->repository->findOneById($id);

        // Création du formulaire pour les commentaires
        $comment = new Comment();
        $comment->setCreatedAt(new DateTime())
                ->setArticle($article);

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('blog_details', ['id' => $id]);
        }

        return $this->render('blog/details.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
    }

    #[Route('/list', name: 'blog_list')]
    public function list(): Response {
        $articleList = $this->repository->findBy([], ['createdAt' => 'DESC']);
        return $this->render(
            'blog/list.html.twig',
            [
                'articleList' => $articleList,
                'title' => 'Liste des articles'
            ]
        );
    }

    #[Route('/by-author/{authorId<\d+>}', name: 'blog_by_author')]
    public function articleByAuthor(
        AuthorRepository $authorRepository,
        int $authorId): Response {

        $author = $authorRepository->findOneById($authorId);

        return $this->render(
            'blog/list.html.twig',
            [
                'title' => 'Liste des articles de '.$author->getFullName(),
                'articleList' => $author->getArticles()
            ]
        );


    }
}
