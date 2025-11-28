# Guía de Despliegue (Deployment)

Este documento describe los pasos recomendados para desplegar **TOKI_APP** en un entorno de producción.

## Requisitos del Servidor

El servidor de producción debe cumplir con los mismos requisitos que el entorno local (PHP 8.0+, Composer, Node.js, Base de Datos), además de un servidor web como Nginx o Apache.

## Proceso de Despliegue

### 1. Obtener el Código

```bash
git pull origin main
```

### 2. Instalar Dependencias (Sin Dev)

```bash
composer install --optimize-autoloader --no-dev
npm install
```

### 3. Compilar Activos para Producción

Ejecute Vite para compilar y minificar los archivos CSS y JS.

```bash
npm run build
```

### 4. Ejecutar Migraciones

Asegúrese de que la base de datos esté actualizada.

```bash
php artisan migrate --force
```

### 5. Optimización de Laravel

Ejecute los siguientes comandos para cachear la configuración, rutas y vistas, lo que mejora significativamente el rendimiento.

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Permisos

Asegúrese de que el servidor web (ej. `www-data`) tenga permisos de escritura en las carpetas de almacenamiento.

```bash
chown -R www-data:www-data storage bootstrap/cache
```

## Configuración de Nginx (Ejemplo)

```nginx
server {
    listen 80;
    server_name midominio.com;
    root /ruta/a/TOKI_APP/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```
