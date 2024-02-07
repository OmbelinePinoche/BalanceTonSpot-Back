Routes Publiques :

URL
HTTP METHOD
CONTROLLER
METHOD
COMMENTS
/api/location/{id}/spots/snowboard
GET
Snowboard
list
Lister tous les spots de snowboard d’une ville
/api/location/{id}/spots/{id}/snowboard
GET
Snowboard
show
Accéder à un spot de snowboard d’une ville
/api/location/{id}/spots/skateboard
GET
Skateboard
list
Lister tous les spots de skateboard d’une ville
/api/location/{id}/spots/{id}/skateboard
GET
Skateboard
show
Accéder à un spot de skateboard d’une ville
/api/spots
GET
Main
list
Lister tous les spots 
/api/location/{id}/spots
GET
Main
listByLocation
Lister tous les spots d’une ville


/api/snowboard/spot/{id}/comments
GET
Comment
listSnow
Lister les commentaires d’un spot de snowboard
/api/login
POST
User
login
Connexion d’un utilisateur



Routes Privées (connexion requise) :

URL
HTTP METHOD
CONTROLLER
METHOD
COMMENTS
/admin/snowboard/spots
POST
Snowboard
add
Ajouter un spot de snowboard
/admin/snowboard/spot/{id}
PUT
Snowboard
edit
Modifier un spot de snowboard
/admin/snowboard/spot/{id}
DELETE
Snowboard
delete
Supprimer un spot de snowboard
/admin/skateboard/spots
POST
Skateboard
add
Ajouter un spot de skateboard
/admin/skateboard/spot/{id}
DELETE
Skateboard
delete
Supprimer un spot de skateboard
/admin/skateboard/spot/{id}
PUT
Skateboard
edit
Modifier un spot de skateboard
/api/users
GET
User
list
Lister les utilisateurs
/api/user/{id}
GET
User
show
Consulter un profil utilisateur
/api/user/new
POST
User
add
Création d’un utilisateur
/api/user/{id}
PUT
User
edit
Modification d’un utilisateur
/api/user/{id}
DELETE
User
delete
Suppression d’un utilisateur
/api/comment/{id}/add
POST
Comment
add
Ajouter un commentaire sur un spot
/api/comment/update/{id}
PUT
Comment
edit
Modifier un commentaire sur un spot
/api/comment/delete/{id}
DELETE
Comment
delete
Supprimer un commentaire sur un spot
/api/snowboard/spot/{id}/comments
POST
Comment
addSnow
Ajouter un commentaire pour un spot de snowboard
/api/snowboard/spot/{id}/comment/{id}
PUT
Comment
editSnow
Modifier un commentaire d’un spot de snowboard
/api/snowboard/spot/{id}/comment/{id}
DELETE
Comment
deleteSnow
Supprimer un commentaire d’un spot de snowboard
/api/skateboard/spot/{id}/comments
POST
Comment
addSkate
Ajouter un commentaire pour un spot de skateboard
/api/skateboard/spot/{id}/comment/{id}
PUT
Comment
editSkate
Modifier un commentaire d’un spot de skateboard
/api/skateboard/spot/{id}/comment/{id}
DELETE
Comment
deleteSkate
Supprimer un commentaire d’un spot de skateboard




