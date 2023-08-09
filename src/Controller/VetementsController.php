<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Vetements;
use App\Form\SearchForm;
use App\Repository\VetementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

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
    public function index(PaginatorInterface $paginator, Request $request, EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Vetements::class)->createQueryBuilder('v')
            ->select('DISTINCT v.categorie')
            ->getQuery()
            ->getResult();
        $categoryValues = array_column($categories, 'categorie');

        $sex = $entityManager->getRepository(Vetements::class)->createQueryBuilder('v')
        ->select('DISTINCT v.sex')
        ->getQuery()
        ->getResult();
        $sexValues = array_column($sex, 'sex');

        $taille = $entityManager->getRepository(Vetements::class)->createQueryBuilder('v')
        ->select('DISTINCT v.taille')
        ->getQuery()
        ->getResult();
        $tailleValues = array_column($taille, 'taille');

        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data, [
            'categories' => $categoryValues,
            'sex' => $sexValues,
            'taille' => $tailleValues,
        ]);
        $form->handleRequest($request);

        $vetements = $paginator->paginate(
            $this->repository->findAllQuery($data),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('vetements/index.html.twig', [
            'current_menu' => 'vestiaires',
            'vetements' => $vetements,
            'form' => $form->createView()
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
