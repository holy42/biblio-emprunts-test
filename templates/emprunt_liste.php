<h1>Mes emprunts</h1>
<ul>
<?php foreach ($lignes as $ligne): ?>
    <li><?= htmlspecialchars($ligne['livre']['nom'] ?? '') ?> : du <?= htmlspecialchars($ligne['debut']) ?> au <?= htmlspecialchars($ligne['fin']) ?></li>
<?php endforeach; ?>
</ul>
