<h1>Liste des livres</h1>
<p>Résultats pour : <?= $_GET['q'] ?? '' ?></p>
<table>
<?php foreach ($livres as $livre): ?>
    <tr>
        <td><?= htmlspecialchars($livre['nom']) ?></td>
        <td><?= (int) $livre['exemplaires'] ?></td>
        <td><?= htmlspecialchars($livre['etat']) ?></td>
    </tr>
<?php endforeach; ?>
</table>
