# TOKI_APP

![Laravel](https://img.shields.io/badge/Laravel-9.19-FF2D20?style=flat&logo=laravel&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-4.0-646CFF?style=flat&logo=vite&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat&logo=php&logoColor=white)

TOKI_APP es una aplicación web desarrollada con el framework Laravel y Vite. Este proyecto ha sido diseñado priorizando la escalabilidad, el mantenimiento y la adherencia a los estándares de la industria.

## Documentación

Se ha elaborado una documentación técnica detallada para facilitar la comprensión, instalación y despliegue del sistema:

- **[Guía de Instalación y Configuración](docs/SETUP.md)**: Instrucciones detalladas para la configuración del entorno de desarrollo local.
- **[Arquitectura del Sistema](docs/ARCHITECTURE.md)**: Descripción técnica del stack tecnológico, estructura de directorios y flujo de datos.
- **[Documentación de API](docs/API.md)**: Especificación de los endpoints disponibles y métodos de autenticación.
- **[Guía de Despliegue](docs/DEPLOYMENT.md)**: Procedimientos recomendados para el despliegue en entornos de producción.
- **[Guía de Contribución](docs/CONTRIBUTING.md)**: Normas de codificación y flujo de trabajo para colaboradores.

## Inicio Rápido

Para iniciar el proyecto en un entorno local con los requisitos previos instalados (PHP, Composer, Node.js), ejecute los siguientes comandos:

```bash
# 1. Instalar dependencias
composer install
npm install

# 2. Configurar entorno
copy .env.example .env
php artisan key:generate

# 3. Ejecutar servidores (en terminales separadas)
php artisan serve
npm run dev
```

## Stack Tecnológico

- **Backend**: Laravel 9
- **Frontend**: Vite, Blade, Axios
- **Base de Datos**: Compatible con MySQL, PostgreSQL, SQLite

## Licencia

Este proyecto es software de código abierto licenciado bajo la [MIT license](https://opensource.org/licenses/MIT).
