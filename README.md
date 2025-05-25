# 🎮 Versus Brawl

**Versus Brawl** est une application web Symfony dédiée à l'organisation de tournois e-sport. Elle permet aux joueurs, équipes et organisateurs de gérer facilement des compétitions multi-jeux avec une large variété de formats.

---

## 🕹 Fonctionnalités principales

- 🎯 Création d'événements avec :
  - Image personnalisée
  - Date
  - Jeu sélectionné
  - Format de tournoi flexible
- 👑 Deux types d’administrateurs :
  - **Super admin** : contrôle total
  - **Event admin** : gestion uniquement des événements créés
- 🧑‍🤝‍🧑 Système d’équipes :
  - Création d'équipe avec nom, image et liste de membres
  - Capitaine = utilisateur créateur
  - Inscription aux événements limitée à ses propres équipes
- 🗓 Page publique listant les événements, avec filtres puissants :
  - Par jeu
  - Intervalle de dates
  - Mode complet (ex : "creative > zonewars > 2v2")
  - Événements à venir uniquement
- 👁‍🗨 Vue détaillée d’un événement :
  - Affiche le jeu, les participants, l’organisateur
  - Gestion des inscriptions selon le format (solo ou équipe)
- 🧩 Formats de tournoi pris en charge :
  - Élimination directe
  - Ligue
  - Double élimination
  - Phase de poules → élimination directe (type Coupe du Monde)
  - Format **GSL** (ex : Valorant Champions)
  - **Battle Royale** (classement par points)
  - 🔜 Créatifs : zonewars, boxfight, etc.

---
- **Sécurité** :
  - Rôles : `ROLE_USER`, `ROLE_EVENT_ADMIN`, `ROLE_SUPER_ADMIN`
  - Authentification avec `UserPasswordListener` (hash automatique)
    
- **Image fallback** :
  - Si aucune image n’est fournie : bannière ou illustration par défaut en fonction du jeu

---

## 🧪 Données de test

Des fixtures sont disponibles pour lancer un environnement de démonstration complet :

- 🎮 Jeux préremplis (Fortnite, Valorant, R6, etc.)
- 👤 Utilisateurs avec rôles variés
- 🏆 Événements à venir et passés
- 🧑‍🤝‍🧑 Équipes et membres
- 📊 Formats de jeu prédéfinis selon les jeux et catégories

---

## 🚀 Installation locale

```bash
git clone https://github.com/ton-utilisateur/versus-brawl.git

composer install

php bin/console doctrine:database:create

php bin/console doctrine:migrations:migrate

php bin/console doctrine:fixtures:load

