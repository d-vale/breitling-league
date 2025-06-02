#!/bin/bash
# Script d'installation automatique pour Breitling League
# Compatible avec Unix/Linux/macOS
set -e  # Arrêter le script en cas d'erreur

echo "🚀 Installation de Breitling League..."
echo "======================================"

# Vérifier si nous sommes dans le bon répertoire
if [ ! -f "composer.json" ] || [ ! -f "package.json" ]; then
    echo "❌ Erreur: Ce script doit être exécuté dans le répertoire racine du projet"
    exit 1
fi

# Fonction pour vérifier si une commande existe
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Vérifier les prérequis
echo "🔍 Vérification des prérequis..."

if ! command_exists php; then
    echo "❌ PHP n'est pas installé. Veuillez installer PHP 8.2 ou supérieur."
    exit 1
fi

# Vérifier la version de PHP
PHP_VERSION=$(php -r "echo PHP_VERSION;" | cut -d. -f1,2)
if [ "$(printf '%s\n' "8.2" "$PHP_VERSION" | sort -V | head -n1)" != "8.2" ]; then
    echo "❌ PHP 8.2 ou supérieur requis. Version actuelle: $PHP_VERSION"
    exit 1
fi

if ! command_exists composer; then
    echo "❌ Composer n'est pas installé. Veuillez installer Composer."
    exit 1
fi

if ! command_exists node; then
    echo "❌ Node.js n'est pas installé. Veuillez installer Node.js."
    exit 1
fi

if ! command_exists npm; then
    echo "❌ npm n'est pas installé. Veuillez installer npm."
    exit 1
fi

echo "✅ Tous les prérequis sont installés"

# Installation des dépendances PHP
echo "📦 Installation des dépendances PHP..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# Installation des dépendances Node.js
echo "📦 Installation des dépendances Node.js..."
npm install

# Copie du fichier d'environnement
echo "⚙️  Configuration de l'environnement..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "✅ Fichier .env créé"
else
    echo "ℹ️  Le fichier .env existe déjà"
fi

# Génération de la clé d'application
echo "🔑 Génération de la clé d'application..."
php artisan key:generate --ansi

# Création du dossier database s'il n'existe pas
mkdir -p database

# Création de la base de données SQLite
echo "🗄️  Création de la base de données..."
if [ ! -f "database/database.sqlite" ]; then
    touch database/database.sqlite
    echo "✅ Base de données SQLite créée"
else
    echo "ℹ️  La base de données existe déjà"
fi

# Réinitialisation complète de la base de données avec les seeders
echo "🔄 Réinitialisation complète de la base de données..."
php artisan migrate:fresh --seed --force

# Création du lien symbolique pour le stockage
echo "🔗 Création du lien symbolique pour le stockage..."
php artisan storage:link

# Construction des assets frontend
echo "🎨 Construction des assets frontend..."
npm run build

# Optimisation pour la production (optionnel)
echo "⚡ Optimisation des performances..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Vérification finale
echo "🔍 Vérification de l'installation..."
if php artisan about > /dev/null 2>&1; then
    echo "✅ Laravel fonctionne correctement"
else
    echo "⚠️  Avertissement: Des problèmes de configuration détectés"
fi

echo ""
echo "🎉 Installation terminée avec succès!"
echo "======================================"
echo ""
echo "📋 Informations de connexion:"
echo "   Email: admin@breitling.com"
echo "   Mot de passe: password"
echo ""
echo "🚀 Pour démarrer l'application:"
echo "   Développement: composer run dev"
echo "   ou: php artisan serve (dans un terminal) + npm run dev (dans un autre)"
echo ""
echo "🌐 L'application sera accessible sur:"
echo "   http://localhost:8000"
echo ""
echo "📚 Utilisateurs de test disponibles:"
echo "   - admin@breitling.com (Timekeeper - 1,500,000 points)"
echo "   - sarah.johnson@breitling.com (Diamond - 450,000 points)"
echo "   - marcus.weber@breitling.com (Diamond - 380,000 points)"
echo "   - elena.rodriguez@breitling.com (Platinum - 220,000 points)"
echo "   - marie.dubois@breitling.com (Gold - 120,000 points)"
echo "   - james.miller@breitling.com (Silver - 45,000 points)"
echo "   - sophie.martin@breitling.com (Bronze - 15,000 points)"
echo ""
echo "📖 Documentation supplémentaire dans README.md"
