<?php

namespace App\Controller;

use App\Entity\Vetements;
use App\Repository\VetementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class VetementsController extends AbstractController
{

    /**
     * @var VetementsRepository
     */
    private $repository;

    public function __construct(VetementsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Response
     */
    #[Route('/vestiaire', name: 'vetements')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        // Créer une entité qui va représenter notre recherche
        // Créer un formulaire
        // Gérer le traitement dans le controller
        
        $vetements = $paginator->paginate(
            $this->repository->findAllQuery(),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('vetements/index.html.twig', [
            'current_menu' => 'vestiaires',
            'vetements' => $vetements
        ]);
    }

    /**
     * @return Response
     */
    #[Route('/vestiaire/{slug}-{id}', name: 'vetements.show', requirements:['slug'=> '[a-z0-9\-]*'])]
    public function show($slug, $id): Response
    {
        $vetement = $this->repository->find($id);
        return $this->render('vetements/show.html.twig', [
            'vetement' => $vetement,
            'current_menu' => 'vestiaires'
        ]);
    }
}
