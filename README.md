# Nexora — Smart Freelance Marketplace

<p align="center">
  <strong>Plateforme web de mise en relation entre clients et prestataires</strong>
</p>

<p align="center">
  Laravel • PHP • Blade • TailwindCSS • JavaScript • MySQL
</p>

---

## 📌 À propos du projet

**Nexora** est une plateforme web multi-services développée dans le cadre d'un **Projet Fil Rouge Full-Stack**.

L'objectif de la plateforme est de permettre à des **clients** de rechercher et réserver des services proposés par des **prestataires**, tout en offrant un espace d'administration permettant de gérer les utilisateurs, les catégories, les services, les réservations et les avis.

Le projet met en œuvre une architecture **MVC** basée sur Laravel, avec une interface responsive développée avec **Blade, TailwindCSS et JavaScript**.

---

## 🎯 Objectifs

Nexora a pour objectifs de :

- mettre en relation clients et prestataires ;
- permettre la publication et la recherche de services ;
- gérer le cycle complet des réservations ;
- faciliter la communication entre clients et prestataires ;
- permettre l'évaluation des services ;
- proposer des espaces dédiés aux différents rôles ;
- garantir une gestion sécurisée des accès ;
- mettre en œuvre les Events, Listeners, Jobs, Queues et Notifications ;
- assurer la qualité du code grâce aux tests automatisés ;
- préparer l'application au déploiement avec Docker et CI/CD.

---

## 👥 Rôles utilisateurs

Nexora repose sur trois rôles principaux.

### 👤 Client

Le client peut :

- créer un compte ;
- se connecter ;
- gérer son profil ;
- rechercher des services ;
- consulter les détails d'un service ;
- effectuer une réservation ;
- suivre ses réservations ;
- annuler une réservation ;
- ajouter des services aux favoris ;
- discuter avec les prestataires ;
- consulter et rédiger des avis ;
- consulter ses notifications.

### 💼 Prestataire

Le prestataire peut :

- gérer son profil ;
- créer des services ;
- modifier ses services ;
- supprimer ses services ;
- gérer les réservations reçues ;
- accepter ou refuser une réservation ;
- terminer une réservation ;
- communiquer avec les clients ;
- consulter les avis ;
- consulter ses notifications.

### 🛡️ Administrateur

L'administrateur dispose d'un espace dédié permettant de :

- consulter les statistiques ;
- gérer les utilisateurs ;
- gérer les rôles ;
- gérer les catégories ;
- gérer les services ;
- gérer les réservations ;
- gérer les avis.

---

# ✨ Fonctionnalités

## 🔐 Authentification

L'authentification est basée sur **Laravel Breeze**.

Fonctionnalités :

- inscription ;
- connexion ;
- déconnexion ;
- vérification de l'adresse e-mail ;
- mot de passe oublié ;
- réinitialisation du mot de passe ;
- gestion du profil ;
- protection des routes.

---

## 🔑 Rôles et permissions

La gestion des rôles utilise **Laratrust**.

Rôles :

```text
client
provider
admin