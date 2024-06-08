<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $repo, PaginatorInterface $paginator,Request $request): Response
    {   $tab = $repo->findBy(['validation_post' => 1]);
        $tab2 = $repo->findBy(['type_post' => 'Medicine']);
        $tab3 = $repo->findBy(['type_post' => 'Lab test']);
        $tab4 = $repo->findBy(['type_post' => 'Equipments']);
        $tab5 = $repo->findBy(['type_post' => 'Free counselling']);
        $tab6 = $repo->findBy(['type_post' => 'Heart']);
        $numhart = count($tab6);
        $numcouns = count($tab5);
        $numequip = count($tab4);
        $nummed = count($tab2);
        $numlab = count($tab3);


        $pagination = $paginator->paginate(
            $tab, // Query results
            $request->query->getInt('page', 1), // Current page number, default to 1
            2 // Items per page
        );
        return $this->render('post/index.html.twig', [
            'pagination' => $pagination,
            'nummed' => $nummed,
            'numlab' => $numlab,
            'numequip' => $numequip,
            'numcouns' => $numcouns,
            'numhart' => $numhart,
        ]);
    }

    #[Route('/postmed', name: 'app_postmed')]
    public function indexmed(PostRepository $repo, PaginatorInterface $paginator,Request $request): Response
    {   $tab = $repo->findBy(['type_post' => 'Medicine']);
        $tab3 = $repo->findBy(['type_post' => 'Lab test']);
        $tab4 = $repo->findBy(['type_post' => 'Equipments']);
        $tab5 = $repo->findBy(['type_post' => 'Free counselling']);
        $tab6 = $repo->findBy(['type_post' => 'Heart']);
        $numhart = count($tab6);
        $numcouns = count($tab5);
        $numequip = count($tab4);
        $nummed = count($tab);
        $numlab = count($tab3);
        $pagination = $paginator->paginate(
            $tab, // Query results
            $request->query->getInt('page', 1), // Current page number, default to 1
            4 // Items per page
        );
        return $this->render('post/index.html.twig', [
            'pagination' => $pagination,
            'nummed' => $nummed,
            'numlab' => $numlab,
            'numequip' => $numequip,
            'numcouns' => $numcouns,
            'numhart' => $numhart,

        ]);
    }

    #[Route('/postlab', name: 'app_postlab')]
    public function indexlab(PostRepository $repo, PaginatorInterface $paginator,Request $request): Response
    {   $tab2 = $repo->findBy(['type_post' => 'Medicine']);
        $tab = $repo->findBy(['type_post' => 'Lab test']);
        $tab4 = $repo->findBy(['type_post' => 'Equipments']);
        $tab5 = $repo->findBy(['type_post' => 'Free counselling']);
        $tab6 = $repo->findBy(['type_post' => 'Heart']);
        $numhart = count($tab6);
        $numcouns = count($tab5);
        $numequip = count($tab4);
        $nummed = count($tab2);
        $numlab = count($tab);
        $pagination = $paginator->paginate(
            $tab, // Query results
            $request->query->getInt('page', 1), // Current page number, default to 1
            4 // Items per page
        );
        return $this->render('post/index.html.twig', [
            'pagination' => $pagination,
            'nummed' => $nummed,
            'numlab' => $numlab,
            'numequip' => $numequip,
            'numcouns' => $numcouns,
            'numhart' => $numhart,

        ]);
    }
    #[Route('/postHeart', name: 'app_postHeart')]
    public function indexHeart(PostRepository $repo, PaginatorInterface $paginator,Request $request): Response
    {   $tab2 = $repo->findBy(['type_post' => 'Medicine']);
        $tab3 = $repo->findBy(['type_post' => 'Lab test']);
        $tab4 = $repo->findBy(['type_post' => 'Equipments']);
        $tab5 = $repo->findBy(['type_post' => 'Free counselling']);
        $tab = $repo->findBy(['type_post' => 'Heart']);
        $numhart = count($tab);
        $numcouns = count($tab5);
        $numequip = count($tab4);
        $nummed = count($tab2);
        $numlab = count($tab3);
        $pagination = $paginator->paginate(
            $tab, // Query results
            $request->query->getInt('page', 1), // Current page number, default to 1
            4 // Items per page
        );
        return $this->render('post/index.html.twig', [
            'pagination' => $pagination,
            'nummed' => $nummed,
            'numlab' => $numlab,
            'numequip' => $numequip,
            'numcouns' => $numcouns,
            'numhart' => $numhart,

        ]);
    }
    #[Route('/postEquipments', name: 'app_postEquipments')]
    public function indexEquipments(PostRepository $repo, PaginatorInterface $paginator,Request $request): Response
    {   $tab2 = $repo->findBy(['type_post' => 'Medicine']);
        $tab3 = $repo->findBy(['type_post' => 'Lab test']);
        $tab = $repo->findBy(['type_post' => 'Equipments']);
        $tab5 = $repo->findBy(['type_post' => 'Free counselling']);
        $tab6 = $repo->findBy(['type_post' => 'Heart']);
        $numhart = count($tab6);
        $numcouns = count($tab5);
        $numequip = count($tab);
        $nummed = count($tab2);
        $numlab = count($tab3);
        $pagination = $paginator->paginate(
            $tab, // Query results
            $request->query->getInt('page', 1), // Current page number, default to 1
            4 // Items per page
        );
        return $this->render('post/index.html.twig', [
            'pagination' => $pagination,
            'nummed' => $nummed,
            'numlab' => $numlab,
            'numequip' => $numequip,
            'numcouns' => $numcouns,
            'numhart' => $numhart,

        ]);
    }
    #[Route('/postFreecounselling', name: 'app_postFreecounselling')]
    public function indexFreecounselling(PostRepository $repo, PaginatorInterface $paginator,Request $request): Response
    {   $tab2 = $repo->findBy(['type_post' => 'Medicine']);
        $tab3 = $repo->findBy(['type_post' => 'Lab test']);
        $tab4 = $repo->findBy(['type_post' => 'Equipments']);
        $tab = $repo->findBy(['type_post' => 'Free counselling']);
        $tab6 = $repo->findBy(['type_post' => 'Heart']);
        $numhart = count($tab6);
        $numcouns = count($tab);
        $numequip = count($tab4);
        $nummed = count($tab2);
        $numlab = count($tab3);
        $pagination = $paginator->paginate(
            $tab, // Query results
            $request->query->getInt('page', 1), // Current page number, default to 1
            4 // Items per page
        );
        return $this->render('post/index.html.twig', [
            'pagination' => $pagination,
            'nummed' => $nummed,
            'numlab' => $numlab,
            'numequip' => $numequip,
            'numcouns' => $numcouns,
            'numhart' => $numhart,

        ]);
    }




    


//     public function showPosts(Request $request, PostRepository $postRepository, PaginatorInterface $paginator)
// {
//     $postsQuery = $postRepository->findAllQuery(); // Assuming you have a method to get all posts

//     $pagination = $paginator->paginate(
//         $postsQuery,
//         $request->query->getInt('page', 1), // Get the current page number, default to 1 if not provided
//         10 // Number of items per page
//     );

//     return $this->render('post/index.html.twig', [
//         'pagination' => $pagination,
//     ]);
// }

    private $entityManager; // Define EntityManager
    private $postRepository;
    
    private $formFactory;

    // Inject EntityManager into the constructor
    public function __construct(EntityManagerInterface $entityManager,PostRepository $postRepository,

    FormFactoryInterface $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }
    

    #[Route('/admin', name: 'app_Admin')]
    public function  indexx(PostRepository $repoo): Response
    {   $tabb = $repoo->findAll();
        $tab2 = $repoo->findBy(['type_post' => 'Medicine']);
        $tab3 = $repoo->findBy(['type_post' => 'Lab test']);
        $tab4 = $repoo->findBy(['type_post' => 'Equipments']);
        $tab = $repoo->findBy(['type_post' => 'Free counselling']);
        $tab6 = $repoo->findBy(['type_post' => 'Heart']);
        $numhart = count($tab6);
        $numcouns = count($tab);
        $numequip = count($tab4);
        $nummed = count($tab2);
        $numlab = count($tab3);
        return $this->render('Admin/index.html.twig', [
            'tabb' => $tabb,
            'nummed' => $nummed,
            'numlab' => $numlab,
            'numequip' => $numequip,
            'numcouns' => $numcouns,
            'numhart' => $numhart,
        ]);
    }
    
    #[Route('/addformpost', name: 'addformpost')]
    public function addformpost(ManagerRegistry $managerRegistry, Request $req): Response
    {
        $x = $managerRegistry->getManager();
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $x->persist($post);
            $x->flush();
            
            return $this->redirectToRoute('app_post');
        }
        return $this->renderForm('post/addpost.html.twig', [
            'f' => $form
        ]);
    }



    #[Route('/editpost/{id}', name: 'editpost')]
    public function editpost($id, PostRepository $postRepository, ManagerRegistry $managerRegistry, Request $req): Response
    {
        //var_dump($id) . die();
        $x = $managerRegistry->getManager();
        $dataid = $postRepository->find($id);
        // var_dump($dataid) . die();
        $form = $this->createForm(PostType::class, $dataid);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $x->persist($dataid);
            $x->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->renderForm('post/addpost.html.twig', [
            'f' => $form
        ]);
    }

    #[Route('/deletepost/{id}', name: 'deletepost')]
    public function deletepost($id, ManagerRegistry $managerRegistry, PostRepository $postRepository): Response
    {
        $em = $managerRegistry->getManager();
        $dataid = $postRepository->find($id);
        $em->remove($dataid);
        $em->flush();
        return $this->redirectToRoute('admin');
    }
    // #[Route('/validpost/{id}', name: 'validpost')]
    // public function validpost($id, PostRepository $postRepository): Response
    // {
        
    //     $dataid = $postRepository->find($id);
    //     $dataid->setValidationPost('1');
        
    //     return $this->redirectToRoute('app_post');
    // }
    
    #[Route('/validpost/{id}', name: 'validpost')]
    public function validpost($id, PostRepository $postRepository): Response
    {
        // Find the post entity by ID
        $post = $postRepository->find($id);

        if (!$post) {
            // Post not found, handle this case accordingly
            throw $this->createNotFoundException('Post not found');
        }

        // Set validation status to 1
        $post->setValidationPost(1);

        // Persist changes to the database using the injected EntityManager
        $this->entityManager->flush();

        // Redirect to the route named 'app_post'
        return $this->redirectToRoute('admin');
    }

    #[Route('/addlikepost/{id}', name: 'addlikepost')]
    public function adlikepost($id, PostRepository $postRepository, EntityManagerInterface $entityManager): Response
    {
        // Find the post entity by ID
        $post = $postRepository->find($id);

        if (!$post) {
            // Post not found, handle this case accordingly
            throw $this->createNotFoundException('Post not found');
        }

        // Set validation status to 1
        $post->setLikesPost($post->getLikesPost()+1);
        $entityManager->persist($post);

        // Persist changes to the database using the injected EntityManager
        $this->entityManager->flush();

        // Redirect to the route named 'app_post'
        return $this->redirectToRoute('postsingle', ['id' => $id]);
    }


    
    #[Route('/adddislikepost/{id}', name: 'adddislikepost')]
    public function addislikepost($id, PostRepository $postRepository, EntityManagerInterface $entityManager): Response
    {
        // Find the post entity by ID
        $post = $postRepository->find($id);

        if (!$post) {
            // Post not found, handle this case accordingly
            throw $this->createNotFoundException('Post not found');
        }

        // Set validation status to 1
        $post->setDislikesPost($post->getDislikesPost()+1);
        $entityManager->persist($post);

        // Persist changes to the database using the injected EntityManager
        $this->entityManager->flush();

        // Redirect to the route named 'app_post'
        return $this->redirectToRoute('postsingle', ['id' => $id]);
    }


//     #[Route('/postsinglee/{id}', name: 'postsingle')]
// public function showPost($id, PostRepository $postRepository): Response
// {
//     // Find the post entity by ID
//     $post = $postRepository->find($id);
    

//     if (!$post) {
//         // Post not found, handle this case accordingly
//         throw $this->createNotFoundException('Post not found');
//     }

//     return $this->render('post/showsingle.html.twig', [
//         'post' => $post,
//     ]);
// }
    
    
    

    



    #[Route('/admin', name: 'app_admin')]
    public function indexAdmin(): Response
    {   
        return $this->render('Admin/index.html.twig' 
        );
    }


    // #[Route('/postsingle/{id}', name: 'postsingle')]
    // public function showPostt($id, Request $request): Response
    // {
    //     // Fetch the post using the injected repository
    //     $post = $this->postRepository->find($id);

    //     if (!$post) {
    //         // Post not found, handle this case accordingly
    //         throw $this->createNotFoundException('Post not found');
    //     }

    //     // Create a new Comment instance
    //     $comment = new Comment();
    //     // Create the comment form using the injected form factory
    //     $commentForm = $this->formFactory->create(CommentType::class, $comment);

    //     // Handle the comment form submission
    //     $commentForm->handleRequest($request);
    //     if ($commentForm->isSubmitted() && $commentForm->isValid()) {
    //         // Set the post for the comment
    //         $comment->setIdPost($post);

    //         // Save the comment to the database
    //         $this->entityManager->persist($comment);
    //         $this->entityManager->flush();

    //         // Redirect back to the same post page
    //         return $this->redirectToRoute('postsingle', ['id' => $id]);
    //     }

    //     return $this->render('post/showsingle.html.twig', [
    //         'post' => $post,
    //         'commentForm' => $commentForm->createView(), // Pass the comment form to the template
    //     ]);
    // }

    // #[Route('/admin', name: 'app_Adminn')]
    // public function  indexxx(commentRepository $repoo): Response
    // {   $tabb = $repoo->findAll();
    //     return $this->render('Admin/index.html.twig', [
    //         'tabb' => $tabb,
    //     ]);
    // }
    
    

    
    #[Route('/postsingle/{id}', name: 'postsingle')]
public function showPostt($id, Request $request, PostRepository $postRepository, EntityManagerInterface $entityManager, CommentRepository $commentRepository): Response
{
    // Fetch the post using the injected repository
    $post = $postRepository->find($id);

    if (!$post) {
        // Post not found, handle this case accordingly
        throw $this->createNotFoundException('Post not found');
    }
    $comments = $commentRepository->findBy(['id_post' => $id]);

    // Create a new Comment instance
    $comment = new Comment();
    // Set the associated post for the comment
    $comment->setIdPost($post);

    // Create the comment form
    $form = $this->createForm(CommentType::class, $comment);

    // Handle form submission
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $post->setNbCommentsPost($post->getNbCommentsPost() + 1);
        // Save the comment to the database
        $entityManager->persist($comment);
        $entityManager->persist($post);
        $entityManager->flush();

        // Redirect back to the same post page
        return $this->redirectToRoute('postsingle', ['id' => $id]);
    }

    return $this->render('post/showsingle.html.twig', [
        'post' => $post,
        'commentForm' => $form->createView(), // Pass the comment form to the template
        'comments' => $comments,
    ]);
}


    






   

}