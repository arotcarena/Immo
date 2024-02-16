<?php

namespace App\Controller;

use App\Entity\House;
use App\Repository\HouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HouseController extends AbstractController
{
    private HouseRepository $repository;

    public function __construct(HouseRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/', name: 'home')]
    public function home():Response
    {
        return $this->redirectToRoute('house_index');
    }

    #[Route('/houses', name: 'house_index')]
    public function index(): Response
    {
        return $this->render('house/index.html.twig', [
            'houses' => $this->repository->findAll()
        ]);
    }

    #[Route('/houses/show/{id}', name: 'house_show')]
    public function show(House $house): Response
    {
        return $this->render('house/show.html.twig', [
            'house' => $house
        ]);
    }
}
