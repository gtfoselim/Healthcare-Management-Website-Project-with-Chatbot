<?php

namespace App\Controller;


use App\Entity\PdfGeneratorService;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evenement')]
class EvenementController extends AbstractController
{

    #[Route('/show_in_map/{id}', name: 'app_evenement_map', methods: ['GET'])]
    public function Map(Evenement $id, EntityManagerInterface $entityManager): Response
    {

        $id = $entityManager
            ->getRepository(Evenement::class)->findBy(
                ['id' => $id]
            );
        return $this->render('evenement/api_arcgis.html.twig', [
            'evenements' => $id,
        ]);
    }

    #[Route('/stat', name: 'app_evenement_indexstat', methods: ['GET', 'POST'])]
    public function index3(EvenementRepository $evenementRepository): Response
    {
        $evenement = $evenementRepository->findAll();
        $nomEvenement = [];
        $color = [];
        $evcount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach ($evenement as $evenements) {
            $nomEvenement[] = $evenements->getNomEvenement();
            $color[] = $evenements->getColor();
            $evcount[] = count($evenements->getParticipant());
        }


        return $this->render('evenement/stat.html.twig', [    //color
            'nomEvenement' => json_encode($nomEvenement),
            'color' => json_encode($color),
            'evcount' => json_encode($evcount),
        ]);
    }

    #[Route('/pdf', name: 'generator_service3')]
    public function pdfService(): Response
    {
        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->findAll();

        $html = $this->renderView('evenement/PdfEvenement.html.twig', ['evenements' => $evenements]);

        // Utilisation du service PdfGeneratorService
        $pdfGeneratorService = new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
    }



    #[Route('/', name: 'app_evenement_index', methods: ['GET', 'POST'])]
    public function index(EntityManagerInterface $entityManager, EvenementRepository $evenementRepository, Request $request): Response
    {
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();

        /////////
        $back = null;

        if ($request->isMethod("POST")) {
            if ($request->request->get('optionsRadios')) {
                $SortKey = $request->request->get('optionsRadios');
                switch ($SortKey) {
                    case 'nomEvenement':
                        $evenements = $evenementRepository->SortByNomEvenement();
                        break;

                    case 'typeEvenement':
                        $evenements = $evenementRepository->SortByTypeEvenement();
                        break;

                    case 'lieuEvenement':
                        $evenements = $evenementRepository->SortByDateDebut();
                        break;
                }
            } else {
                $type = $request->request->get('optionsearch');
                $value = $request->request->get('Search');
                switch ($type) {
                    case 'nomEvenement':
                        $evenements = $evenementRepository->findBynomEvenement($value);
                        break;

                    case 'typeEvenement':
                        $evenements = $evenementRepository->findBylieuEvenement($value);
                        break;

                    case 'dateDebut':
                        $evenements = $evenementRepository->findBydateDebut($value);
                        break;

                    case 'dateFin':
                        $evenements = $evenementRepository->findBydateFin($value);
                        break;
                }
            }

            if ($evenements) {
                $back = "success";
            } else {
                $back = "failure";
            }
        }
        ////////

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements, 'back' => $back
        ]);
    }


    #[Route('/front', name: 'app_evenement_indexFront', methods: ['GET'])]
    public function indexFront(EvenementRepository $evenementRepository, PaginatorInterface $paginator, Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();

        $evenements = $paginator->paginate(
            $evenements, /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );


        return $this->render('evenement/indexFront.html.twig', [
            'evenements' => $evenements,
        ]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $evenement->getImageEvenement();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('uploads'), $filename);
            $evenement->setImageEvenement($filename);
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $evenement->getImageEvenement();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('uploads'), $filename);
            $evenement->setImageEvenement($filename);
            $entityManager->persist($evenement);
            $entityManager->flush();


            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
