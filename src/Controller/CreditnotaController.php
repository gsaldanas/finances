<?php

namespace App\Controller;

use App\Entity\Creditnota;
use App\Form\CreditnotaType;
use App\Repository\CreditnotaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/creditnota')]
class CreditnotaController extends AbstractController
{
    #[Route('/', name: 'app_creditnota_index', methods: ['GET'])]
    public function index(CreditnotaRepository $creditnotaRepository): Response
    {
        return $this->render('creditnota/index.html.twig', [
            'creditnotas' => $creditnotaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_creditnota_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $creditnotum = new Creditnota();
        $form = $this->createForm(CreditnotaType::class, $creditnotum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($creditnotum);
            $entityManager->flush();

            return $this->redirectToRoute('app_creditnota_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('creditnota/new.html.twig', [
            'creditnotum' => $creditnotum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_creditnota_show', methods: ['GET'])]
    public function show(Creditnota $creditnotum): Response
    {
        return $this->render('creditnota/show.html.twig', [
            'creditnotum' => $creditnotum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_creditnota_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Creditnota $creditnotum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CreditnotaType::class, $creditnotum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_creditnota_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('creditnota/edit.html.twig', [
            'creditnotum' => $creditnotum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_creditnota_delete', methods: ['POST'])]
    public function delete(Request $request, Creditnota $creditnotum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$creditnotum->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($creditnotum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_creditnota_index', [], Response::HTTP_SEE_OTHER);
    }
}
