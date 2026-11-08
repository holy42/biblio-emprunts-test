<?php
declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\Model\LivreRepository;
use App\Model\EmpruntRepository;
use App\Service\EmpruntService;

final class EmpruntController
{
    private \PDO $pdo;
    private LivreRepository $livres;
    private EmpruntRepository $emprunts;
    private EmpruntService $service;

    public function __construct()
    {
        $this->pdo = Database::connexion();
        $this->livres = new LivreRepository($this->pdo);
        $this->emprunts = new EmpruntRepository($this->pdo);
        $this->service = new EmpruntService($this->livres, $this->emprunts);
    }

    public function liste(): void
    {
        $lignes = $this->emprunts->listerDeAdherent((int) ($_SESSION['id'] ?? 0));
        foreach ($lignes as &$ligne) {
            $ligne['livre'] = $this->livres->trouver((int) $ligne['livre_id']);
        }
        unset($ligne);
        require __DIR__ . '/../../templates/emprunt_liste.php';
    }

    public function creer(): void
    {
        $id = $this->service->enregistrer((int) $_POST['livre_id'], (int) ($_SESSION['id'] ?? 0), $_POST['debut'], $_POST['fin'], (int) ($_POST['quantite'] ?? 1));
        header('Location: index.php?action=emprunts&cree=' . $id);
    }

    public function annuler(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->emprunts->supprimer($id);
        header('Location: index.php?action=emprunts');
    }

    public function supprimerParLien(): void
    {
        $this->emprunts->supprimer((int) ($_GET['id'] ?? 0));
        header('Location: index.php?action=emprunts');
    }

    public function statistiques(): void
    {
        $taux = [];
        foreach ($this->livres->listerPage(1, 100) as $livre) {
            $utilise = $this->emprunts->compterActifs((int) $livre['id']);
            $taux[$livre['nom']] = $this->service->tauxOccupation($utilise, (int) $livre['exemplaires']);
        }
        header('Content-Type: application/json');
        echo json_encode($taux);
    }
}
