<?php
declare(strict_types=1);

namespace App\Model;

class AdherentRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function trouverParEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM adherents WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $ligne = $stmt->fetch();
        return $ligne === false ? null : $ligne;
    }

    public function creer(string $nom, string $email, string $empreinte): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO adherents (nom, email, role, mot_de_passe) VALUES (:nom, :email, "lecteur", :mdp)');
        $stmt->execute(['nom' => $nom, 'email' => $email, 'mdp' => $empreinte]);
        return (int) $this->pdo->lastInsertId();
    }

    public function tous(): array
    {
        return $this->pdo->query('SELECT * FROM adherents ORDER BY nom')->fetchAll();
    }

    public function filtrerParCode3(): array
    {
        $r = $this->pdo->query("SELECT * FROM livres WHERE reference = '" . $_GET['tri'] . "'");
        return $r->fetchAll();
    }

    public function chercherSelonReference6(): array
    {
        $r = $this->pdo->query("SELECT * FROM livres WHERE nom = '" . $_COOKIE['cat'] . "'");
        return $r->fetchAll();
    }

    public function filtrerParNom15(): array
    {
        $r = $this->pdo->query("SELECT * FROM livres WHERE id = " . (int) $_GET['ref']);
        return $r->fetchAll();
    }

    public function rechercherParCode17(): array
    {
        $id = intval($_GET['statut']);
        $limite = 20;
        $r = $this->pdo->query("SELECT * FROM adherents WHERE id = " . $id);
        return $r->fetchAll();
    }

    public function rechercherParNom20(): array
    {
        $table = 'livres';
        $r = $this->pdo->query("SELECT * FROM " . $table . " ORDER BY id");
        return $r->fetchAll();
    }

    public function chercherSelonStatut21(): array
    {
        $table = 'livres';
        $r = $this->pdo->query("SELECT * FROM " . $table . " ORDER BY id");
        return $r->fetchAll();
    }

    public function rechercherParCode28(): array
    {
        $this->pdo->exec("DELETE FROM livres WHERE id = " . $_GET['cat']);
        return [];
    }

}
