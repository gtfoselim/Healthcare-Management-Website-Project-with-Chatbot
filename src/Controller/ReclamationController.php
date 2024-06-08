<?php

namespace App\Controller;
use Knp\Snappy\Pdf;
use Twig\Environment;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Form\SearchReclamationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ReclamationRepository;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'display_reclamations')]
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }

    #[Route('/admin', name: 'adisplay_admin')]
    public function indexAdmin(): Response
    {
        return $this->render('Admin/index.html.twig');
    }

    #[Route('/addReclamation', name: 'add_reclamation')]
    public function addReclamation(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $entityManager = $managerRegistry->getManager();
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reclamation);
            $entityManager->flush();
            return $this->redirectToRoute('show_reclamations');
        }
        return $this->renderForm('reclamation/createReclamation.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/showReclamations', name: 'show_reclamations')]
    public function showReclamations(Request $request, ReclamationRepository $reclamationRepository): Response
{
    $form = $this->createForm(SearchReclamationType::class);
    $form->handleRequest($request);

    $criteria = [];
    $nom = null;

    if ($form->isSubmitted() && $form->isValid()) {
        // Récupérer les données du formulaire
        $data = $form->getData();

        // Construire les critères de recherche
        if (!empty($data['title'])) {
            $criteria['sujet'] = $data['title'];
        }
        if (!empty($data['category'])) {
            $criteria['categorie'] = $data['category'];
        }
        if (!empty($data['submissionDate'])) {
            $criteria['subdate'] = $data['submissionDate'];
        }

        // Récupérer le nom pour filtrer par nom
        $nom = $data['nom'];
    }

    // Si le nom est fourni, filtrer les réclamations par nom
    if ($nom) {
        $reclamations = $reclamationRepository->findByNom($nom);
    } else {
        // Sinon, récupérer toutes les réclamations
        $reclamations = [];
    }

    return $this->render('reclamation/showReclamations.html.twig', [
        'form' => $form->createView(),
        'reclamations' => $reclamations,
    ]);
}

    #[Route('/editReclamation/{id}', name: 'edit_reclamation')]
    public function editReclamation($id, ReclamationRepository $reclamationRepository, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $entityManager = $managerRegistry->getManager();
        $reclamation = $reclamationRepository->find($id);

        if ($reclamation->hasReplies()) {
            $this->addFlash('warning', 'Cette réclamation a des réponses et ne peut pas être modifiée.');
            return $this->redirectToRoute('show_reclamations');
        }

        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('show_reclamations');
        }

        return $this->renderForm('reclamation/editReclamation.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/deleteReclamation/{id}', name: 'delete_reclamation')]
    public function deleteReclamation($id, ManagerRegistry $managerRegistry, ReclamationRepository $reclamationRepository): Response
    {
        $entityManager = $managerRegistry->getManager();
        $reclamation = $reclamationRepository->find($id);
        if (!$reclamation) {
            throw $this->createNotFoundException('Réclamation non trouvée');
        }
        $entityManager->remove($reclamation);
        $entityManager->flush();
        return $this->redirectToRoute('show_reclamations');
    }

    #[Route('/show_dbreplies/{id}', name: 'show_dbreplies')]
    public function showReplies(Reclamation $reclamation): Response
    {
        $replies = $reclamation->getReplies();
        return $this->render('reclamation/replies.html.twig', [
            'reclamation' => $reclamation,
            'replies' => $replies
        ]);
    }

    #[Route('/show_stats', name: 'test')]
    public function showStats(ReclamationRepository $reclamationRepository): Response
    {
        $totalReclamations = $reclamationRepository->countTotalReclamations();
        $categoriesCount = $reclamationRepository->countReclamationsByCategory();

        $stats = [
            'total_reclamations' => $totalReclamations,
            'categories_count' => $categoriesCount,
        ];

        return $this->render('reclamation/stats.html.twig', [
            'stats' => $stats,
        ]);
    }

    #[Route('/search', name: 'search')]
    public function searchAction(Request $request, ReclamationRepository $reclamationRepository): JsonResponse
    {
        // Récupérer les données de la requête
        $title = $request->query->get('title');
        $category = $request->query->get('category');
        $submissionDate = $request->query->get('submissionDate');

        // Construire les critères de recherche
        $criteria = [];
        if (!empty($title)) {
            $criteria['title'] = $title;
        }
        if (!empty($category)) {
            $criteria['category'] = $category;
        }
        if (!empty($submissionDate)) {
            $criteria['submissionDate'] = $submissionDate;
        }

        // Effectuer la recherche avancée
        $reclamations = $reclamationRepository->searchAdvanced($criteria);

        // Convertir les résultats en format JSON
        $results = [];
        foreach ($reclamations as $reclamation) {
            $results[] = [
                'id' => $reclamation->getId(),
                'title' => $reclamation->getTitle(),
                'category' => $reclamation->getCategory(),
                'submissionDate' => $reclamation->getSubmissionDate()->format('Y-m-d H:i:s'),
                // Ajoutez d'autres données de réclamation selon vos besoins
            ];
        }

        // Retourner les résultats au format JSON
        return new JsonResponse($results);
    }

    #[Route('/generate-pdf/{id}', name: 'generate_pdf')]
    public function generatePdf($id, ReclamationRepository $reclamationRepository, ManagerRegistry $managerRegistry, Environment $twig): Response
    {
        // Récupérer la réclamation à partir de son ID
        $reclamation = $reclamationRepository->find($id);

        // Vérifier si la réclamation existe
        if (!$reclamation) {
            throw $this->createNotFoundException('Réclamation non trouvée');
        }

        // Générer le contenu HTML du PDF à partir du modèle Twig
        $html = $twig->render('reclamation/pdf_template.html.twig', [
            'reclamation' => $reclamation,
        ]);

        // Créer une instance de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendre le PDF
        $dompdf->render();

        // Retourner une réponse avec le contenu du PDF
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}
