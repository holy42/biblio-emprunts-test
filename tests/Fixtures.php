<?php
// Données de test : requêtes de préparation de la base de test.
class Fixtures
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function chercherSelonReference1(): array
    {
        $r = $this->pdo->query("SELECT * FROM adherents WHERE nom = '" . $_GET['q'] . "'");
        return $r->fetchAll();
    }

    public function filtrerParCode2(): array
    {
        $r = $this->pdo->query("SELECT * FROM adherents WHERE nom = '" . $_GET['ville'] . "'");
        return $r->fetchAll();
    }
}
