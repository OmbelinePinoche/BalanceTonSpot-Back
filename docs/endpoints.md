**Routes Publiques :**

| URL | HTTP METHOD | CONTROLLER | METHOD | COMMENTS |
| --- | --- | --- | --- | --- |
| `/api/spots` | GET | Spot | list | Lister tous les spots |
| `/api/spot/{slug}` | GET | Spot | show | Accéder à un spot |
| `/api/location/{slug}/spots` | GET | Spot | spotByLocation | Lister tous les spots d’une ville |
| `/api/sports` | GET | Sport | list | Lister tous les sports |
| `/api/sport/{slug}` | GET | Sport | show | Accéder à un sport |
| `/api/sport/{slug}/spots` | GET | Sport | listBySport | Lister tous les spots en fonction du sport |
| `/api/location` | GET | Location | list |  Lister toutes les villes |
| `/api/location/{slug}` | GET | Location | show | Accéder à une ville |
| `/api/comments` | GET | Comment | list | Lister tous les commentaires |
| `/api/comment/{id}` | GET | Comment | show | Afficher un commentaires |
| `/api/spot/{slug}/comments` | GET | Comment | listBySpot | Afficher les commentaires d’un spot |
| `/api/pictures` | GET | Picture | list | Lister toutes les images |
| `/api/spot/{slug}/pictures` | GET | Picture | listBySpot | Afficher les images d’un spot |
| `/api/emails` | GET | Mailer | getEmails | Accéder aux emails |
| `/api/emails` | POST | Mailer | sendEmail | Envoyer un email |

**Routes Privées (connexion requise) :**

| URL | HTTP METHOD | CONTROLLER | METHOD | COMMENTS |
| --- | --- | --- | --- | --- |
| `/api/spot/{slug}/comments` | POST | Comment | add | Ajouter un commentaire |
| `/api/secure/comment/{id}` | PUT | Comment | update | Modifier un commentaire |
| `/api/secure/comment/{id}` | DELETE | Comment | delete | Supprimer un commentaire |
| `/api/favorites` | GET | Favorites | list | Liste les spots favoris |
| `/api/favorites/{spotId}` | POST | Favorites | addToFavorites | Ajoute un spot aux favoris |
| `/api/favorites/{spotId}` | DELETE | Favorites | removeFavorite | Supprime un spot des favoris |
| `/api/users` | GET | User | list | Lister les utilisateurs |
| `/api/user` | GET | User | show | Consulter le profil de l'utilisateur connecté |
| `/api/user` | PUT | User | update | Modification de l'utilisateur connecté |
| `/api/user` | DELETE | User | delete | Suppression de l'utilisateur connecté |
| `/api/profile/upload` | PUT | User | updateProfilePicture | Mettre à jour la photo de profil utilisateur |
