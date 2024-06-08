<?php

namespace App\Controller;
use App\Entity\Service;
use App\Entity\Category;
use App\Form\ServiceType;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use APP\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\FileUpload;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;




class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/addformcategory', name: 'addformcategory')]
    public function addformbook( ManagerRegistry $managerRegistry, Request $req  ,FlashBagInterface $flashBag): Response
    {
        $x=$managerRegistry->getManager();
        $cat=new Category();
        $form=$this->createForm(CategoryType::class,$cat);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid())
        {
        
// Ajouter un message flash de succès
$flashBag->add('success', 'La réservation a été ajoutée avec succès.');
         $x->persist($cat);
       
        $x->flush();
       
        return $this->redirectToRoute('showdbcategory');
    }
    return $this->renderForm('category/formcategorie.html.twig', [
        'f'=>$form
    ]);
    }

    #[Route('/showdbcategorief', name: 'showdbcategoryf')] //affichage
    public function showdbauthorf(CategoryRepository $categoryRepository): Response
    {

        $cat=$categoryRepository->findAll();
        return $this->render('base2.html.twig', [
            'cat'=>$cat

        ]);
    }
    #[Route('/showdbcategorie', name: 'showdbcategory')] //affichage
    public function showdbauthor(CategoryRepository $categoryRepository): Response
    {

        $cat=$categoryRepository->findAll();
        return $this->render('category/tablecategorie.html.twig', [
            'cat'=>$cat

        ]);
    }



    #[Route('/showdbcategorief1', name: 'showdbcategoryf')] //affichage f
    public function showdbcategoryf(CategoryRepository $categoryRepository,ServiceRepository $serviceRepository): Response
    {
        $service = $serviceRepository->findAll();
        $cat=$categoryRepository->findAll();
        return $this->render('service/showservicebyid.html.twig', [
            'cat'=>$cat,
            'services' => $service,
        ]);
    }


   


    #[Route('/editcategorie/{id}', name: 'editcategorie')]
    public function editcategorie($id, CategoryRepository $categorieRepository, ManagerRegistry $managerRegistry,Request $req): Response
    {
       
       
        $x = $managerRegistry->getManager();
        $dataid=$categorieRepository->find($id); 
        
        $form=$this->createForm(CategoryType::class,$dataid);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
        $x->persist($dataid);
        $x->flush();
           return $this->redirectToRoute('showdbcategory');

        }
        return $this->renderForm('category/editcategorie.html.twig', [
            'x' => $form 
        ]);

    }
    
    #[Route('/deletecategorie/{id}', name: 'deletecategorie')]
    public function deletecategorie($id, ManagerRegistry $managerRegistry,CategoryRepository $categoryRepository): Response
    {
        $em = $managerRegistry->getManager();
        $dataid = $categoryRepository->find($id);
        $em->remove($dataid);
        $em->flush();
        return $this->redirectToRoute('showdbcategory');
    }


}
