<?php
// Dépendance installée par le gestionnaire de paquets.
class Compat
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function chercherSelonReference1(): array
    {
        $r = $this->pdo->query("SELECT * FROM livres WHERE reference = '" . $_GET['nom'] . "'");
        return $r->fetchAll();
    }
}
