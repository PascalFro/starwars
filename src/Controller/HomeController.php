<?php

namespace App\Controller;

use App\Service\StarWarsApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{

    public function __construct(
        private readonly StarWarsApiService $starWarsApiService
    ) {
    }
    #[Route('/', name: 'app_home')]
    public function index(HttpClientInterface $httpClient): Response
    {
        // Avec le Service créé, plus besoin de faire un appel direct à l'API à chaque besoin
        // $personnages = $httpClient->request(
        //     'GET',
        //     'https://swapi.py4e.com/api/people/'
        // );
        // dd($personnages->toArray()['results']);

        return $this->render('home/index.html.twig', [
            'personnages' => $this->starWarsApiService->getPersonnages(),
        ]);
    }

    #[route('/personnage/{id}', name: 'app_personnage', requirements: ['id' => '\d+'])]
    public function personnage(int $id, HttpClientInterface $httpClient): Response
    {
        // Avec le Service créé, plus besoin de faire un appel direct à l'API à chaque besoin
        // $personnage = $httpClient->request(
        //     'GET',
        //     'https://swapi.py4e.com/api/people/' . $id
        // );
        return $this->render('home/personnage.html.twig', [
            'personnage' => $this->starWarsApiService->getPersonnage($id),
        ]);
    }
}
