# Challenge Intro Symfony 1/2
Dans le dossier [sources](./sources/), on a l'intégration HTML et CSS du site oflix.
L'objectif ici est de créer quelques pages et leur routes dans notre projet Symfony. 
## Mettre en places 2 routes 
Pour ce challenge il faudra :
- Mettre en place la page HTML "home"
- Mettre en place la page HTML "favoris"

# Les routes à mettre en place

| URL | Méthode HTTP | Contrôleur            | Méthode | Titre HTML           | Commentaire    |
| --- | ------------ | ----------------      | ------- | -------------------- | -------------- |
| `/` | `GET`        | `MainController`      | `home`  | Bienvenue sur O'flix | Page d'accueil |
| `/favorites` | `GET`        | `FavoritesController` | `list`  | Bienvenue sur O'flix | Page d'accueil |
