# 📚 Lightshelf

**Lightshelf** est une application minimaliste de gestion de bibliothèque personnelle développée avec **Laravel** (backend) et **Vue.js** (frontend). Cette application permet aux utilisateurs de gérer leur collection de livres de manière intuitive et élégante, avec une interface moderne et réactive.


## 📋 Table des matières

- [Objectifs du projet](#-objectifs-du-projet)
- [Architecture technique](#-architecture-technique)
- [Fonctionnalités implémentées](#-fonctionnalités-implémentées)
- [Modèle de données](#-modèle-de-données)
- [Guide d'installation](#-guide-dinstallation)
- [Sécurité](#-sécurité)
- [Technologies utilisées](#-technologies-utilisées)

## ✨ Objectifs du projet

- Créer une application intuitive pour **organiser, suivre et gérer une collection personnelle de livres**
- Implémenter manuellement un **système d'authentification personnalisé** sans recourir à des packages comme Laravel Breeze ou Fortify
- Développer une **Single Page Application (SPA)** performante avec Vue.js et Laravel comme API backend
- Mettre en pratique les concepts fondamentaux du développement web moderne

## 🛠️ Architecture technique

### Backend — Laravel

- **API RESTful** : L'application expose une API complète pour gérer les livres et les utilisateurs
- **Système d'authentification** : Implémentation personnalisée pour l'inscription, la connexion et la déconnexion
- **Middlewares** : Protection des routes avec les middlewares `auth` et `guest` de Laravel
- **Form Requests** : Validation sécurisée des données utilisateur

### Frontend — Vue.js

- **Architecture SPA** : Application monopage offrant une expérience fluide
- **Vue Router** : Gestion avancée des routes côté client
- **Composables** : Utilisation de composables Vue pour la réutilisation de la logique (ex: `useFetchJson`)
- **Thème sombre/clair** : Support complet du mode sombre et clair avec transition fluide

## 🌟 Fonctionnalités implémentées

### Authentification
- Inscription avec validation et vérification d'unicité email
- Connexion avec régénération de session (anti-fixation)
- Modification de profil (prénom, nom, bio)
- Changement de mot de passe avec validation

### Gestion des livres
- Liste des livres avec filtrage par statut (all, read, to-read, pending)
- Ajout/modification avec métadonnées complètes (titre, auteur, ISBN, etc.)
- Stockage d'images de couverture (URL → binaire)
- Suppression avec validation de propriété

### Interface
- Mode sombre/clair (localStorage + préférence système)
- Design responsive (mobile, tablette, desktop)
- Animations et transitions pour le feedback utilisateur

## 🌐 Routes

### Routes d'authentification
```
GET  /register            → Formulaire d'inscription
POST /register            → Traitement de l'inscription
GET  /login               → Formulaire de connexion
POST /login               → Traitement de la connexion
GET  /edit-password       → Formulaire de modification de mot de passe
POST /password/update     → Traitement du changement de mot de passe
DELETE /logout            → Déconnexion
```

### Routes API (prefix: /api/v1)
```
GET    /user              → Profil utilisateur
POST   /user/update       → Mise à jour du profil
DELETE /user/delete       → Suppression de compte
GET    /user/books        → Liste des livres de l'utilisateur
GET    /user/book/{id}    → Détails d'un livre
POST   /create            → Création d'un livre
PATCH  /update/{id}       → Modification d'un livre
DELETE /user/book/{id}    → Suppression d'un livre
GET    /picture/book/{id} → Image de couverture d'un livre
```

### Routes SPA
```
GET / → Redirige vers la landing page (non connecté) ou SPA (connecté)
GET /{any} → Charge la SPA pour toutes les routes non-API
```

## 📚 Modèle de données

### Utilisateur (`users`)

| Champ              | Type            | Description                              |
|--------------------|-----------------|------------------------------------------|
| id                 | integer         | Identifiant unique                       |
| firstname          | string          | Prénom de l'utilisateur                  |
| lastname           | string          | Nom de l'utilisateur                     |
| email              | string          | Email (unique, utilisé pour la connexion)|
| password           | string (hashé)  | Mot de passe sécurisé                    |
| bio                | text (nullable) | Biographie ou description personnelle    |
| admin              | boolean         | Statut administrateur                    |
| created_at         | timestamp       | Date de création                         |
| updated_at         | timestamp       | Date de dernière modification            |

### Livre (`books`)

| Champ              | Type            | Description                              |
|--------------------|-----------------|------------------------------------------|
| id                 | integer         | Identifiant unique                       |
| title              | string          | Titre du livre                           |
| sub_title          | string          | Sous-titre du livre                      |
| author             | string          | Auteur du livre                          |
| reading_status     | enum            | Statut de lecture (read, to-read, pending) |
| resume             | text            | Résumé ou description du livre           |
| format             | string          | Format du livre (broché, poche, etc.)    |
| number_of_pages    | integer         | Nombre de pages                          |
| release_date       | date            | Date de publication                      |
| editor             | string          | Maison d'édition                         |
| isbn               | string          | Numéro ISBN                              |
| cover_image        | binary          | Image de couverture (stockée en binaire) |
| cover_image_path   | string          | URL d'origine de l'image de couverture   |
| cover_image_name   | string          | Nom du fichier image                     |
| user_id            | foreign key     | Référence au propriétaire du livre       |
| created_at         | timestamp       | Date de création                         |
| updated_at         | timestamp       | Date de dernière modification            |

## 🚀 Guide d'installation

### Prérequis

- PHP 8.2 ou supérieur
- Composer
- Node.js et npm
- SQLite (ou autre base de données prise en charge par Laravel)

### Étapes d'installation

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/K-sel/lightshelf.git
   cd lightshelf
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Installer les dépendances JavaScript**
   ```bash
   npm install
   ```

4. **Créer le fichier d'environnement**
   ```bash
   cp .env.example .env
   ```

5. **Générer la clé d'application**
   ```bash
   php artisan key:generate
   ```

6. **Configurer la base de données**
   - Éditer le fichier `.env` pour configurer la connexion à la base de données
   - Par défaut, l'application utilise SQLite

7. **Créer la base de données SQLite**
   ```bash
   touch database/database.sqlite
   ```

8. **Exécuter les migrations et seeders**
   ```bash
   php artisan migrate --seed
   ```

9. **Compiler les assets**
   ```bash
   npm run build
   ```

10. **Démarrer le serveur de développement**
    ```bash
    php artisan serve
    ```

11. **Accéder à l'application**
    - Ouvrir le navigateur et accéder à `http://localhost:8000`
    - Utiliser les identifiants de test : 
      - Email: `johndoe@seed.com` 
      - Mot de passe: `password1`

## 🔐 Sécurité

L'application intègre plusieurs mesures de sécurité :

1. **Protection CSRF** - Tous les formulaires sont protégés contre les attaques CSRF
2. **Validation des entrées** - Validation stricte côté serveur avec Laravel Form Request
3. **Hashage des mots de passe** - Utilisation de bcrypt pour le stockage sécurisé
4. **Régénération de session** - Prévention contre la fixation de session
5. **Autorisation** - Vérification que l'utilisateur ne peut manipuler que ses propres livres
6. **Validation côté client** - Prévention des soumissions invalides

## 💻 Technologies utilisées

### Backend
- **Laravel 12** - Framework PHP moderne
- **SQLite** - Base de données légère (configurable pour d'autres SGBD)
- **PHP 8.2** - Langage de programmation côté serveur

### Frontend
- **Vue.js 4** - Framework JavaScript progressif
- **Vue Router** - Routeur officiel pour Vue.js
- **Tailwind CSS** - Framework CSS utilitaire
- **Vite** - Outil de build moderne

### Outils de développement
- **Composer** - Gestionnaire de dépendances PHP
- **NPM** - Gestionnaire de paquets JavaScript
- **Git** - Système de contrôle de version

## 🌟 Fonctionnalités avancées

### Mode sombre/clair
L'application propose un thème sombre et clair qui peut être basculé à tout moment. Ce paramètre est sauvegardé localement pour être mémorisé entre les sessions. De plus, l'application détecte la préférence système et applique automatiquement le thème approprié.

### Optimisation des images
Les images de couverture sont stockées efficacement avec une approche hybride :
- L'image binaire est stockée en base de données pour un accès rapide
- L'URL d'origine est conservée pour référence
- Une image par défaut est utilisée si l'URL est invalide

### Gestion d'état réactive
L'application utilise le système réactif de Vue.js pour maintenir l'état de l'interface utilisateur en synchronisation avec les données :
- Les mises à jour des livres sont reflétées immédiatement dans l'interface
- Les filtres sont appliqués dynamiquement sans rechargement
- Les transitions et animations rendent l'expérience fluide

## 📝 Conclusion

Lightshelf représente une implémentation complète d'une application web moderne avec une architecture séparée entre frontend et backend. La mise en œuvre manuelle des fonctionnalités d'authentification et de gestion des données démontre une compréhension approfondie des concepts de développement web.

L'application offre une expérience utilisateur fluide et intuitive tout en maintenant un haut niveau de sécurité et de performance. Le design responsive et le support du mode sombre/clair illustrent l'attention portée à l'expérience utilisateur.

---

Développé avec 💙 par K-sel
