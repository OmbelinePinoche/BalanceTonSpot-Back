## commande pour créer un nouveau projet symfo : 
```bash
composer create-project symfony/skeleton (nomduprojet)
```
## commande pour installer le fichier .htaccess :
```bash
composer require symfony/apache-pack 
```
## commande pour créer des controllers : 
```bash
composer require --dev symfony/maker-bundle 
```
## commande pour afficher la liste des choses qu'on peut créer : 
```bash
php bin/console list make 
```
## commande pour créer un new controller : 
```bash
php bin/console make:controller 
```
## commande pour instancier asset : 
```bash
composer require symfony/asset  
```
## commande pour installer le composant HttpFoundation pour gérer les sessions : 
```bash
composer require symfony/http-foundation 
```
## commande pour installer profiler : 
```bash
composer require --dev symfony/profiler-pack 
```
## commande pour ajouter les dump dans profiler : 
```bash
composer require debug 
```
## commande pour installer l'ORM de symfony : 
```bash
composer require symfony/orm-pack 
```
## commande pour installer faker : 
```bash
composer require fakerphp/faker 
```
## commande pour crée un formulaire :
```bash
composer require symfony/form php bin/console make:form
```
## commande pour faire une migration
```bash
php bin/console make:migration
```
## commande pour ouvrir le serveur
```bash
php -S 0.0.0.0:8080 -t public
```