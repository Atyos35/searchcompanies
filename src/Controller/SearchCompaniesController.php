<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchCompaniesController extends AbstractController
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/search/companies', name: 'search_companies', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $query = $request->query->get('q');
        if (!$query) {
            return $this->json(['error' => 'Missing query parameter.'], 400);
        }

        $response = $this->client->request('GET', 'https://recherche-entreprises.api.gouv.fr/search?q=' . urlencode($query));
        $data = $response->toArray();

        $filteredResults = array_map(function ($result) {
            return [
                'siren' => $result['siren'] ?? null,
                'nom_complet' => $result['nom_complet'] ?? null,
                'nom_raison_sociale' => $result['nom_raison_sociale'] ?? null,
                'sigle' => $result['sigle'] ?? null,
                'nombre_etablissements' => $result['nombre_etablissements'] ?? null,
                'nombre_etablissements_ouverts' => $result['nombre_etablissements_ouverts'] ?? null,
            ];
        }, $data['results'] ?? []);

        return $this->json(['results' => $filteredResults]);
    }
}