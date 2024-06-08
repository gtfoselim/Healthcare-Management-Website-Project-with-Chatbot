<?php

namespace App\Controller;
use App\Repository\ReservationserviceRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Reservationservice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReservationserviceType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
class ReservationserviceController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('reservationservice/admin.html.twig', [
            'controller_name' => 'ReservationserviceController',
        ]);
    }

    
    #[Route('/addformreservationser', name: 'addformreservationser')]
    public function addformreservationser(ManagerRegistry $managerRegistry, Request $req, MailerInterface $mailer, FlashBagInterface $flashBag): Response
    {
        $em = $managerRegistry->getManager();
        $res = new Reservationservice();
        $form = $this->createForm(ReservationserviceType::class, $res);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            // Générer l'e-mail de réservation
            $reser = $form->getData();
            $emailContent = '
                <div style="max-width: 600px; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border-radius: 10px; font-family: Arial, sans-serif;">
                    <div style="background-color:#ffd000; color: #fff; padding: 15px; text-align: center; border-radius: 10px 10px 0 0;">
                        <h1 style="margin: 0;"> Réservation a traiter </h1>
                    </div>
                    <div style="padding: 20px;">
                        <p style="font-size: 18px; color: #333;">Cher(e) <strong>' . $reser->getNom() . '</strong>,</p>
                        <p style="font-size: 16px; color: #555;">Nous sommes heureux de vous informer que votre réservation pour le service <strong>' . $reser->getIdserivce() . '</strong> est en cours.</p>
                        <p style="font-size: 16px; color: #555;">N\'hésitez pas à nous contacter si vous avez des questions ou besoin d\'assistance supplémentaire.</p>
                        <p style="font-size: 16px; color: #555;">Cordialement,</p>
                        <p style="font-size: 16px; color: #555;">L\'équipe Visita</p>
                    </div>
                </div>';

            $email = (new Email())
                ->from('ADMINVisita@gmail.com')
                ->to($reser->getEmail()) // Envoyer l'e-mail de confirmation à l'utilisateur
                ->subject('Confirmation de Réservation - Visita')
                ->html($emailContent);

            // Envoyer l'e-mail
            $mailer->send($email);

            // Enregistrer la réservation
            $em->persist($res);
            $em->flush();
// Ajouter un message flash de succès
       $flashBag->add('success', 'La réservation a été ajoutée avec succès.');

            // Rediriger vers la page de formulaire
            return $this->redirectToRoute('addformreservationser');
        }

        // Afficher le formulaire
        return $this->renderForm('reservationservice/formreservationser.html.twig', [
            'f' => $form
        ]);
    }

    #[Route('/showdbreservationser', name: 'showdbreservationser')] //affichage
    public function showdbreservationserv(ReservationserviceRepository $ReservationserviceRepository): Response
    {
 
        $resser=$ReservationserviceRepository->findAll();
        return $this->render('reservationservice/tablereservationser.html.twig', [
            'resser'=>$resser

        ]);
    }

    #[Route('/deletecreservationser/{id}', name: 'deletecreservationser')]
    public function deletecreservationser($id, ManagerRegistry $managerRegistry,ReservationserviceRepository $reservationserviceRepository, FlashBagInterface $flashBag): Response
    {
        $em = $managerRegistry->getManager();
        $dataid = $reservationserviceRepository->find($id);
        $flashBag->add('danger', 'La réservation a été supprimer  avec succès.');
        $em->remove($dataid);
        $em->flush();
        return $this->redirectToRoute('showdbreservationser');
    }

    #[Route('/rejectreservationser/{id}', name: 'rejectreservationser')]
    public function rejectreservationser($id, ManagerRegistry $managerRegistry, MailerInterface $mailer, ReservationserviceRepository $reservationserviceRepository): Response
    {
        $em = $managerRegistry->getManager();
        $dataid = $reservationserviceRepository->find($id);

        // Construire le contenu HTML du courriel de rejet
        $htmlContent = '
            <div style="max-width: 600px; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border-radius: 10px; font-family: Arial, sans-serif;">
                <div style="background-color: #f44336; color: #fff; padding: 15px; text-align: center; border-radius: 10px 10px 0 0;">
                    <h1 style="margin: 0;">Rejet de Réservation</h1>
                </div>
                <div style="padding: 20px;">
                    <p style="font-size: 18px; color: #333;">Cher(e) <strong>' . $dataid->getNom() . '</strong>,</p>
                    <p style="font-size: 16px; color: #555;">Nous regrettons de vous informer que votre réservation pour le service <strong>' . $dataid->getIdserivce() . '</strong> a été rejetée.</p>
                    <p style="font-size: 16px; color: #555;">Si vous avez des questions ou besoin de plus d\'informations, n\'hésitez pas à nous contacter.</p>
                    <p style="font-size: 16px; color: #555;">Cordialement,</p>
                    <p style="font-size: 16px; color: #555;">L\'équipe Visita</p>
                </div>
            </div>';

        // Envoyer l'email de rejet
        $email = (new Email())
            ->from('ADMINVisita@gmail.com')
            ->to('you@example.com') // Remplacez cela par l'adresse email appropriée
            ->subject('Rejet de Réservation - Visita')
            ->html($htmlContent);

        $mailer->send($email);

        // Supprimer l'entité de réservation rejetée
        $em->remove($dataid);
        $em->flush();

        // Rediriger vers la page qui affiche les réservations
        return $this->redirectToRoute('showdbreservationser');
    }



    #[Route('/verificationparmail/{id}', name: 'verificationparmail')]
    public function verificationparmail( $id, ReservationserviceRepository $reservationRepository ,ManagerRegistry $managerRegistry, MailerInterface $mailer,Request $req): Response
    {
        $x=$managerRegistry->getManager();
        $dataid=$reservationRepository->find($id);
        $form=$this->createForm(ReservationserviceType::class,$dataid);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid())
        {
          // Récupérer les données du formulaire
          $formData = $form->getData();
          // Récupérer l'email du formulaire (modifier cette ligne selon votre structure de formulaire)
          $emailRecipient = $formData->getEmail();
            //EMAIL
            $htmlContent = '
            <div style="max-width: 600px; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border-radius: 10px; font-family: Arial, sans-serif;">
                <div style="background-color: #4CAF50; color: #fff; padding: 15px; text-align: center; border-radius: 10px 10px 0 0;">
                    <h1 style="margin: 0;">Confirmation de Réservation</h1>
                </div>
                <div style="padding: 20px;">
                    <p style="font-size: 18px; color: #333;">Cher(e) <strong>' . $formData->getNom() . '</strong>,</p>
                    <p style="font-size: 16px; color: #555;">Nous avons le plaisir de vous informer que votre réservation pour le service <strong>' . $formData->getIdserivce() . '</strong> a été confirmée avec succès.</p>
                    <p style="font-size: 16px; color: #555;">Nous vous remercions pour votre confiance et restons à votre disposition pour toute question éventuelle.</p>
                    <p style="font-size: 16px; color: #555;">Cordialement,</p>
                    <p style="font-size: 16px; color: #555;">L\'équipe Visita</p>
                </div>
            </div>';
        
        $email = (new Email())
            ->from('ADMINVisita@gmail.com')
            ->to($emailRecipient)
            ->subject('Confirmation de Réservation - Visita')
            ->html($htmlContent);
        

               

        $mailer->send($email);
         
         $x->persist($dataid);
       
        $x->flush();
       
        return $this->redirectToRoute('showdbreservationser');
    }
    return $this->renderForm('reservationservice/verificationparmail.html.twig', [
        'x'=>$form
    ]);
    }

    #[Route('/chartservice', name: 'chartservice')]
    public function chart(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Reservationservice::class);

        // Compter le nombre de réservations par service
        $reservationsByService = $repository->createQueryBuilder('r')
            ->select('s.nom AS serviceName, COUNT(r.id) AS reservationCount')
            ->join('r.idserivce', 's')
            ->groupBy('s.id')
            ->orderBy('reservationCount', 'DESC')
            ->setMaxResults(5) // Récupérer les 5 services les plus réservés
            ->getQuery()
            ->getResult();

        // Extraire les noms de service et les nombres de réservations pour les passer à Twig
        $serviceNames = [];
        $reservationCounts = [];
        foreach ($reservationsByService as $service) {
            $serviceNames[] = $service['serviceName'];
            $reservationCounts[] = $service['reservationCount'];
        }

        return $this->render('reservationservice/chart.html.twig', [
            'serviceNames' => json_encode($serviceNames),
            'reservationCounts' => json_encode($reservationCounts),
        ]);
    }


    

}
