# 🌟 Talentis
Bienvenue sur **Talentis**, une plateforme de gestion conçue pour simplifier la mise en relation entre les talents et les entreprises.

---

## 🚀 Prérequis

Avant de commencer, assure-toi d’avoir les outils suivants installés sur **Windows** :

- [PHP 8.2+](https://www.php.net/downloads.php) (Vérifie avec `php -v`)
- [Composer](https://getcomposer.org/download/) (Vérifie avec `composer -V`)
- [Node.js 18+ et npm](https://nodejs.org/) (Vérifie avec `node -v` et `npm -v`)
- [Git](https://git-scm.com/downloads)
- [MySQL 8+ ou MariaDB](https://www.mysql.com/) (ou SQLite si tu préfères)
- [Laravel Installer (optionnel)](https://laravel.com/docs/11.x/installation)

---

## 🛠️ Installation

### 1️⃣ **Cloner le projet**
```sh
git clone https://github.com/RiperPro03/talentis.git
cd talentis
```

### 2️⃣ **Installer les dépendances PHP et JS**
```sh
composer install
npm install
```

### 3️⃣ **Créer et configurer le fichier `.env`**
```sh
copy .env.example .env
```

Puis modifie le fichier .env avec tes informations de base de données :

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=talentis
DB_USERNAME=root
DB_PASSWORD=ton_mot_de_passe
```

Si tu utilises SQLite, change DB_CONNECTION=sqlite et crée le fichier de base de données :
```sh
type nul > database/database.sqlite
```

### 4️⃣ **Générer la clé d'application**
```sh
php artisan key:generate
```

### 5️⃣ **Exécuter les migrations**
```sh
php artisan migrate
```

---

## 🏃‍♂️ Démarrer le projet

### 🎨 Compiler les assets Frontend (Tailwind + DaisyUI)
```sh
npm run build
```

### 🔗 Créer le lien de stockage public
```sh
php artisan storage:link
```

### 🌐 Démarrer le serveur Laravel
```sh
php artisan serve
```

### 👨‍💻 Contributeurs
- Christopher Asin — [@RiperPro03](https://www.github.com/RiperPro03)
- Enzo Casse — [@Latulipedcd](https://github.com/Latulipedcd)
- Quentin Chabres — [@QuentinGH](https://github.com/QuentinGH)
- Dagmawi Desta — [@Dagmawi229](https://github.com/Dagmawi229)
