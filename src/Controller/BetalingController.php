<?php

namespace App\Controller;

use App\Entity\Betaling;
use App\Form\BetalingType;
use App\Repository\BetalingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/betaling')]
class BetalingController extends AbstractController
{
    #[Route('/', name: 'app_betaling_index', methods: ['GET'])]
    public function index(BetalingRepository $betalingRepository): Response
    {
        return $this->render('betaling/index.html.twig', [
            'betalings' => $betalingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_betaling_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $betaling = new Betaling();
        $form = $this->createForm(BetalingType::class, $betaling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($betaling);
            $entityManager->flush();

            return $this->redirectToRoute('app_betaling_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('betaling/new.html.twig', [
            'betaling' => $betaling,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_betaling_show', methods: ['GET'])]
    public function show(Betaling $betaling): Response
    {
        return $this->render('betaling/show.html.twig', [
            'betaling' => $betaling,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_betaling_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Betaling $betaling, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BetalingType::class, $betaling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_betaling_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('betaling/edit.html.twig', [
            'betaling' => $betaling,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_betaling_delete', methods: ['POST'])]
    public function delete(Request $request, Betaling $betaling, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$betaling->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($betaling);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_betaling_index', [], Response::HTTP_SEE_OTHER);
    }
}
