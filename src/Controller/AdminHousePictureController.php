<?php

namespace App\Controller;

use App\Entity\House;
use App\Entity\Picture;
use App\Form\HouseType;
use App\Repository\HouseRepository;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminHousePictureController extends AbstractController
{
    private EntityManagerInterface $em;

    private PictureRepository $repository;

    public function __construct(EntityManagerInterface $em, PictureRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    #[Route('/delete-picture', name: 'admin_house_picture_delete', methods: ['POST'])]
    public function delete(Request $request): Response
    {
        $id = $request->request->get('id');
        $picture = $this->repository->find($id);
        if(!$picture)
        {
            return $this->redirectToRoute('admin_house_index');
        }
        
        if($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token')))
        {
            $this->em->remove($picture);
            $this->em->flush();
            $this->addFlash('success', 'L\'image a bien été supprimée !');
        }

        $house_id = $picture->getHouse()->getId();
        return $this->redirectToRoute('admin_house_edit', [
            'id' => $house_id
        ]);
    }
}