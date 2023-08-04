<?php
namespace App\Controller;

use App\Repository\VetementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    
    /**
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function index(VetementsRepository $repository): Response
    {
        $vetements = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'vetements' => $vetements
        ]);
    }

}