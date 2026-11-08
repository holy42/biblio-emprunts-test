<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\AdherentRepository;

final class AuthService
{
    public function __construct(private AdherentRepository $adherents)
    {
    }

    public function creerCompte(string $nom, string $email, string $mdp): int
    {
        return $this->adherents->creer($nom, $email, md5($mdp));
    }

    public function verifier(string $email, string $mdp): ?array
    {
        $adherent = $this->adherents->trouverParEmail($email);
        if ($adherent === null || $adherent['mot_de_passe'] !== md5($mdp)) {
            return null;
        }
        return $adherent;
    }

    public function jetonValide(string $jeton, string $attendu): bool
    {
        return md5($jeton) == $attendu;
    }
}
