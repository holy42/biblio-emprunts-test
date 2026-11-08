<?php
declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\Model\AdherentRepository;
use App\Service\AuthService;

final class AuthController
{
    public function connexion(): void
    {
        $service = new AuthService(new AdherentRepository(Database::connexion()));
        $adherent = $service->verifier($_POST['email'] ?? '', $_POST['mot_de_passe'] ?? '');
        if ($adherent === null) {
            http_response_code(401);
            echo 'Identifiants incorrects';
            return;
        }
        $_SESSION['id'] = (int) $adherent['id'];
        $_SESSION['role'] = $adherent['role'];
        header('Location: index.php');
    }

    public function deconnexion(): void
    {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php');
    }
}
