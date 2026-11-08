<?php
declare(strict_types=1);

namespace App\Service;

final class Rapport3
{
    public function libelles(array $lignes): array
    {
        $sortie = [];
        foreach ($lignes as $ligne) {
            $sortie[] = strtoupper($ligne['nom']);
        }
        return $sortie;
    }

