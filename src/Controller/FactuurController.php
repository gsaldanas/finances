<?php

namespace App\Controller;

use App\Entity\Factuur;
use App\Form\FactuurType;
use App\Repository\FactuurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/factuur')]
class FactuurController extends AbstractController
{
    #[Route('/', name: 'app_factuur_index', methods: ['GET'])]
    public function index(FactuurRepository $factuurRepository): Response
    {
        return $this->render('factuur/index.html.twig', [
            'factuurs' => $factuurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_factuur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $factuur = new Factuur();
        $form = $this->createForm(FactuurType::class, $factuur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($factuur);
            $entityManager->flush();

            return $this->redirectToRoute('app_factuur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('factuur/new.html.twig', [
            'factuur' => $factuur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_factuur_show', methods: ['GET'])]
    public function show(Factuur $factuur): Response
    {
        return $this->render('factuur/show.html.twig', [
            'factuur' => $factuur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_factuur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Factuur $factuur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FactuurType::class, $factuur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_factuur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('factuur/edit.html.twig', [
            'factuur' => $factuur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_factuur_delete', methods: ['POST'])]
    public function delete(Request $request, Factuur $factuur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $factuur->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($factuur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_factuur_index', [], Response::HTTP_SEE_OTHER);
    }
}
