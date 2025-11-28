# Guía de Contribución

Agradecemos su interés en contribuir a **TOKI_APP**. Este documento establece las pautas para contribuir al proyecto de manera efectiva y profesional.

## Flujo de Trabajo

Utilizamos el flujo de trabajo de "Feature Branch".

1.  **Fork**: Realice un fork del repositorio si no tiene permisos de escritura directa.
2.  **Clone**: Clone el proyecto a su entorno local.
3.  **Branch**: Cree una rama para su nueva funcionalidad o corrección de error.
    ```bash
    git checkout -b feature/nombre-de-la-funcionalidad
    # o
    git checkout -b fix/descripcion-del-error
    ```
4.  **Code**: Realice sus cambios. Asegúrese de seguir los estándares de código.
5.  **Commit**: Realice commits con mensajes claros y descriptivos.
    ```bash
    git commit -m "feat: agrega nueva funcionalidad de login"
    ```
6.  **Push**: Suba su rama al repositorio remoto.
    ```bash
    git push origin feature/nombre-de-la-funcionalidad
    ```
7.  **Pull Request**: Abra un Pull Request (PR) hacia la rama `main` o `develop` del repositorio original.

## Estándares de Código

### PHP (Laravel)
- Seguimos el estándar **PSR-12**.
- Utilice nombres descriptivos para clases, métodos y variables.
- Mantenga los controladores delgados ("Skinny Controllers") y la lógica de negocio en Modelos o Servicios.

### JavaScript
- Utilice sintaxis moderna (ES6+).
- Formatee el código consistentemente (se recomienda usar Prettier).

### Commits
Recomendamos seguir la convención de **Conventional Commits**:
- `feat`: Una nueva funcionalidad.
- `fix`: Una corrección de error.
- `docs`: Cambios en la documentación.
- `style`: Cambios de formato (espacios, puntos y coma, etc.).
- `refactor`: Refactorización de código sin cambios en la lógica.

## Reporte de Errores

Si encuentra un error, por favor abra un "Issue" en el repositorio incluyendo:
- Pasos para reproducir el error.
- Comportamiento esperado vs. comportamiento real.
- Capturas de pantalla (si aplica).
- Entorno (SO, Navegador, Versión de PHP).

## Seguridad

Si descubre una vulnerabilidad de seguridad, por favor **NO** abra un issue público. Contacte directamente al equipo de desarrollo o envíe un correo a seguridad@ejemplo.com.
