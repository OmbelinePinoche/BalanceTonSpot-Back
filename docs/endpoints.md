**Routes Publiques :**

| URL | HTTP METHOD | CONTROLLER | METHOD | COMMENTS |
| --- | --- | --- | --- | --- |
| `/api/spots` | GET | Spot | list | Lister tous les spots |
| `/api/spot/{slug}` | GET | Spot | show | Accéder à un spot |
| `/api/location/{slug}/spots` | GET | Spot | spotByLocation | Lister tous les spots d’une ville |
| `/api/sports` | GET | Sport | list | Lister tous les sports |
| `/api/sport/{slug}` | GET | Sport | show | Accéder à un sport |
| `/api/sport/{slug}/spots` | GET | Sport | listBySport | Lister tous les spots en fonction du sport |
| `/api/location/{slug}/spots/snowboard` | GET | Sport | listSnow | Lister tous les spots de snowboard d’une ville |
| `/api/location/{slug}/spots/skateboard` | GET | Sport | listSkate | Lister tous les spots de skateboard d’une ville |
| `/api/location` | GET | Location | list |  Lister toutes les villes |
| `/api/location/{slug}` | GET | Location | show | Accéder à une ville |
| `/api/comments` | GET | Comment | list | Lister tous les commentaires |
| `/api/comment/{id}` | GET | Comment | show | Accéder à un commentaires |
| `/api/spot/{slug}/comments` | GET | Comment | listBySpot | Lister les commentaires d’un spot |

**Routes Privées (connexion requise) :**

| URL | HTTP METHOD | CONTROLLER | METHOD | COMMENTS |
| --- | --- | --- | --- | --- |
| `/api/comments` | POST | Comment | add | Ajouter un commentaire |
| `/api/secure/comment/{id}` | PUT | Comment | edit | Modifier un commentaire |
| `/api/secure/comment/{id}` | DELETE | Comment | delete | Supprimer un commentaire |
| `/api/users` | GET | User | list | Lister les utilisateurs |
| `/api/user` | GET | User | show | Consulter le profil de l'utilisateur connecté|
| `/api/user` | PUT | User | edit | Modification de l'utilisateur connecté |
| `/api/user/{id}` | DELETE | User | delete | Suppression de l'utilisateur connecté|
