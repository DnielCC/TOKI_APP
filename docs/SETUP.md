# Guía de Instalación y Configuración

Este documento detalla los pasos necesarios para configurar el entorno de desarrollo local para **TOKI_APP**.

## Prerrequisitos

Asegúrese de tener instalado el siguiente software en su sistema:

- **PHP**: Versión 8.0.2 o superior.
- **Composer**: Gestor de dependencias para PHP.
- **Node.js**: Versión 16.x o superior (recomendado).
- **NPM**: Gestor de paquetes para JavaScript (incluido con Node.js).
- **Base de Datos**: MySQL, PostgreSQL, o SQLite (según preferencia).

## Pasos de Instalación

### 1. Clonar el Repositorio

Clone el repositorio del proyecto en su máquina local:

```bash
git clone <github.com/DnielCC/TOKI_APP>
cd TOKI_APP
```

### 2. Instalar Dependencias de Backend

Utilice Composer para instalar las dependencias de PHP definidas en `composer.json`:

```bash
composer install
```

### 3. Instalar Dependencias de Frontend

Utilice NPM para instalar las dependencias de JavaScript definidas en `package.json`:

```bash
npm install
```

### 4. Configuración del Entorno

Copie el archivo de ejemplo de configuración `.env.example` a `.env`:

**En Windows (PowerShell):**
```powershell
copy .env.example .env
```

**En Linux/Mac:**
```bash
cp .env.example .env
```

Abra el archivo `.env` y configure las credenciales de su base de datos y otras variables de entorno necesarias:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toki_app
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generar Clave de Aplicación

Genere una nueva clave de aplicación para Laravel:

```bash
php artisan key:generate
```

### 6. Migraciones de Base de Datos

Ejecute las migraciones para crear las tablas necesarias en la base de datos:

```bash
php artisan migrate
```

## Ejecución del Proyecto

Para ejecutar la aplicación en un entorno local, necesitará dos terminales:

**Terminal 1: Servidor Laravel**
```bash
php artisan serve
```
Esto iniciará el servidor en `http://127.0.0.1:8000`.

**Terminal 2: Servidor de Desarrollo Vite**
```bash
npm run dev
```
Esto compilará los activos en tiempo real.

## Solución de Problemas Comunes

- **Error de Permisos**: Asegúrese de que las carpetas `storage` y `bootstrap/cache` tengan permisos de escritura.
- **Error de Conexión a BD**: Verifique que el servicio de base de datos esté en ejecución y que las credenciales en `.env` sean correctas.
