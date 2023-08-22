# Commandes

## !! Faire dans cet ordre !!
```bash
composer require symfony/messenger
composer require doctrine/annotations
composer require symfony/webapp-pack
```
composer require symfony/webapp-pack installe toutes les dépendances ci-dessous d'un coup
Il faut quand même installer :
```bash
composer require symfony/apache-pack
```

## Installer le maker de symfony
```bash
# https://symfony.com/bundles/SymfonyMakerBundle/current/index.html
composer require --dev symfony/maker-bundle
```
## Afficher toutes les commandes du make de symfony
```bash
php bin/console list make
```
## Créer un controller + sa vue avec le maker de symfony
```bash
php bin/console make:controller NomDuContrôleur

# Et on a le résultat ci dessous
created: src/Controller/NomDuContrôleurController.php
created: templates/NomDuContrôleur/index.html.twig

```
## Installer les comosants pour l'environnement de debuggage
```bash
composer require symfony/debug-bundle
composer require symfony/monolog-bundle
composer require symfony/profiler-pack
```
## Installer un projet symfony version skeleton (squelette)
```bash
composer create-project symfony/skeleton oflix 
```

## Installer le apache-pack (nécéssaire pour le routing, besoin du .htaccess)
```bash
composer require symfony/apache-pack  
# puis répondre yes !!! 
```

## Pour installer les annotations (système de routing symfony)
```bash
composer require sensio/framework-extra-bundle 
```
Puis faire un :
```php
use Symfony\Component\Routing\Annotation\Route; 
```
## Pour installer Twig (moteur de template symfony)
```bash
composer require symfony/twig-bundle
```

## Pour installer Doctrine : ORM de Symfony (object-relational mapping)
```bash
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
```

## Installer toutes les dépendances d'un coup
```bash
composer require symfony/webapp-pack
```
et si message d'erreur pour les annotations 
```bash
composer require doctrine/annotations
```

## Clear cache
```bash
php bin/console cache:clear
```

## (pour ceux qui veulent tester le make:crud il faut installer composer require sensio/framework-extra-bundle)

# Méthode sauvage pour faire fonctionner les migrations

## On supprime la database
`bin/console doctrine:database:drop --force`
## On recrée la database
`bin/console doctrine:database:create`
## Si les fichiers de migrations ne sont pas à jour, on les créée
`bin/console make:migration`
## On éxécute les migration (migrate)
`bin/console doctrine:migrations:migrate`