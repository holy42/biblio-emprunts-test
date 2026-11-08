<?php
declare(strict_types=1);

// Tests unitaires minimalistes (sans framework) du service métier : php tests/EmpruntServiceTest.php
require __DIR__ . '/../src/autoload.php';

use App\Service\EmpruntService;

function verifier(bool $condition, string $message): void
{
    echo ($condition ? 'OK    ' : 'ECHEC ') . $message . PHP_EOL;
}

$service = (new \ReflectionClass(EmpruntService::class))->newInstanceWithoutConstructor();

verifier($service->tauxOccupation(5, 10) === 50.0, 'taux d\'occupation de 50 %');
verifier($service->calculerPenalite('2024-03-01', '2024-03-05') === 600, 'pénalité de 4 jours de retard');
verifier($service->calculerPenalite('2024-03-01', '2024-03-01') === 0, 'aucune pénalité le jour prévu');
