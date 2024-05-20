<?php

namespace App\Controller;

use App\Entity\Crediteur;
use App\Form\CrediteurType;
use App\Repository\CrediteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/crediteur')]
class CrediteurController extends AbstractController
{
    #[Route('/', name: 'app_crediteur_index', methods: ['GET'])]
    public function index(Request $request, CrediteurRepository $crediteurRepository): Response
    {
        $sortField = $request->query->get('sort', 'id'); // Standaard gesorteerd op 'id'
        $sortDirection = $request->query->get('direction', 'asc'); // Standaard oplopende volgorde

        // Valideer sorteer velden en richting
        $validSortFields = ['id', 'voornaam', 'naam', 'tel', 'email', 'straat_nr', 'postcode', 'gemeente', 'land', 'btw_nr', 'rek_nr', 'updated_at'];
        $sortField = in_array($sortField, $validSortFields) ? $sortField : 'id';
        $sortDirection = strtoupper($sortDirection) === 'DESC' ? 'DESC' : 'ASC';

        $crediteuren = $crediteurRepository->findBy([], [$sortField => $sortDirection]);

        return $this->render('crediteur/index.html.twig', [
            'crediteurs' => $crediteuren,
            'sort_direction' => $sortDirection === 'ASC' ? 'desc' : 'asc', // Toggle de sorteer richting
        ]);
    }

    #[Route('/new', name: 'app_crediteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $crediteur = new Crediteur();
        $form = $this->createForm(CrediteurType::class, $crediteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($crediteur);
            $entityManager->flush();

            return $this->redirectToRoute('app_crediteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crediteur/new.html.twig', [
            'crediteur' => $crediteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crediteur_show', methods: ['GET'])]
    public function show(Crediteur $crediteur): Response
    {
        return $this->render('crediteur/show.html.twig', [
            'crediteur' => $crediteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_crediteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Crediteur $crediteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CrediteurType::class, $crediteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_crediteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crediteur/edit.html.twig', [
            'crediteur' => $crediteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crediteur_delete', methods: ['POST'])]
    public function delete(Request $request, Crediteur $crediteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $crediteur->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($crediteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_crediteur_index', [], Response::HTTP_SEE_OTHER);
    }

    //EXPORT CSV
    #[Route('/export/csv', name: 'app_crediteur_export_csv', methods: ['GET'])]
    public function exportToCsv(CrediteurRepository $crediteurRepository): Response
    {
        $crediteuren = $crediteurRepository->findAll();

        $csvData = [];
        // Voeg de kopregel toe
        $csvData[] = ['Id', 'Voornaam', 'Naam', 'Tel', 'Email', 'Straat_nr', 'Postcode', 'Gemeente', 'Land', 'Btw_nr', 'Rek_nr', 'Updated_at'];

        // Voeg de gegevens van elke crediteur toe aan de CSV-data
        foreach ($crediteuren as $crediteur) {
            $csvData[] = [
                $crediteur->getId(),
                $crediteur->getVoornaam(),
                $crediteur->getNaam(),
                $crediteur->getTel(),
                $crediteur->getEmail(),
                $crediteur->getStraatNr(),
                $crediteur->getPostcode(),
                $crediteur->getGemeente(),
                $crediteur->getLand(),
                $crediteur->getBtwNr(),
                $crediteur->getRekNr(),
                $crediteur->getUpdatedAt() ? $crediteur->getUpdatedAt()->format('Y-m-d H:i:s') : '',
            ];
        }

        // Maak een CSV-bestand
        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="crediteuren.csv"');
        $response->setContent($this->arrayToCsv($csvData));

        return $response;
    }

    // Hulpmethode om een array naar CSV-formaat te converteren
    private function arrayToCsv(array $data): string
    {
        $output = fopen('php://temp', 'w');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        return $csv;
    }
}
