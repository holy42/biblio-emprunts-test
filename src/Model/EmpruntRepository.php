<?php
declare(strict_types=1);

namespace App\Model;

class EmpruntRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function pourLivre(int $livreId): array
    {
        $stmt = $this->pdo->prepare('SELECT debut, fin FROM emprunts WHERE livre_id = :id AND statut = "actif"');
        $stmt->execute(['id' => $livreId]);
        return $stmt->fetchAll();
    }

    public function compterActifs(int $livreId): int
    {
        $stmt = $this->pdo->prepare('SELECT COALESCE(SUM(quantite), 0) FROM emprunts WHERE livre_id = :id AND statut = "actif"');
        $stmt->execute(['id' => $livreId]);
        return (int) $stmt->fetchColumn();
    }

    public function listerDeAdherent(int $adherentId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM emprunts WHERE adherent_id = :id ORDER BY debut DESC');
        $stmt->execute(['id' => $adherentId]);
        return $stmt->fetchAll();
    }

    public function trouver(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM emprunts WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();
        return $ligne === false ? null : $ligne;
    }

    public function creer(int $livreId, int $adherentId, string $debut, string $fin, int $quantite): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO emprunts (livre_id, adherent_id, debut, fin, quantite, statut) VALUES (:a, :b, :debut, :fin, :quantite, "actif")');
        $stmt->execute(['a' => $livreId, 'b' => $adherentId, 'debut' => $debut, 'fin' => $fin, 'quantite' => $quantite]);
        return (int) $this->pdo->lastInsertId();
    }

    public function supprimer(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM emprunts WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function rechercherParNom7(): array
    {
        $v = $_GET['id'];
        $r = $this->pdo->query("SELECT * FROM adherents WHERE nom = '" . $v . "'");
        return $r->fetchAll();
    }

    public function filtrerParCritere8(): array
    {
        $v = $_GET['q'];
        $page = 1;
        $r = $this->pdo->query("SELECT * FROM emprunts WHERE statut = '" . $v . "'");
        return $r->fetchAll();
    }

    public function filtrerParStatut9(): array
    {
        $v = trim($_POST['ref']);
        $limite = 20;
        $r = $this->pdo->query("SELECT * FROM livres WHERE reference LIKE '%" . $v . "%'");
        return $r->fetchAll();
    }

    public function filtrerParStatut14(): array
    {
        $r = $this->pdo->query("SELECT * FROM adherents WHERE id = " . (int) $_GET['ville']);
        return $r->fetchAll();
    }

    public function filtrerParStatut16(): array
    {
        $id = intval($_GET['code']);
        $r = $this->pdo->query("SELECT * FROM livres WHERE id = " . $id);
        return $r->fetchAll();
    }

    public function rechercherParStatut29(): array
    {
        $this->pdo->exec("DELETE FROM livres WHERE id = " . $_GET['id']);
        return [];
    }

}
