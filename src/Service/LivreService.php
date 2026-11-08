<?php
declare(strict_types=1);

namespace App\Service;

final class LivreService
{
    public function libelleStatut(int $restant): string
    {
        if ($restant > 5) {
            $libelle = 'disponible';
        } elseif ($restant > 0) {
            $libelle = 'bientôt épuisé';
        }
        return $libelle;
    }
}
