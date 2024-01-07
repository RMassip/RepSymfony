<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Entity\Chanson;
use App\Form\ChansonType;
use App\Repository\ChansonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class DiscothequeController extends AbstractController
{
    #[Route('/discotheque', name: 'app_discotheque')]
    public function index(ChansonRepository $chansonRepository): Response
    {
        return $this->render('discotheque/index.html.twig', [
            'chansons' => $chansonRepository->findAll(),
        ]);
    }

    #[Route('/discotheque/new', name: 'app_chanson_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ChansonRepository $chansonRepository): Response
    {
        $chanson = new Chanson();
        $form = $this->createForm(ChansonType::class, $chanson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chansonRepository->save($chanson, true);

            $this->addFlash('notice', 'Chanson ajouté !');
            return $this->redirectToRoute('app_discotheque', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chanson/new.html.twig', [
            'chanson' => $chanson,
            'form' => $form,
        ]);
    }

    #[Route('/discotheque/{id}', name: 'app_chanson_show', methods: ['GET'])]
    public function show(Chanson $chanson, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les IDs des artistes liés à la chanson
        $artistes = $chanson->getArtistes();
        $artisteIds = [];

        foreach ($artistes as $artiste) {
            $artisteIds[] = $artiste->getId();
        }

        // Charger les artistes à partir des IDs
        $artistes = $entityManager->getRepository(Artiste::class)->findBy(['id' => $artisteIds]);

        return $this->render('chanson/show.html.twig', [
            'chanson' => $chanson,
            'artistes' => $artistes,
        ]);
    }




    #[Route('/discotheque/{id}/edit', name: 'app_chanson_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chanson $chanson, ChansonRepository $chansonRepository): Response
    {
        $form = $this->createForm(ChansonType::class, $chanson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chansonRepository->save($chanson, true);

            $this->addFlash('notice', 'Chanson modifié !');
            return $this->redirectToRoute('app_discotheque', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chanson/edit.html.twig', [
            'chanson' => $chanson,
            'form' => $form,
        ]);
    }

    #[Route('/discotheque/{id}', name: 'app_chanson_delete', methods: ['POST'])]
    public function delete(Request $request, Chanson $chanson, ChansonRepository $chansonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chanson->getId(), $request->request->get('_token'))) {
            $chansonRepository->remove($chanson, true);
        }

        return $this->redirectToRoute('app_discotheque', [], Response::HTTP_SEE_OTHER);
    }
}
