# 🌾 TP Laravel - Système de Gestion Post-Récolte des Produits Agricoles

## 🎯 Objectifs Pédagogiques

Ce TP a pour but de permettre aux étudiants de :

- Approfondir leur compréhension de l'architecture MVC de Laravel.
- Manipuler une base de données via Eloquent ORM.
- Implémenter un système de gestion des stocks et des ventes.
- Utiliser Blade pour la gestion des vues et des formulaires.
- Travailler sur la gestion des relations entre modèles.

---

## 🌿 Contexte

Une exploitation agricole souhaite suivre la **gestion post-récolte** de ses produits.  
L'application permet :

- Enregistrement des produits récoltés.
- Gestion des stocks.
- Suivi des ventes et distributions.
- Visualisation de rapports de stock et de vente.

---

## ⚙️ Fonctionnalités

### 👥 Gestion des utilisateurs
- Accès réservé aux utilisateurs authentifiés.
- Authentification via Laravel Breeze ou Laravel UI.

### 🥕 Gestion des produits récoltés
Modèle : `Produit`

🔧 **Actions** : Ajouter, Modifier, Supprimer, Lister les produits.

### 📦 Gestion des stocks
Modèle : `Stock`

🔧 **Actions** : Afficher, Mettre à jour après vente ou distribution.

### 💰 Gestion des ventes / distributions
Modèle : `Transaction`

🔧 **Actions** : Ajouter, Modifier, Supprimer, Historique.

---

## 🖥️ Interface Utilisateur

- **Blade** utilisé pour le rendu des vues.
- Authentification stylée avec **Tailwind CSS**.
- Responsive design.
- Vue détaillée d’un produit avec ses stocks et transactions associées.

---

## 🧱 Stack Technique

| Technologie       | Détails                                |
|-------------------|----------------------------------------|
| **Framework**     | Laravel 10+                             |
| **Base de données**| MySQL                      |
| **Frontend**      | Blade, Tailwind CSS                     |
| **ORM**           | Eloquent ORM                            |
| **Auth**          | Auth Personnalisé          |
| **Migrations**    | Oui                                     |
| **Validation**    | Laravel Validator                     |
| **Sécurité**      | Middleware d’authentification           |

---

## 📊 Autres fonctionnalités

- Génération de rapports PDF.
- Graphiques pour suivre les stocks/ventes.

---

## 📥 Installation du projet

Voici les étapes pour cloner et exécuter ce projet Laravel :

```bash
# 1. Cloner le dépôt
git clone https://github.com/LauryneEklou/agriculture.git

# 2. Aller dans le dossier du projet
cd agriculture

# 3. Installer les dépendances PHP
composer install

# 4. Copier le fichier d'environnement
copy .env.example .env   # Windows PowerShell
# ou
cp .env.example .env     # Linux / macOS

# 5. Générer la clé d'application
php artisan key:generate

# 6. Configurer votre base de données dans le fichier .env

# 7. Lancer les migrations
php artisan migrate

# 8. Lancer le serveur de développement
php artisan serve
