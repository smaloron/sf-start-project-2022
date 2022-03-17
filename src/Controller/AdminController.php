<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/pending-comments', name: 'app_admin_comments')]
    public function showPendingComments(
        CommentRepository $repository
    ): Response
    {
        $pendingComments = $repository->findBy(["approvedAt" => null]);

        return $this->render('admin/comments.html.twig', [
            'pendingComments' => $pendingComments,
        ]);
    }

    #[Route('/comment/moderate/{id<\d+>}/{approved}', name: 'app_comments_moderate')]
    public function moderateComments(
        Comment $comment,
        bool $approved,
        EntityManagerInterface $manager
    ){
        $comment->setApproved($approved)
                ->setApprovedAt(new \DateTime());

        $manager->persist($comment);
        $manager->flush();

        return $this->redirectToRoute('app_admin_comments');
    }


}
