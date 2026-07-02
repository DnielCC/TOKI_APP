# TOKI - Aplicación Móvil

Aplicación móvil de comunicación con pictogramas para niños con autismo, desarrollada con React Native y Expo.

## Características

- 📱 Compatible con iOS y Android
- 🎨 Interfaz amigable y colorida
- 🔍 Búsqueda de pictogramas
- 📝 Constructor de frases intuitivo
- 🔊 Texto a voz (TTS) en español
- 💾 Historial de frases guardadas localmente
- 📂 Categorías organizadas (Personas, Emociones, Acciones, Lugares, etc.)

## Requisitos

- Node.js (versión 16 o superior)
- npm o yarn
- Expo Go app en tu teléfono (para pruebas) o un emulador

## Instalación

1. Navega a la carpeta del proyecto:
```bash
cd toki-mobile
```

2. Instala las dependencias:
```bash
npm install
```

## Ejecución

### Para desarrollo con Expo Go:

1. Inicia el servidor de desarrollo:
```bash
npm start
```

2. Abre la app Expo Go en tu teléfono
3. Escanea el código QR que aparece en la terminal

### Para emuladores:

- **Android**:
```bash
npm run android
```

- **iOS**:
```bash
npm run ios
```

## Uso

1. Explora los pictogramas por categorías o usa el buscador
2. Toca un pictograma para agregarlo a tu frase
3. Toca un pictograma en el constructor para eliminarlo
4. Presiona 🔊 para escuchar la frase
5. Presiona 💾 para guardar la frase en el historial
6. Usa el historial para recuperar frases anteriores

## Estructura del Proyecto

```
toki-mobile/
├── App.js                 # Aplicación principal
├── package.json           # Dependencias y scripts
├── app.json               # Configuración de Expo
├── babel.config.js        # Configuración de Babel
├── assets/
│   ├── toki-logo.png      # Logo de la app
│   └── pictos/            # Carpeta con todos los pictogramas
└── README.md
```

## Tecnologías

- **React Native** - Framework para apps móviles
- **Expo** - Plataforma para desarrollo rápido
- **Expo Speech** - Texto a voz
- **Async Storage** - Almacenamiento local

## Licencia

MIT
