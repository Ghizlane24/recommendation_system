# Système de Recommandation de Livres pour Bibliothèque

## Description
Système de recommandation qui suggère des livres aux utilisateurs en se basant sur leurs lectures passées, leurs genres préférés et la popularité des livres. Le système analyse l'historique des réservations pour créer des recommandations personnalisées.

## Documentation et Explication de l’Approche

# Explication de l'Approche:

L'algorithme combine les préférences de lecture de l'utilisateur avec des livres populaires pour fournir des recommandations personnalisées et variées, offrant ainsi une plus grande diversité de choix.
Sans limite de résultats, l'algorithme doit gérer un affichage plus large, ce qui a été pris en compte pour maintenir une performance efficace.


### Choix d'Algorithme

# Pertinence des Suggestions:

 - Les livres recommandés sont basés sur les genres que l'utilisateur a réservés, garantissant que les suggestions restent pertinentes et adaptées à ses goûts.

# Optimisation et Rapidité:

 - L'algorithme est conçu pour fonctionner efficacement même avec une grande base de données. Les requêtes SQL restent optimisées pour récupérer tous les livres correspondants sans sacrifier les performances, en utilisant des index appropriés sur les colonnes de recherche.
 - L'utilisation de requêtes préparées sécurise les entrées et aide à maintenir une performance stable.

# Qualité du Code:

 - Le code est structuré de manière modulaire, ce qui facilite la maintenance et la compréhension.
 - Les bonnes pratiques PHP sont respectées, avec un focus sur la clarté et l'organisation du code.

## Prérequis
- PHP 8.2 ou supérieur
- MySQL 8.3 ou supérieur
- Serveur web Apache
- Module PDO PHP activé

## Installation

### 1. Configuration du Serveur Web
Copier les fichiers du projet dans le répertoire du serveur web, par exemple `./www` du wamp-server.


### 2. Base de Données
```sql

-- Table for storing users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

-- Table for storing books
CREATE TABLE books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    popularity_score INT DEFAULT 0
);

-- Table for storing reservations
CREATE TABLE reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_book INT NOT NULL,
    date_reservation DATE NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_book) REFERENCES books(id)
);

-- Indexes for optimization
CREATE INDEX idx_user ON reservations(id_user);
CREATE INDEX idx_book ON reservations(id_book);
CREATE INDEX idx_genre ON books(genre);
CREATE INDEX idx_popularity ON books(popularity_score);
```

### 3. Structure du Projet
```
project/
         ├── db/ 
         │   └── database.php  # Configuration de la base de données
         ├── functions/   
         │       └── operations.php  # Fonctions de gestion des recommandations
         ├──  reserve.php   # Système de réservation de livres      
         └── index.php  # Page principale du projet
```
## Fonctionnement du Système de Recommandation

 - Suggestions par Genre Favori : Les livres correspondant aux genres préférés de l'utilisateur et qu'il n'a pas encore réservés.
 - Suggestions Basées sur la Popularité : Une sélection de livres populaires (parmi les plus réservés du mois) qui n'ont pas encore été réservés par l’utilisateur.
 - Sur la page d'accueil, l'utilisateur peut voir :

   - Ses préférences de lecture : Affichage de ses genres favoris et du nombre de livres réservés pour chaque genre.
   - Suggestions de livres : Des livres basés sur ses préférences et sur les livres populaires avec un bouton "Réserver maintenant".
## Score de Popularité
- Calculé automatiquement lors des réservations
- Basé sur le nombre de réservations des 30 derniers jours
- Mis à jour à chaque nouvelle réservation