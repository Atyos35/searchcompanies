<?php

namespace App\State;

use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\Operation;
use App\Dto\CompanyDto;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CountClosedEstablishmentsProvider implements ProviderInterface
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $query = $context['filters']['q'] ?? '';

        $response = $this->client->request('GET', 'https://recherche-entreprises.api.gouv.fr/search?q=' . urlencode('La Poste'));
        $data = $response->toArray();

        $dtos = [];
        foreach ($data['results'] ?? [] as $result) {
            $dto = new CompanyDto();
            $dto->siren = $result['siren'] ?? '';
            $dto->nombre_etablissements = $result['nombre_etablissements'] ?? 0;
            $dto->nombre_etablissements_ouverts = $result['nombre_etablissements_ouverts'] ?? 0;
            $dto->nombre_etablissements_fermes = max(
                0,
                $dto->nombre_etablissements - $dto->nombre_etablissements_ouverts
            );
            $dtos[] = $dto;
        }

        return $dtos;
    }
}