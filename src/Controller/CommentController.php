<?php

namespace App\Controller;


use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{

    #[Route('/comment', name: 'app_comment', methods: ['GET'])]
    public function index(commentRepository $repo): Response
    {   $tab = $repo->findAll();
        return $this->render('comment/index.html.twig', [
            'tab' => $tab,
        ]);
    }

    

    

    private $entityManager; // Define EntityManager

    // Inject EntityManager into the constructor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/adminc', name: 'adminc')]
    public function  indexx(commentRepository $repoo): Response
    {   $tabbb = $repoo->findAll();
        return $this->render('Admin\showcomments.html.twig', [
            'tabbb' => $tabbb,
        ]);
    }



    #[Route('/editcomment/{id}', name: 'editcomment')]
    public function editcomment($id, CommentRepository $commentRepository, ManagerRegistry $managerRegistry, Request $req): Response
    {
        //var_dump($id) . die();
        $x = $managerRegistry->getManager();
        $dataid = $commentRepository->find($id);
        // var_dump($dataid) . die();
        $form = $this->createForm(CommentType::class, $dataid);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $x->persist($dataid);
            $x->flush();
            return $this->redirectToRoute('app_post');
        }
        return $this->renderForm('comment/addcomment.html.twig', [
            'commentForm' => $form
        ]);
    }

    #[Route('/deletecomment/{id}', name: 'deletecomment')]
    public function deletecomment($id, ManagerRegistry $managerRegistry, CommentRepository $commentRepository): Response
    {
        $em = $managerRegistry->getManager();
        $dataid = $commentRepository->find($id);
        $post = $dataid->getIdPost();
        $em->remove($dataid);

        if ($post) {
            $post->setNbCommentsPost($post->getNbCommentsPost() - 1);
            $em->persist($post);
        }
        $em->flush();
        return $this->redirectToRoute('app_post');
    }




    #[Route('/addlikecomment/{id}', name: 'addlikecomment')]
    public function adlikepost($id, CommentRepository $commentRepository, EntityManagerInterface $entityManager): Response
    {
        // Find the post entity by ID
        $comment = $commentRepository->find($id);

        if (!$comment) {
            // Post not found, handle this case accordingly
            throw $this->createNotFoundException('Post not found');
        }

        // Set validation status to 1
        $comment    ->setLikesComment($comment->getLikesComment()+1);
        $entityManager->persist($comment);

        // Persist changes to the database using the injected EntityManager
        $this->entityManager->flush();

        // Redirect to the route named 'app_post'
        return $this->redirectToRoute('app_post');
    }


    #[Route('/adddislikecomment/{id}', name: 'adddislikecomment')]
    public function adddislikepost($id, CommentRepository $commentRepository, EntityManagerInterface $entityManager): Response
    {
        // Find the post entity by ID
        $comment = $commentRepository->find($id);

        if (!$comment) {
            // Post not found, handle this case accordingly
            throw $this->createNotFoundException('Post not found');
        }

        // Set validation status to 1
        $comment    ->setDislikesComment($comment->getDislikesComment()+1);
        $entityManager->persist($comment);

        // Persist changes to the database using the injected EntityManager
        $this->entityManager->flush();

        // Redirect to the route named 'app_post'
        return $this->redirectToRoute('app_post');
    }




    // #[Route('/addformcomment/{id}', name: 'addformcomment')]
    // public function addformcomment($id,ManagerRegistry $managerRegistry, Request $req): Response
    // {
    //     $x = $managerRegistry->getManager();
    //     $comment = new Comment();
    //     $form = $this->createForm(CommentType::class, $comment);
    //     $form->handleRequest($req);
    //     if ($form->isSubmitted() and $form->isValid()) {
    //         $x->persist($comment);
    //         $x->flush();
            
    //         return $this->redirectToRoute('app_comment');
    //     }
    //     return $this->renderForm('comment/addcomment.html.twig', [
    //         'f' => $form,
    //         'post_id' => $id,
    //     ]);
    // }

    

    #[Route('/addformcomment/{id}', name: 'addformcomment')]
    public function addformcomment($id, ManagerRegistry $managerRegistry, Request $req): Response
    {
        $entityManager = $managerRegistry->getManager();
    
        // Find the post by ID
        $post = $entityManager->getRepository(Post::class)->find($id);
    
        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }
    
        // Create a new Comment instance
        $comment = new Comment();
        $comment->setIdPost($post); // Associate the comment with the post
    
        // Create the comment form
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($req);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the comment to the database
            $entityManager->persist($comment);
            $entityManager->flush();
            
    
            // Redirect to a suitable route
            return $this->redirectToRoute('app_comment');
        }
    
        // Render the comment form template
        return $this->render('post/showsingle.html.twig', [
            'form' => $form->createView(),
            'id' => $id, // Pass the post ID to the template
        ]);
    
}




}
