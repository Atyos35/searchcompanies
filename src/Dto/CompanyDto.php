<?php
namespace App\Dto;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use Symfony\Component\Serializer\Annotation\Groups;
use App\State\CompanyDataProvider;
use App\State\CountClosedEstablishmentsProvider;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/companies',
            provider: CompanyDataProvider::class,
            normalizationContext: ['groups' => ['company:read']],
            name: 'companies'
        ),
        new Get(
            uriTemplate: '/companies/closed-count',
            provider: CountClosedEstablishmentsProvider::class,
            normalizationContext: ['groups' => ['company:closed_count']],
            name: 'company_closed_establishments_count'
        )
    ]
)]
class CompanyDto
{
    #[ApiProperty(description: "Numéro SIREN unique de l'entreprise")]
    #[Groups(['company:read', 'company:closed_count'])]
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

    #[ApiProperty(description: "Nombre d'établissements fermés liés à l'entreprise")]
    #[Groups(['company:closed_count'])]
    public int $nombre_etablissements_fermes;
}