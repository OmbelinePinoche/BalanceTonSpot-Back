# Balance Ton Spot - Backend

Bienvenue dans le backend de l'application Balance Ton Spot ! Cette application permet aux utilisateurs de découvrir les spots de skateboard et snowboard près de chez eux!

## Prérequis

- PHP 5.4
- Symfony 7.0
- Base de données (MySQL)

## Installation

1. Clonez le repository:

    ```bash
    git clone git@github.com:O-clock-Falafel/projet-04-balance-ton-spot-back.git
    ```

2. Installez les dépendances avec Composer:

    ```bash
    composer install
    ```

3. Configurez votre base de données en copiant le fichier `.env.example` en `.env` et en modifiant les paramètres de connexion à la base de données si besoin.

4. Créez la base de données et effectuez les migrations:

    ```bash
    php bin/console doctrine:database:create
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    ```

5. Lancez le serveur de développement:

    ```bash
    php -S 0.0.0.0:8080 -t public
    ```

Votre backend Symfony devrait être accessible à l'adresse http://localhost:8080.

## Endpoints

- `/api/spots` - GET - Lister tous les spots
- `/api/spot/{slug}` - GET - Accéder à un spot
- `/api/location/{slug}/spots` - GET - Lister tous les spots d’une ville
- `/api/sports` - GET - Lister tous les sports
- `/api/sport/{slug}` - GET - Accéder à un sport
- `/api/sport/{slug}/spots` - GET - Lister tous les spots en fonction du sport
- `/api/locations` - GET - Lister toutes les villes
- `/api/location/{slug}` - GET - Accéder à une ville
- `/api/comments` - GET - Lister tous les commentaires

## Documentation

Vous pouvez retrouver quelques commandes pour l'installation de dépendances Symfony ou la création de classes dans le fichier `commandes.md` du dossier `docs`.
Pour plus d'informations sur l'utilisation de chaque endpoint, veuillez consulter le fichier `endpoints.md`, également dans le dossier `docs`.
