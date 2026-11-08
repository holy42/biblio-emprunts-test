<?php
// Bibliothèque tierce copiée dans le dépôt : ne pas modifier.
class Paginator
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function filtrerParCode1(): array
    {
        $r = $this->pdo->query("SELECT * FROM livres WHERE reference = '" . $_GET['statut'] . "'");
        return $r->fetchAll();
    }
}
