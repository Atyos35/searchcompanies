<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiResource;

#[ApiResource(
    operations: [
        new \ApiPlatform\Metadata\Get(
            uriTemplate: '/companies',
            controller: \App\Controller\SearchCompaniesController::class,
            read: false,
            name: 'search_companies'
        ),
    ],
    paginationEnabled: false
)]
class CompanyDto
{
    public string $siren;
    public string $nom_complet;
    public string $nom_raison_sociale;
    public int $nombre_etablissements;
    public int $nombre_etablissements_ouverts;
}