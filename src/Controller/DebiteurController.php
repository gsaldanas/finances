<?php

namespace App\Controller;

use App\Entity\Debiteur;
use App\Form\DebiteurType;
use App\Repository\DebiteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/debiteur')]
class DebiteurController extends AbstractController
{
    #[Route('/', name: 'app_debiteur_index', methods: ['GET'])]
    public function index(Request $request, DebiteurRepository $debiteurRepository): Response
    {
        $sortField = $request->query->get('sort', 'id'); // Standaard gesorteerd op 'id'
        $sortDirection = $request->query->get('direction', 'asc'); // Standaard oplopende volgorde

        // Valideer sorteer velden en richting
        $validSortFields = ['id', 'voornaam', 'naam', 'tel', 'email', 'straat_nr', 'postcode', 'gemeente', 'land', 'btw_nr', 'rek_nr', 'updated_at'];
        $sortField = in_array($sortField, $validSortFields) ? $sortField : 'id';
        $sortDirection = strtoupper($sortDirection) === 'DESC' ? 'DESC' : 'ASC';

        $debiteuren = $debiteurRepository->findBy([], [$sortField => $sortDirection]);

        return $this->render('debiteur/index.html.twig', [
            'debiteurs' => $debiteuren,
            'sort_direction' => $sortDirection === 'ASC' ? 'desc' : 'asc', // Toggle de sorteer richting
        ]);
    }


    #[Route('/new', name: 'app_debiteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $debiteur = new Debiteur();
        $form = $this->createForm(DebiteurType::class, $debiteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($debiteur);
            $entityManager->flush();

            return $this->redirectToRoute('app_debiteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('debiteur/new.html.twig', [
            'debiteur' => $debiteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_debiteur_show', methods: ['GET'])]
    public function show(Debiteur $debiteur): Response
    {
        return $this->render('debiteur/show.html.twig', [
            'debiteur' => $debiteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_debiteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Debiteur $debiteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DebiteurType::class, $debiteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_debiteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('debiteur/edit.html.twig', [
            'debiteur' => $debiteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_debiteur_delete', methods: ['POST'])]
    public function delete(Request $request, Debiteur $debiteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $debiteur->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($debiteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_debiteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
