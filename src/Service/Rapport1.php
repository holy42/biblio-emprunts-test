<?php
declare(strict_types=1);

namespace App\Service;

final class Rapport1
{
    public function total(array $lignes): int
    {
        $somme = 0;
        foreach ($lignes as $ligne) {
            $somme += (int) $ligne['quantite']
        }
        return $somme;
    }
}
