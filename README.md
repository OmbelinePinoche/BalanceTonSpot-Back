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

- `/api/spot/{id}` - GET - Accéder à un spot de snowboard spécifique.
- `/api/spots` - GET - Récupérer la liste de tous les spots.
- `/api/sport/{id}/spots` - GET - Récupérer la liste des spots en fonction du sport.
- `/api/location/{id}/spots` - GET - Récupérer tous les spots en fonction d'une ville
- `/api/spots` - POST - Ajouter un nouveau spot de snowboard.
- `/api/spot/{id}` - PUT - Modifier les détails d'un spot de snowboard.
- `/api/spot/{id}` - DELETE - Supprimer un spot de snowboard.


## Documentation

Vous pouvez retrouver quelques commandes pour l'installation de dépendances Symfony ou la création de classes dans le fichier `commandes.md` du dossier `docs`.
Pour plus d'informations sur l'utilisation de chaque endpoint, veuillez consulter le fichier `endpoints.md`, également dans le dossier `docs`.