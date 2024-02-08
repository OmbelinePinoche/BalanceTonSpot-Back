**Routes Publiques :**

| URL | HTTP METHOD | CONTROLLER | METHOD | COMMENTS |
| --- | --- | --- | --- | --- |
| `/api/location/{id}/spots` | GET | Sport | list | Lister tous les spots d’une ville |
| `/api/location/{id}/spots/{id}` | GET | Sport | show | Accéder à un spot d’une ville |
| `/api/spot/{id}` | GET | Spot | list | Accéder à un spot |
| `/api/spots` | GET | Spot | list | Lister tous les spots |
| `/api/location/{id}/spots/snowboard` | GET | Sport | list | Lister tous les spots de snowboard d’une ville |
| `/api/location/{id}/spots/skateboard` | GET | Sport | list | Lister tous les spots de skateboard d’une ville |
| `/api/spot/{id}/comments` | GET | Comment | listSnow | Lister les commentaires d’un spot |
| `/api/login` | POST | User | login | Connexion d’un utilisateur |

**Routes Privées (connexion requise) :**

| URL | HTTP METHOD | CONTROLLER | METHOD | COMMENTS |
| --- | --- | --- | --- | --- |
| `/api/spots` | POST | Spot | add | Ajouter un spot |
| `/api/spot/{id}` | PUT | Spot | edit | Modifier un spot |
| `/api/spot/{id}` | DELETE | Spot | delete | Supprimer un spot |
| `/api/users` | GET | User | list | Lister les utilisateurs |
| `/api/user/{id}` | GET | User | show | Consulter un profil utilisateur |
| `/api/user/new` | POST | User | add | Création d’un utilisateur |
| `/api/user/{id}` | PUT | User | edit | Modification d’un utilisateur |
| `/api/user/{id}` | DELETE | User | delete | Suppression d’un utilisateur |
| `/api/comment/{id}/add` | POST | Comment | add | Ajouter un commentaire sur un spot |
| `/api/comment/update/{id}` | PUT | Comment | edit | Modifier un commentaire sur un spot |
| `/api/comment/delete/{id}` | DELETE | Comment | delete | Supprimer un commentaire sur un spot |
| `/api/spot/{id}/comments` | POST | Comment | addSnow | Ajouter un commentaire pour un spot |
| `/api/spot/{id}/comment/{id}` | PUT | Comment | editSnow | Modifier un commentaire d’un spot |
| `/api/spot/{id}/comment/{id}` | DELETE | Comment | deleteSnow | Supprimer un commentaire d’un spot |
