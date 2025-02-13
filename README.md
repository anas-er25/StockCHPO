# StockPro - Gestion de Stock

StockPro est une application web de gestion des stocks permettant de suivre les niveaux de stock en temps réel, de gérer les mouvements de stocks (entrées, sorties, transferts) et d'analyser les tendances et prévisions de vente.

### Fonctionnalités principales :

-   Analyse en temps réel des niveaux de stock, tendances de ventes et prévisions.
-   Suivi des stocks à travers plusieurs emplacements.
-   Gestion détaillée des mouvements de stock (entrées, sorties, transferts).
-   Interface intuitive avec une expérience utilisateur fluide grâce à Tailwind CSS et Heroicons.

## Prérequis

Avant de commencer, assurez-vous d'avoir les outils suivants installés sur votre machine :

-   PHP >= 8.1
-   Composer
-   Laravel 11
-   MySQL 5.7 ou supérieur

## Installation

Suivez ces étapes pour installer et configurer le projet :

1. Clonez le repository :

```bash
git clone https://github.com/anas-er25/StockCHPO.git
cd stockpro
composer install
cp .env.example .env
```

2. Configurez votre base de données MySQL dans le fichier .env :
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=stockpro
   DB_USERNAME=votre_utilisateur
   DB_PASSWORD=votre_mot_de_passe

3. Exécutez les migrations pour configurer la base de données :

```bash
php artisan migrate
```

4. (Optionnel) Installez les dépendances front-end avec npm si nécessaire :

```bash
npm install
```

5. Lancez le serveur de développement :

```bash
php artisan serve
```

## Test

L'application inclut une suite de tests unitaires et fonctionnels. Pour exécuter les tests, utilisez la commande suivante :

```bash
php artisan test
```

## Technologies utilisées

-   **Backend** : Laravel 11
-   **Frontend** : Tailwind CSS
-   **Base de données** : MySQL

## Auteurs

Ce projet a été créé par **Anas ER-RAKIBI**.

### Licence:

### Explications :

1. **Introduction et Fonctionnalités** : Un résumé des caractéristiques principales de votre projet.
2. **Prérequis** : Les outils nécessaires pour que le projet fonctionne.
3. **Installation** : Un guide étape par étape pour installer et configurer le projet sur une machine locale.
4. **Structure du projet** : Une description de la structure des dossiers du projet pour aider les développeurs à naviguer facilement.
5. **Développement** : Des instructions pour travailler sur le projet en utilisant un contrôle de version.
6. **Tests** : Indications pour exécuter des tests unitaires et fonctionnels.
7. **Technologies** : Liste des technologies utilisées pour le développement du projet.
8. **Auteurs et Licence** : Informations de base concernant les auteurs et la licence du projet.

Assurez-vous de remplacer `https://votre-repository-url.git` par l'URL réelle de votre repository.
