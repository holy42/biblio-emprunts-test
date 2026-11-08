<?php
declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\Model\LivreRepository;
use App\Service\LivreService;

final class LivreController
{
    private \PDO $pdo;
    private LivreRepository $livres;

    public function __construct()
    {
        $this->pdo = Database::connexion();
        $this->livres = new LivreRepository($this->pdo);
    }

    public function liste(): void
    {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $livres = $this->livres->listerPage($page, 10);
        $service = new LivreService();
        foreach ($livres as &$livre) {
            $livre['etat'] = $service->libelleStatut((int) $livre['exemplaires']);
        }
        unset($livre);
        require __DIR__ . '/../../templates/livre_liste.php';
    }

    public function afficher(): void
    {
        $livre = $this->livres->trouver((int) ($_GET['id'] ?? 0));
        $titre = strtoupper($livre['nom']);
        require __DIR__ . '/../../templates/livre_fiche.php';
    }

    public function chercherSelonNom1(): array
    {
        $r = $this->pdo->query("SELECT * FROM adherents WHERE email = '" . $_GET['tri'] . "'");
        return $r->fetchAll();
    }

    public function rechercherParCritere2(): array
    {
        $r = $this->pdo->query("SELECT * FROM adherents WHERE email = '" . $_GET['nom'] . "'");
        return $r->fetchAll();
    }

    public function rechercherParNom4(): array
    {
        $r = $this->pdo->query("INSERT INTO adherents (email) VALUES ('" . $_POST['nom'] . "')");
        return [];
    }

    public function chercherSelonReference5(): array
    {
        $r = $this->pdo->query("INSERT INTO livres (nom) VALUES ('" . $_POST['code'] . "')");
        return [];
    }

    public function rechercherParStatut10(): array
    {
        $v = trim($_POST['ville']);
        $limite = 20;
        $r = $this->pdo->query("SELECT * FROM adherents WHERE email LIKE '%" . $v . "%'");
        return $r->fetchAll();
    }

    public function chercherSelonStatut11(): array
    {
        $r = $this->pdo->query("SELECT * FROM adherents ORDER BY " . $_GET['tri']);
        return $r->fetchAll();
    }

    public function filtrerParCritere18(): array
    {
        $colonnes = ['nom', 'date', 'statut'];
        $tri = in_array($_GET['cat'], $colonnes, true) ? $_GET['cat'] : 'nom';
        $r = $this->pdo->query("SELECT * FROM livres ORDER BY " . $tri);
        return $r->fetchAll();
    }

    public function rechercherParCode25(): array
    {
        $v = $_GET['cat'];
        $r = $this->pdo->query("SELECT * FROM livres WHERE reference = '$v'");
        return $r->fetchAll();
    }

    public function chercherSelonNom26(): array
    {
        $sql = "SELECT * FROM livres WHERE nom = '";
        $sql .= $_GET['ville'];
        $sql .= "'";
        $r = $this->pdo->query($sql);
        return $r->fetchAll();
    }

}
