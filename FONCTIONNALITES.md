# Fonctionnalités à ajouter : Gestion d'une bibliothèque municipale

Chaque fonctionnalité relève de la catégorie « nouvelle fonctionnalité ». Difficulté : S (petite), M (moyenne), L (grande).

## F01 : Export CSV des emprunts (S)

Permettre à un adhérent d'exporter la liste de ses emprunts au format CSV depuis la page de liste.

Critères d'acceptation :
- Le bouton Exporter télécharge un fichier .csv encodé en UTF-8
- Seuls les enregistrements de l'utilisateur connecté sont exportés
- Les cellules commençant par =, +, - ou @ sont neutralisées (injection de formules)

Fichiers concernés : src/Controller/EmpruntController.php, src/Util/Csv.php, templates/emprunt_liste.php

## F02 : Recherche multicritère des livres (M)

Ajouter à la liste une recherche par nom, référence et disponibilité, en conservant la pagination.

Critères d'acceptation :
- Requêtes préparées exclusivement
- Les critères se combinent (ET)
- La pagination conserve les filtres

Fichiers concernés : src/Model/LivreRepository.php, src/Controller/LivreController.php, templates/livre_liste.php

## F03 : Notification par e-mail à la création (M)

Envoyer un e-mail de confirmation à l'utilisateur lorsqu'un enregistrement est créé.

Critères d'acceptation :
- Un e-mail n'est envoyé qu'après une création réussie
- Un échec d'envoi n'annule pas la création mais est journalisé
- Le contenu ne contient aucune donnée sensible

Fichiers concernés : src/Service/EmpruntService.php, src/Util/Courrier.php (nouveau)

## F04 : Journal d'audit (L)

Enregistrer qui a créé, modifié ou supprimé quoi et quand, et le consulter (administrateur).

Critères d'acceptation :
- Table journal_audit créée par migration
- Chaque écriture ajoute une ligne (utilisateur, action, élément, date)
- Page de consultation réservée à l'administrateur

Fichiers concernés : database/schema.sql, src/Service/*.php, src/Controller/AdminController.php

## F05 : API JSON en lecture seule pour les livres (S)

Exposer une action renvoyant la liste paginée en JSON.

Critères d'acceptation :
- Réponse JSON valide avec Content-Type application/json
- Pagination via page et taille (taille maximale 50)
- Aucun champ sensible dans la réponse

Fichiers concernés : src/Controller/LivreController.php, public/index.php

## F06 : Rôles et permissions (L)

Distinguer lecteur, gestionnaire et administrateur, avec vérification côté serveur.

Critères d'acceptation :
- Le rôle est contrôlé à chaque action sensible
- Un lecteur ne peut ni créer ni supprimer
- Les accès refusés renvoient 403 et sont journalisés

Fichiers concernés : src/Service/AuthService.php, src/Controller/*.php

## F07 : Réservation d'un livre déjà emprunté (L)

Permettre de se mettre en file d'attente pour un livre dont tous les exemplaires sont empruntés.

Critères d'acceptation :
- Une réservation n'est possible que si aucun exemplaire n'est disponible
- Les réservations sont servies dans l'ordre
- L'adhérent est prévenu au retour du livre

Fichiers concernés : src/Service, src/Model, templates

## F08 : Prolongation d'un emprunt (M)

Autoriser une prolongation unique de 14 jours si aucune réservation n'est en attente.

Critères d'acceptation :
- Une seule prolongation par emprunt
- Refus s'il existe une réservation
- La nouvelle date de fin est affichée

Fichiers concernés : src/Service/EmpruntService.php

## F09 : Suspension après trois retards (M)

Suspendre automatiquement la carte d'un adhérent après trois retards dans les douze derniers mois.

Critères d'acceptation :
- Le compteur ne prend en compte que les retours tardifs
- Un adhérent suspendu ne peut plus emprunter
- Un administrateur peut lever la suspension

Fichiers concernés : src/Service, database/schema.sql
