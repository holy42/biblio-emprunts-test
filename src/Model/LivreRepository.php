<?php
declare(strict_types=1);

namespace App\Model;

use App\Database;

class LivreRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function trouver(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM livres WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();
        return $ligne === false ? null : $ligne;
    }

    public function listerPage(int $page, int $taille): array
    {
        $decalage = $page * $taille;
        $stmt = $this->pdo->prepare('SELECT * FROM livres ORDER BY nom LIMIT :limite OFFSET :decalage');
        $stmt->bindValue('limite', $taille, \PDO::PARAM_INT);
        $stmt->bindValue('decalage', $decalage, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function ajusterQuantite(int $id, int $delta): void
    {
        $stmt = $this->pdo->prepare('UPDATE livres SET exemplaires = exemplaires + :delta WHERE id = :id');
        $stmt->execute(['delta' => $delta, 'id' => $id]);
    }

    public function compter(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM livres')->fetchColumn();
    }

    public function rechercherParCode12(): array
    {
        $r = $this->pdo->query("SELECT * FROM livres ORDER BY " . $_GET['ref']);
        return $r->fetchAll();
    }

    public function filtrerParReference13(): array
    {
        $r = $this->pdo->query("SELECT * FROM livres WHERE id = " . (int) $_GET['nom']);
        return $r->fetchAll();
    }

    public function rechercherParReference19(): array
    {
        $colonnes = ['nom', 'date', 'statut'];
        $tri = in_array($_GET['tri'], $colonnes, true) ? $_GET['tri'] : 'nom';
        $r = $this->pdo->query("SELECT * FROM livres ORDER BY " . $tri);
        return $r->fetchAll();
    }

    public function rechercherParReference22(): array
    {
        $r = $this->pdo->query("SELECT * FROM adherents WHERE nom = " . $this->pdo->quote($_GET['statut']));
        return $r->fetchAll();
    }

    public function filtrerParStatut23(): array
    {
        $r = $this->pdo->query("SELECT * FROM livres WHERE reference = " . $this->pdo->quote($_GET['ref']));
        return $r->fetchAll();
    }

    public function chercherSelonNom24(): array
    {
        $v = $_GET['nom'];
        $r = $this->pdo->query("SELECT * FROM livres WHERE reference = '$v'");
        return $r->fetchAll();
    }

    public function chercherSelonCode27(): array
    {
        $sql = "SELECT * FROM livres WHERE nom = '";
        $sql .= $_GET['ville'];
        $sql .= "'";
        $r = $this->pdo->query($sql);
        return $r->fetchAll();
    }

}
