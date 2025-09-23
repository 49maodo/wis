# Plateforme Web de Recrutement – Sénégal

Plateforme dédiée à la mise en relation entre professionnels et employeurs sénégalais, adaptée aux spécificités locales.

## Technologies clés

- **Frontend** : React / TypeScript
- **Backend** : Laravel
- **Base de données** : PostgreSQL
- **Authentification** : JWT

## Fonctionnalités principales

### Interfaces

- **Administrateur**
    - Gestion des utilisateurs (recruteurs, candidats)
    - Modération des offres
    - Statistiques globales

- **Recruteur**
    - Publication et gestion des offres d’emploi
    - Suivi des candidatures en mode Kanban
    - Gestion des pipelines de recrutement

- **Candidat**
    - Consultation des offres
    - Candidature en un clic
    - Gestion du profil et références professionnelles

### Recherche avancée

- Filtres : région, secteur, expérience, type de contrat, entreprise

### Adaptation au contexte sénégalais

- Gestion des 14 régions du Sénégal
- Salaires affichés en FCFA
- Classification des secteurs locaux (télécoms, agriculture, fintech, etc.)
- Données de test : entreprises locales (Sonatel, Orange, SGBS...)

### Architecture

- Authentification JWT, gestion fine des rôles
- API RESTful documentée, extensible (mobile, microservices)

## Objectif

Faciliter la mise en relation rapide et efficace entre professionnels et employeurs sénégalais, en tenant compte des spécificités du marché local.

---

## Liste des fonctionnalités

### 1. Administrateur

- Gestion des utilisateurs : création, modification, suppression, attribution de rôles, historique d’activités
- Gestion des entreprises : création et gestion de profils
- Surveillance et rapports : statistiques, rapports d’activité

### 2. Recruteur

- Gestion des offres d’emploi : création, modification, suppression, publication, annulation
- Gestion des candidatures : sélection, invitation à entretien, gestion des statuts
- Gestion du profil entreprise : nom, description, logo, site web
- Notifications : alertes sur candidatures, mises à jour, entretiens

### 3. Candidat

- Création et gestion du profil : expérience, compétences, formations, CV, portfolio, LinkedIn
- Recherche et filtre des offres : secteur, localisation, contrat, salaire, expérience
- Candidature aux offres : soumission de CV et lettre de motivation, suivi des statuts
- Suivi des candidatures : historique, notifications sur avancement
- Alertes : nouvelles offres, changements de statut, invitations à entretien

---

## Contribution

Pour contribuer, veuillez soumettre une pull request ou ouvrir une issue.

## Licence

Ce projet est sous licence MIT.
