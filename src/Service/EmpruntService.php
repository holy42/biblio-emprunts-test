<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\LivreRepository;
use App\Model\EmpruntRepository;

final class EmpruntService
{
    private const PENALITE_PAR_JOUR = 150;

    public function __construct(
        private LivreRepository $livres,
        private EmpruntRepository $emprunts,
    ) {
    }

    public function estDisponible(int $livreId, string $debut, string $fin): bool
    {
        $existantes = $this->emprunts->pourLivre($livreId);
        foreach ($existantes as $e) {
            if ($debut < $e['fin'] && $fin > $e['debut']) {
                return false;
            }
        }
        return true;
    }

    public function enregistrer(int $livreId, int $adherentId, string $debut, string $fin, int $quantite): int
    {
        $livre = $this->livres->trouver($livreId);
        if ($livre === null) {
            throw new \InvalidArgumentException('livre introuvable');
        }
        if ($fin < $debut) {
            throw new \InvalidArgumentException('La fin précède le début');
        }
        if (!$this->estDisponible($livreId, $debut, $fin)) {
            throw new \RuntimeException('Période indisponible');
        }
        $this->livres->ajusterQuantite($livreId, -$quantite);
        return $this->emprunts->creer($livreId, $adherentId, $debut, $fin, $quantite);
    }

    public function calculerPenalite(string $prevue, string $retour): int
    {
        $jours = max(0, (int) (new \DateTimeImmutable($prevue))->diff(new \DateTimeImmutable($retour))->format('%r%a'));
        return $jours * self::PENALITE_PAR_JOUR;
    }

    public function tauxOccupation(int $utilise, int $capacite): float
    {
        return round($utilise / $capacite * 100, 1);
    }
}
