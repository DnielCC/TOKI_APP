# Documentación de API

**TOKI_APP** proporciona una API RESTful para interactuar con el sistema externamente o desde aplicaciones cliente.

## Autenticación

La API utiliza **Laravel Sanctum** para la autenticación. Las peticiones a rutas protegidas deben incluir un token de acceso válido en el encabezado `Authorization`.

```http
Authorization: Bearer <tu-token-de-acceso>
```

## Endpoints

### Usuario

#### Obtener Usuario Autenticado

Retorna la información del usuario asociado al token proporcionado.

- **URL**: `/api/user`
- **Método**: `GET`
- **Requiere Autenticación**: Sí

**Respuesta Exitosa (200 OK):**

```json
{
    "id": 1,
    "name": "Nombre Usuario",
    "email": "usuario@ejemplo.com",
    "email_verified_at": "2023-01-01T00:00:00.000000Z",
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
}
```

---

*Nota: Esta documentación se actualizará a medida que se agreguen nuevos endpoints a la aplicación.*
