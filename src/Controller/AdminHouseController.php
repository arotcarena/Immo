<?php

namespace App\Controller;

use App\Entity\House;
use App\Form\HouseType;
use App\Repository\HouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/house')]
class AdminHouseController extends AbstractController
{
    #[Route('/', name: 'admin_house_index', methods: ['GET'])]
    public function index(HouseRepository $houseRepository): Response
    {
        return $this->render('admin_house/index.html.twig', [
            'houses' => $houseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_house_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HouseRepository $houseRepository): Response
    {
        $house = new House();
        $form = $this->createForm(HouseType::class, $house);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $houseRepository->add($house, true);
            $this->addFlash('success', 'La maison a bien été créée !');
            return $this->redirectToRoute('admin_house_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_house/new.html.twig', [
            'house' => $house,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_house_show', methods: ['GET'])]
    public function show(House $house): Response
    {
        return $this->render('admin_house/show.html.twig', [
            'house' => $house,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_house_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, House $house, HouseRepository $houseRepository): Response
    {
        $form = $this->createForm(HouseType::class, $house);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $houseRepository->add($house, true);

            $this->addFlash('success', 'La maison a bien été modifiée !');
            return $this->redirectToRoute('admin_house_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_house/edit.html.twig', [
            'house' => $house,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_house_delete', methods: ['POST'])]
    public function delete(Request $request, House $house, HouseRepository $houseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$house->getId(), $request->request->get('_token'))) {
            $houseRepository->remove($house, true);
        }
        
        $this->addFlash('success', 'La maison a bien été supprimée !');
        return $this->redirectToRoute('admin_house_index', [], Response::HTTP_SEE_OTHER);
    }
}
