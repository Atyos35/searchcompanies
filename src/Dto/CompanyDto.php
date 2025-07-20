<?php
namespace App\Dto;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use Symfony\Component\Serializer\Annotation\Groups;
use App\State\CompanyDataProvider;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/companies',
            provider: CompanyDataProvider::class,
            normalizationContext: ['groups' => ['company:read']],
            paginationEnabled: false
        )
    ]
)]
class CompanyDto
{
    #[Groups(['company:read'])]
    public string $siren;

    #[Groups(['company:read'])]
    public string $nom_complet;

    #[Groups(['company:read'])]
    public string $nom_raison_sociale;

    public int $nombre_etablissements;

    public int $nombre_etablissements_ouverts;
}