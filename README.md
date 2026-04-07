# Liga Deportiva IES Maestre de Calatrava — UT5

Proyecto correspondiente a la **Actividad 5.2** de la asignatura optativa *Frameworks* (2º DAM, curso 2025/2026).

Despliegue continuo en Render de una aplicación web compuesta por:
- **Frontend Angular 18** + Bootstrap 5
- **Backend Laravel 12** + MySQL en desarrollo local (Laragon, según UT3) / SQLite en producción (Render)
- **Backend Node.js + Express + MongoDB Atlas** (módulos de UT2: login, partidos, árbitros)

## 📂 Estructura del repositorio

```
liga-deportiva-ut5/
├── frontend/         → Aplicación Angular 18 + Bootstrap 5
├── backend/          → API REST Laravel 12 (jugadores, clubes, ligas) - UT3/UT4
├── backend-node/     → API REST Node.js + Express + MongoDB Atlas (login, partidos) - UT2
└── README.md
```

## 🛠️ Desarrollo local

### 1. Backend Laravel + MySQL Laragon (puerto 8000)

Requisitos: Laragon corriendo con Apache y MySQL.

1. Crea la base de datos `liga_maestre` en Laragon (botón "Base de Datos" → New).
2. Comandos:

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

API disponible en `http://localhost:8000/api/jugadors`.

### 2. Backend Node + MongoDB Atlas (puerto 3000)

```bash
cd backend-node
npm install
cp .env.example .env
# Editar .env con la cadena MONGODB_URI real (Atlas)
npm start
```

API disponible en `http://localhost:3000/api/login`, `/api/partidos`, etc.

### 3. Frontend Angular (puerto 4200)

```bash
cd frontend
npm install
npm start
```

App disponible en `http://localhost:4200`.

## 🚀 Despliegue en Render

| Servicio | Tipo | URL |
|---|---|---|
| **Frontend** | Static Site | https://ligadeportiva-app.onrender.com |
| **Backend Laravel** | Web Service (Docker) | https://ligadeportiva-api-laravel.onrender.com |

> **Nota**: En producción, el backend Laravel utiliza SQLite en lugar de MySQL porque Render no ofrece MySQL en su plan gratuito. El código y migraciones son idénticos; solo cambian las variables de entorno.

> **Backend Node**: este servicio no se despliega en Render por motivos de tiempo y limitaciones del plan gratuito. Su código se mantiene en el repositorio como referencia de la UT2.

## 🧪 Pruebas

### Backend Laravel
```bash
cd backend
php artisan test
```

### Frontend unitarios (Karma + Jasmine)
```bash
cd frontend
npm run test:ci
```

### Frontend E2E (Cypress)
```bash
cd frontend
npm run cypress:run
```

## 🔐 Variables de entorno en Render (backend Laravel)

| Key | Value |
|---|---|
| `APP_NAME` | `Liga Deportiva IES Maestre` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `LOG_CHANNEL` | `stack` |
| `LOG_LEVEL` | `error` |
| `DB_CONNECTION` | `sqlite` |
| `SESSION_DRIVER` | `database` |
| `CACHE_STORE` | `database` |
| `QUEUE_CONNECTION` | `database` |

`APP_KEY` se genera automáticamente al arrancar el contenedor (Dockerfile).

## 👤 Autor

Juan José Angulo Gómez — 2º DAM — IES Maestre de Calatrava
