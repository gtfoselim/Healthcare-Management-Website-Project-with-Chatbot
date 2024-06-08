<?php

namespace App\Controller;
use App\Entity\Service;
use App\Entity\Category;
use App\Form\ServiceType;
use App\Form\CalculatorType;
use Symfony\Component\HttpFoundation\JsonResponse;
use APP\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Repository\ServiceRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\FileUpload;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;



class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

   

    #[Route('/bookservice', name:'bookservice')]
    public function indexservice(): Response
    {
        return $this->render('bookservice.html.twig' 
            
        );
    }

    #[Route('/calculimc', name:'calculimc')]
    public function calculimc(): Response
    {
        return $this->render('imc/CalculIMC.html.twig' 
            
        );
    }
    
  /*#[Route('/user', name: 'app_services')]
    public function indexuser(): Response
    {
        return $this->render('user/index.html.twig' 
            
        );
    }*/

    #[Route('/addformservice', name: 'addformservice')]
    public function addformauthor(ManagerRegistry $managerRegistry , FlashBagInterface $flashBag ,Request $req): Response // managerregistery utilisé pour gérer les entités avec Doctrine
    {
        $x=$managerRegistry->getManager();//ya3mel ay update w ayy delete ay ajout chef
        $service=new Service();// Crée une nouvelle instance de l'entité 
        $form=$this->createForm(ServiceType::class,$service);//Crée un formulaire Symfony à partir de la classe ServiceType
        $form->handleRequest($req);//kima post bech thot fil base 
        if($form->isSubmitted() and $form->isValid())
        {
            $photoFile = $form->get('image')->getData();//récupère les données de l'élément de formulaire nommé image
    
            if ($photoFile) {
                $newFilename = uniqid().'.'.$photoFile->guessExtension();// uniqueid() génère un identifiant unique basé sur l'horodatage actuel
    
                try {
                    $photoFile->move(
                        $this->getParameter('image_directory'), // Specify the directory where photos should be uploaded
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle file upload error
                }
    
                // Update the photo path in the user entity
                $service->setImage($newFilename);
            } else {
                // Code pour affecter une image par défaut si aucune image n'est téléchargée
                $defaultImage = 'default_image.jpg'; // Remplacez 'default_image.jpg' par le chemin de votre image par défaut
                
                $service->setImage($defaultImage);
            }
          
            // Récupérer la catégorie associée au service
            $cat = $service->getIdCategorie();
          
            $x->persist($service);
            $x->flush();
            return $this->redirectToRoute('showdbservice', ['page' => 'back']);//bech ihezni lil page show kima href
        }
    
        return $this->renderForm('service/formservice.html.twig', [
            'f'=>$form,
        ]);
    }
    
    

    #[Route('/tableservice/{page}', name: 'showdbservice' , requirements: ['page2' => '^(front|back|front1)$'])] //affichage
    public function showdbservice(ServiceRepository $serviceRepository,CategoryRepository $categoryRepository , string $page): Response
    {

        $service=$serviceRepository->findAll();
        $cat=$categoryRepository->findAll();
         $service1 = $serviceRepository->findBy(['active' => true]);
         
      //$service=$ServiceRepository->orderbyusername();//tri ASC
      // $aservice=$serviceRepository-> seachwithalph();//recherche

      if ($page === 'back') {
        return $this->render('service/tableservice.html.twig', [
            'cat' => $cat,
            'service'=>$service

        ]);
       }elseif ($page === 'front') {
        // Rendre la seconde page
        return $this->render('service/frontaffichageservice.html.twig' , [
            'cat' => $cat,
            'service1'=>$service1
        ]);
    }

    return new Response('Page non trouvée', Response::HTTP_NOT_FOUND);

    }

    #[Route('/tableservicef', name: 'showdbservicef')] //affichage
    public function showdbauthorf(ServiceRepository $serviceRepository ,CategoryRepository $categoryRepository): Response
    {
        $cat=$categoryRepository->findAll();
        $service1 = $serviceRepository->findBy(['active' => true]);
       
      //$service=$ServiceRepository->orderbyusername();//tri ASC
      // $author=$authorRepository-> seachwithalph();//recherche
        return $this->render('service/showservicebycategory.html.twig', [
            'cat' => $cat,
            'service'=>$service1

        ]);
    }


    /*#[Route('/takeservice', name: 'takeservice')] //affichage1
    public function showdbauthorf1(ServiceRepository $serviceRepository ,CategoryRepository $categoryRepository): Response
    {
        $cat=$categoryRepository->findAll();
        $service1 = $serviceRepository->findBy(['active' => true]);
       
      //$service=$ServiceRepository->orderbyusername();//tri ASC
      // $author=$authorRepository-> seachwithalph();//recherche
        return $this->render('bookservice.html.twig', [
            'cat' => $cat,
            'service'=>$service1

        ]);
    }*/

    #[Route('/editsevice/{id}', name: 'editservice')]
    public function editservice($id, serviceRepository $serviceRepository, ManagerRegistry $managerRegistry,Request $req): Response
    {
       
       
        $x = $managerRegistry->getManager();
        $dataid=$serviceRepository->find($id); 
        
        $form=$this->createForm(Servicetype::class,$dataid);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){

            $photoFile = $form->get('image')->getData();

            if ($photoFile) {
                $newFilename = uniqid().'.'.$photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('image_directory'), // Specify the directory where photos should be uploaded
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle file upload error
                }

                // Update the photo path in the service entity
                $dataid->setImage($newFilename);
            }

            
        $x->persist($dataid);
        $x->flush();
           return $this->redirectToRoute('showdbservice', ['page' => 'back']);

        }
        return $this->renderForm('service/editservice.html.twig', [
            'x' => $form 
        ]);
    }

    #[Route('/deleteservice/{id}', name: 'deleteservice')]
    public function deleteauthor($id, ManagerRegistry $managerRegistry, ServiceRepository $serviceRepository): Response
    {
        $em = $managerRegistry->getManager();
        $dataid = $serviceRepository->find($id);
        $em->remove($dataid);
        $em->flush();
        return $this->redirectToRoute('showdbservice', ['page' => 'back']);
    }


    
  
    #[Route('/showidservice/{id}', name: 'showidservice')]
public function showidservice( $id,ServiceRepository $serviceRepository): Response
{
    // Find the post entity by ID
    $service= $serviceRepository->find($id);

    if (!$service) {
        // Post not found, handle this case accordingly
        throw $this->createNotFoundException('service not found');
    }

    return $this->render('service/showservicebyid.html.twig', [
        'service' => $service,
        
    ]);
}


#[Route('/showidcatservice/{id_category}', name: 'showidcatservice')]
public function showidcatservice($id_category, ServiceRepository $serviceRepository): Response
{
    // Find the services entities by category ID
    $service = $serviceRepository->findBy(['id_categorie' => $id_category , 'active' => true]);

    if (!$service) {
        // Services not found for the given category, handle this case accordingly
        return $this->render('service/nonservice.html.twig', [
            'service' => $service,
        ]);
    }

    return $this->render('service/showservicebycategory.html.twig', [
        'service' => $service,
    ]);
}
////// IMC////////
#[Route('/calculate-imc', name: 'calculate_imc')]
    public function calculateIMC(Request $request): Response
    {
        $form = $this->createForm(CalculatorType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $weight = $data['poids'];
            $height = $data['taille'];
            // Calcul de l'IMC (Indice de Masse Corporelle)
            $imc = $weight / ($height * $height);
            $idealWeight = 22 * ($height * $height);
            $idealWeightMin = $idealWeight * 0.95;
            $idealWeightMax = $idealWeight * 1.05;
    
            return $this->render('imc/resultat.html.twig', [
                'imc' => $imc,
                'idealWeight' => $idealWeight,
                'idealWeightMin' => $idealWeightMin,
                'idealWeightMax' => $idealWeightMax,
            ]);
        }
    
        return $this->render('imc/CalculIMC.html.twig', [
            'f' => $form->createView(),
        ]);
    }
//////////////multilangue




 
/////////// recherche ///////////////////
#[Route('/search', name: 'search')]
    public function searchAction(Request $request)
        {
            //the helper
            $em = $this->getDoctrine()->getManager();
            //9otlou jibli l haja hedhi
            $requestString = $request->get('q');
            //3amaliyet l recherche 
            $Service = $em->getRepository('App\Entity\Service')->findEntitiesByString($requestString);
            if(!$Service) {
                $result['Service']['error'] = "Don Not found 🙁 ";
            } else {
                $result['Service'] = $this->getRealEntities($Service);
            }
            return new Response(json_encode($result));
        }

        public function getRealEntities($Service){
            //lhne 9otlou aala kol don mawjouda jibli title wl taswira mte3ha
            foreach ($Service as $Service){
                $realEntities[$Service->getId()] = [$Service->getNom()];
    
            }
            return $realEntities;
        }
}