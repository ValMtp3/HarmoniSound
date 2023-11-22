<?php

namespace App\Controller;

use App\Entity\Music;
use App\Form\MusicType;
use App\Repository\MusicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/music')]
class MusicController extends AbstractController
{
    #[Route('/', name: 'app_music_index', methods: ['GET'])]
    public function index(MusicRepository $musicRepository): Response
    {
        return $this->render('music/index.html.twig', [
            'music' => $musicRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_music_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $music = new Music();
        $form = $this->createForm(MusicType::class, $music);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($music);
            $entityManager->flush();

            return $this->redirectToRoute('app_music_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('music/new.html.twig', [
            'music' => $music,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_music_show', methods: ['GET'])]
    public function show(Music $music): Response
    {
        return $this->render('music/show.html.twig', [
            'music' => $music,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_music_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Music $music, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MusicType::class, $music);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_music_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('music/edit.html.twig', [
            'music' => $music,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_music_delete', methods: ['POST'])]
    public function delete(Request $request, Music $music, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$music->getId(), $request->request->get('_token'))) {
            $entityManager->remove($music);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_music_index', [], Response::HTTP_SEE_OTHER);
    }
}