<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Form\RapportType;
use App\Form\Rapport1Type;
use App\Repository\RapportRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RendezvousRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class RapportController extends AbstractController
{
    #[Route('/rapport', name: 'app_rapport')]
    public function index(): Response
    {
        return $this->render('rapport/index.html.twig', [
            'controller_name' => 'RapportController',
        ]);
    }

    #[Route('/showrapport', name: 'showrapport')]
    public function showrapport(RapportRepository $rapportRepository): Response
    {
        $rpport=$rapportRepository->findAll();
        
        return $this->render('admin/showrapport.html.twig', [
            'rapport' => $rpport,
            
        ]);
        
    }

    #[Route('/addrapport', name: 'addrapport')]
    public function addrapport(ManagerRegistry $managerRegistry,Request $request, RendezvousRepository $rendezvousRepository): Response
    {
        
       $x=$managerRegistry->getManager();
        

       
        $rapport=new Rapport();
        //$rendezvousSansRapport = $rendezvousRepository->findRendezvousSansRapport();

        $form=$this->createForm(RapportType::class,$rapport);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid())
        {
            $rendezvous=$rapport->getRendezvous();
            $rendezvousSansRapport = $rendezvousRepository->findRendezvousSansRapport();
             
            if ($rendezvous->getRapport() === null)
        {
            $rendezvous->setRapport($rapport);
            $x->persist($rendezvous);
            $x->persist($rapport);
            $x->flush();
            return $this->redirectToRoute('showrapport');
        }

        }
        return $this->renderForm('admin/addrapport.html.twig', [
            'f' => $form,
        ]);
    }

    #[Route('/editrapport/{id}', name: 'editrapport')]
    public function editrapport(ManagerRegistry $managerRegistry,RapportRepository $repositery,Request $req,$id): Response
    {
        $x=$managerRegistry->getManager();
        $rd=$repositery->find($id);
        $form=$this->createForm(Rapport1Type::class,$rd);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()){
            //$rendezvous=$rd->getRendezvous();
           // if ($rendezvous->getRapport() === null)
            //{
                //$rendezvous->setRapport($rd);
            
            $x->persist($rd);
            //$x->persist($rendezvous);
            $x->flush();
           // }
            return $this->redirectToRoute('showrapport');
        }

        return $this->renderForm('admin/editrapport.html.twig', [
            'f' => $form
        ]);
    }

    #[Route('/deleterapport/{id}', name: 'deleterapport')]
    public function deleterapport(ManagerRegistry $managerRegistry,$id,RapportRepository $rendezvous): Response
    {
        $x=$managerRegistry->getManager();
        $rd=$rendezvous->find($id);
        $x->remove($rd);
        $x->flush();
        return $this->redirectToRoute('showrapport');
    }

    /////////////////////////////////////PDF////////////////////


    #[Route('/pdfrapport/{id}', name: 'pdfrapport')]
    public function pdfrapport($id ,RapportRepository $rapport): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $rp = $rapport->find($id);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('admin/pdfrapport.html.twig', [
            'r' => $rp,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();

        // Specify the file name
        $pdfFilename = 'mypdf.pdf';

        // Create a Symfony Response with PDF content
        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $pdfFilename . '"');

        return $response;
}

}
