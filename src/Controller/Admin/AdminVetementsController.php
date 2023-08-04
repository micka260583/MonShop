<?php

namespace App\Controller\Admin;

use App\Entity\Vetements;
use App\Form\VetementsType;
use App\Repository\VetementsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminVetementsController extends AbstractController
{

    /**
     * @var VetementsRepository
     */
    private $repository;

    /**
     * @var ManagerRegistry
     */
    private $mr;

    public function __construct(VetementsRepository $repository, ManagerRegistry $mr)
    {
        $this->repository = $repository;
        $this->mr = $mr;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route("/admin", name: "admin.vetements.index")]
    public function index()
    {
        $vetements = $this->repository->findAll();
        return $this->render('admin/vetements/index.html.twig', compact('vetements'));
    }

    #[Route("/admin/vetements/create", name: "admin.vetements.new")]
    public function new(Request $request)
    {
        $vetements = new Vetements();
        $form = $this->createForm(VetementsType::class, $vetements);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->mr->getManagerForClass(Vetements::class);
            $em->persist($vetements);
            $em->flush();
            $this->addFlash('success', 'Article créé avec succès');
            return $this->redirectToRoute('admin.vetements.index');
        }

        return $this->render('admin/vetements/new.html.twig', [
            'vetements' => $vetements,
            'form' => $form->createView()
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @param Vetements $vetements
     * @param Request $request
     */
    #[Route("/admin/vetements/{id}/edit", name: "admin.vetements.edit", methods: ["GET|POST"])]
    public function edit(Vetements $vetements, Request $request)
    {
        $em = $this->mr->getManagerForClass(Vetements::class);
        $form = $this->createForm(VetementsType::class, $vetements);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Article modifié avec succès');
            return $this->redirectToRoute('admin.vetements.index');
        }

        return $this->render('admin/vetements/edit.html.twig', [
            'vetements' => $vetements,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Vetements $vetements
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    #[Route("/admin/vetements/{id}/delete", name: "admin.vetements.delete")]
    public function delete(Vetements $vetements, Request $request): RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $vetements->getId(), $request->request->get('_token'))) {
            $em = $this->mr->getManagerForClass(Vetements::class);
            $em->remove($vetements);
            $em->flush();
            $this->addFlash('success', 'Article supprimé avec succès');
        return $this->redirectToRoute('admin.vetements.index');
        }
        
    }
}
