<?php
declare(strict_types=1);

use App\Controller\LivreController;
use App\Controller\EmpruntController;
use App\Controller\AdminController;
use App\Controller\AuthController;
use App\Controller\FichierController;

require __DIR__ . '/../src/autoload.php';

ini_set('display_errors', '1');
session_start();

$action = $_GET['action'] ?? 'accueil';

switch ($action) {
    case 'livres':
        (new LivreController())->liste();
        break;
    case 'livre':
        (new LivreController())->afficher();
        break;
    case 'emprunts':
        (new EmpruntController())->liste();
        break;
    case 'creer':
        (new EmpruntController())->creer();
        break;
    case 'annuler':
        (new EmpruntController())->annuler();
        break;
    case 'supprimer':
        (new EmpruntController())->supprimerParLien();
        break;
    case 'statistiques':
        (new EmpruntController())->statistiques();
        break;
    case 'connexion':
        (new AuthController())->connexion();
        break;
    case 'deconnexion':
        (new AuthController())->deconnexion();
        break;
    case 'export_tout':
        (new AdminController())->exporterTout();
        break;
    case 'telecharger':
        (new FichierController())->telecharger();
        break;
    case 'televerser':
        (new FichierController())->televerser();
        break;
    default:
        echo "Gestion d'une bibliothèque municipale";
}
