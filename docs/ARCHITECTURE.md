# Arquitectura del Sistema

## Visión General

**TOKI_APP** es una aplicación web moderna construida sobre el framework **Laravel** (PHP) para el backend y utiliza **Vite** para la gestión y construcción de activos frontend. La arquitectura sigue el patrón de diseño Modelo-Vista-Controlador (MVC), estándar en el desarrollo con Laravel.

## Tecnologías Principales

### Backend
- **Framework**: Laravel 9.19
- **Lenguaje**: PHP 8.0+
- **ORM**: Eloquent (incluido en Laravel) para la interacción con la base de datos.
- **Autenticación**: Laravel Sanctum (configurado para APIs y SPAs).

### Frontend
- **Build Tool**: Vite 4.0.0
- **Estilos**: PostCSS (configurado por defecto).
- **Librerías JS**: Axios (para peticiones HTTP), Lodash.
- **Motor de Plantillas**: Blade (nativo de Laravel).

## Estructura de Directorios

A continuación se describen los directorios más relevantes del proyecto:

- **`app/`**: Contiene el núcleo de la lógica de la aplicación (Modelos, Controladores, Middleware).
- **`config/`**: Archivos de configuración global de la aplicación.
- **`database/`**: Migraciones, seeders y factories para la base de datos.
- **`public/`**: El punto de entrada web. Contiene el `index.php` y activos compilados.
- **`resources/`**:
    - `views/`: Plantillas Blade.
    - `css/` y `js/`: Código fuente del frontend (sin compilar).
- **`routes/`**: Definiciones de rutas (`web.php` para navegador, `api.php` para API REST).
- **`tests/`**: Pruebas automatizadas (Unitarias y de Feature).

## Flujo de Datos

1.  **Petición**: El usuario realiza una petición HTTP (desde el navegador o cliente API).
2.  **Enrutamiento**: Laravel enruta la petición basándose en `routes/web.php` o `routes/api.php`.
3.  **Controlador**: La ruta invoca un método en un Controlador (o un Closure).
4.  **Lógica de Negocio**: El controlador interactúa con los Modelos para recuperar o persistir datos.
5.  **Respuesta**:
    - Para rutas web: Se renderiza una vista Blade (`resources/views`), que puede incluir activos procesados por Vite.
    - Para rutas API: Se devuelve una respuesta JSON.

## Integración Vite

Vite reemplaza a Laravel Mix en esta versión. Se configura a través de `vite.config.js`. En desarrollo (`npm run dev`), Vite sirve los activos con Hot Module Replacement (HMR). En producción (`npm run build`), genera archivos estáticos optimizados en `public/build`.
