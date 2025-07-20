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
    #[ApiProperty(description: "Numéro SIREN unique de l'entreprise")]
    #[Groups(['company:read'])]
    public string $siren;

    #[ApiProperty(description: "Nom de l'entreprise")]
    #[Groups(['company:read'])]
    public string $nom_complet;

    #[ApiProperty(description: "Raison sociale de l'entreprise")]
    #[Groups(['company:read'])]
    public string $nom_raison_sociale;

    #[ApiProperty(description: "Nombre d'établissements liés à l'entreprise")]
    public int $nombre_etablissements;

    #[ApiProperty(description: "Nombre d'établissements ouverts liés à l'entreprise")]
    public int $nombre_etablissements_ouverts;
}