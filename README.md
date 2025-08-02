# WIS - Web Information System

Une application web moderne avec un backend Laravel et un frontend React/TypeScript.

## 📋 Description

WIS (Web Information System) est une application full-stack composée de :

- **Backend** : API Laravel avec authentification
- **Frontend** : Application React avec TypeScript et Vite

## 🏗️ Architecture

```
wis/
├── back-wis/          # Backend Laravel
│   ├── app/           # Code source Laravel
│   ├── config/        # Configuration
│   ├── database/      # Migrations et seeders
│   ├── routes/        # Routes API et web
│   └── ...
└── front-wis/         # Frontend React
    ├── src/           # Code source React/TypeScript
    ├── public/        # Assets statiques
    └── ...
```

## 🚀 Installation

### Prérequis

- PHP >= 8.1
- Composer
- Node.js >= 18
- npm ou yarn

### Backend (Laravel)

```bash
cd back-wis
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Frontend (React)

```bash
cd front-wis
npm install
npm run dev
```

## 📝 Configuration

1. Configurez votre base de données dans `back-wis/.env`
2. Ajustez les paramètres API dans le frontend si nécessaire

## 🛠️ Développement

### Backend

- `php artisan serve` - Démarre le serveur de développement
- `php artisan migrate` - Execute les migrations
- `php artisan test` - Lance les tests

### Frontend

- `npm run dev` - Démarre le serveur de développement
- `npm run build` - Build de production
- `npm run preview` - Aperçu du build

## 📚 Technologies utilisées

### Backend

- Laravel
- PHP
- MySQL/PostgreSQL

### Frontend

- React
- TypeScript
- Vite
- CSS
