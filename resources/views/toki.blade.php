<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Configuración básica del documento -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TOKI</title>
  <style>
    :root { --sky:#cfeefb; --card:#fdeaa6; --white:#ffffff; --green:#99e2a1; --text:#2a2a2a; }
    * { box-sizing: border-box; }
    body {
    margin:0;
    font-family: system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
    color: var(--text);

    background: repeating-linear-gradient(
        -45deg,
        var(--sky),
        var(--sky) 20px,
        #e6f7ff 20px,
        #e6f7ff 40px
    );
  background-size: 100px 100px;
}    .wrap { min-height: 100vh; display:flex; align-items:center; justify-content:center; padding: 24px; }
    .card { width: min(1100px, 96vw); background: var(--card); border-radius: 14px; padding: 28px; box-shadow: 0 8px 20px rgba(0,0,0,.08); }
    .logo { display:flex; align-items:center; justify-content:center; gap: 8px; margin-bottom: 18px; }
    .logo-badge { display: none; }
    .logo-img { height: 96px; width: auto; object-fit: contain; }
    .logo-title { font-weight: 800; font-size: 28px; letter-spacing: 1px; color: #2e6f73; text-shadow: 0 1px 0 #fff; text-transform: uppercase; }
    .layout { display:flex; flex-direction: column; gap: 20px; }
    .main { width: 100%; display:flex; flex-direction: column; gap: 16px; }
    .sidebar { width: 100%; max-width: 100%; }
    .panel { background: var(--white); border-radius: 14px; min-height: 140px; padding: 16px; }
    .panel + .panel { margin-top: 0; }
    .sidebar .panel { height: 100%; max-height: 560px; overflow: auto; }
    .gallery {
      display: flex;
      flex-direction: column;
      gap: 24px;
      padding: 16px;
      width: 100%;
      overflow-y: auto;
      max-height: 100%;
    }
    
    .gallery-section {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    
    .category-separator {
      font-weight: 600;
      font-size: 15px;
      padding: 10px 16px;
      color: #2a2a2a;
      background: #f0f4f8;
      border-radius: 8px;
      position: sticky;
      left: 0;
      z-index: 1;
      margin: 4px 0;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      border-left: 4px solid var(--green);
    }
    
    .pictos-row {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
      gap: 12px;
      width: 100%;
      padding: 4px 0;
    }
    
    .picto {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      min-width: 0;
      padding: 12px 8px;
      border-radius: 12px;
      background: #ffffff;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      transition: all 0.2s ease;
      cursor: grab;
      user-select: none;
      opacity: 0;
      animation: popIn 0.3s ease-out forwards;
      position: relative;
      overflow: visible;
      border: 1px solid rgba(0,0,0,0.1);
      height: auto;
      min-height: 130px;
    }
    
    .picto:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .picto:active {
      cursor: grabbing;
      transform: scale(0.98);
    }
    
    .picto-img {
      width: 48px;
      height: 48px;
      object-fit: contain;
      display: none;
      mix-blend-mode: multiply;
    }
    
    .picto-emoji {
      font-size: 32px;
      line-height: 1;
      min-height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .picto-label {
      font-size: 13px;
      text-align: center;
      color: #000000 !important;
      width: 100%;
      white-space: normal;
      overflow: visible;
      text-overflow: clip;
      font-weight: 600;
      padding: 4px 2px;
      background: #ffffff !important;
      border-radius: 4px;
      margin: 6px 0 0 0;
      border: 1px solid #e0e0e0 !important;
      box-shadow: 0 1px 3px rgba(0,0,0,0.08) !important;
      line-height: 1.2;
      letter-spacing: 0.01em;
      text-transform: capitalize;
      position: relative;
      z-index: 2;
      word-break: break-word;
      max-height: none;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .pictos-row {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
      }
      
      .picto {
        padding: 10px 4px;
        min-height: 110px;
        justify-content: space-between;
      }
      
      .picto-img {
        width: 36px;
        height: 36px;
      }
      
      .picto-emoji {
        font-size: 26px;
      }
      
      .picto-label {
        font-size: 11px !important;
        padding: 3px 2px !important;
        margin-top: 6px !important;
        line-height: 1.1;
        -webkit-line-clamp: 2;
      }
    }
    
    /* Custom scrollbar */
    .gallery::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }
    
    .gallery::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 4px;
    }
    
    .gallery::-webkit-scrollbar-thumb {
      background: #cbd5e0;
      border-radius: 4px;
    }
    
    .gallery::-webkit-scrollbar-thumb:hover {
      background: #a0aec0;
    }
    /* Removed duplicate .picto styles */
    .picto:active { cursor: grabbing; }
    .picto-img { width: 56px; height: 56px; object-fit: contain; display:none; mix-blend-mode: multiply; }
    .builder { display:flex; flex-wrap: wrap; gap: 12px; min-height: 200px; align-content:flex-start; }
    .token { display:flex; align-items:center; justify-content:center; gap:6px; padding: 10px 14px; border-radius: 999px; background:#f5f5f5; border:2px dashed #d7d7d7; cursor: grab; user-select:none;animation: popIn 0.3s ease-out; }
    .token .emoji { font-size: 22px; }
    .token .img { width: 24px; height: 24px; object-fit: contain; display:none;  mix-blend-mode: multiply;}
    .token.removing { opacity:.5; }
    .bar { display:flex; align-items:center; gap:12px; margin-top: 16px; }
    .phrase { flex:1; height: 48px; border-radius: 999px; border:none; padding: 0 16px; background: var(--white); box-shadow: inset 0 0 0 2px rgba(0,0,0,.06); font-size: 16px; }
    .send { width: 44px; height: 44px; border-radius: 50%; border:none; background: var(--green); display:flex; align-items:center; justify-content:center; cursor: pointer; box-shadow: 0 2px 0 rgba(0,0,0,.08);transition: all 0.2s ease-out; }
    /* --- AÑADE ESTE NUEVO BLOQUE --- */

    .send:hover {
    /* Al pasar el mouse */
    transform: scale(1.15); /* Lo hacemos 15% más grande */
    filter: brightness(1.1); /* Lo hacemos más brillante */
    box-shadow: 0 4px 12px rgba(0,0,0,.15); /* Le damos más sombra */
    }

    .send:active {
    /* Al hacer clic */
    transform: scale(0.9); /* Lo encogemos para simular "presión" */
    filter: brightness(0.9); /* Lo oscurecemos un poco */
    transition-duration: 0.1s; /* Hacemos que esta acción sea más rápida */
    }
    .droppable { outline: 3px dashed #a7d6ff; outline-offset: -6px; }

    /* Historial de frases */
    .history-container {
      margin-top: 16px;
      background: #F5F6FA;
      border-radius: 8px;
      padding: 0;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .history-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #e8f5e9;
      padding: 0 12px 0 16px;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
      border-bottom: 1px solid #e0e0e0;
    }
    
    .history-title {
      font-size: 14px;
      font-weight: 600;
      color: #2D3436;
      padding: 12px 0;
      margin: 0;
    }
    
    .clear-history {
      background: none;
      border: none;
      cursor: pointer;
      padding: 8px;
      border-radius: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #e74c3c;
      transition: all 0.2s ease;
    }
    
    .clear-history:hover {
      background: rgba(231, 76, 60, 0.1);
    }
    
    .clear-history:active {
      transform: scale(0.95);
    }
    
    .clear-history svg {
      width: 16px;
      height: 16px;
    }
    
    .historial {
      color: #2D3436;
      padding: 0;
      max-height: 180px;
      overflow-y: auto;
      font-size: 14px;
      border-bottom-left-radius: 8px;
      border-bottom-right-radius: 8px;
    }
    
    .historial-item {
      padding: 6px 8px;
      cursor: pointer;
      border-bottom: 1px solid #e0e0e0;
    }
    
    .historial-item:hover {
      background: #e8f8f3;
    }

    /* Toast notification */
    .toast {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #00B894;
      color: white;
      padding: 10px 14px;
      border-radius: 6px;
      font-size: 14px;
      opacity: 0.9;
      animation: fadeout 2s forwards;
      z-index: 1000;
    }
    
    @keyframes fadeout {
      0% { opacity: 1; }
      80% { opacity: 0.9; }
      100% { opacity: 0; }
    }

    @keyframes popIn {
    0% {
    opacity: 0;
    transform: scale(0.5);
     }
    100% {
    opacity: 1;
    transform: scale(1);
     }
    }

  </style>
</head>
<body>
    <!-- Contenedor principal de la aplicación -->
    <div class="wrap">
    <div class="card">
      <!-- Logo de la aplicación -->
      <div class="logo">
        <img class="logo-img" src="/images/toki-logo.png" alt="TOKI" />
      </div>
      <div class="layout">
        <aside class="sidebar">
          <!-- Panel de navegación -->
          <div class="panel">
            <div id="gallery" class="gallery" aria-label="Pictogramas disponibles"></div>
          </div>
        </aside>
        <div class="main">
          <div class="panel">
            <div id="builder" class="builder" aria-label="Construir frase aquí"></div>
          </div>
          <div class="bar">
            <input id="phrase" class="phrase" type="text" placeholder="La frase aparecerá aquí" readonly />
            <button id="send" class="send" title="Guardar en historial" aria-label="Guardar">💾</button>
          </div>
          <div class="history-container">
            <div class="history-header">
              <h3 class="history-title">Historial de frases</h3>
              <button id="clear-history" class="clear-history" title="Borrar historial" aria-label="Borrar historial">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M3 6h18"></path>
                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                  <line x1="10" y1="11" x2="10" y2="17"></line>
                  <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
              </button>
            </div>
            <div id="historial" class="historial" aria-label="Historial de frases recientes"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>

    

// Lista de categorías y pictogramas disponibles
const CATEGORIES = [
  {
    id: 'personas',
    name: 'Personas y Relaciones',
    pictos: [
      { id: 'abuela', label: 'abuela' },
      { id: 'abuelo', label: 'abuelo' },
      { id: 'amigo', label: 'amigo' },
      { id: 'madre', label: 'madre' },
      { id: 'padre', label: 'padre' },
      { id: 'maestro', label: 'maestro' },
      { id: 'hermana', label: 'hermana' },
      { id: 'hermano', label: 'hermano' },
      { id: 'doctor', label: 'doctor' },
      { id: 'enfermera', label: 'enfermera' },
      { id: 'dentista', label: 'dentista' }
    ]
  },
  {
    id: 'emociones',
    name: 'Emociones y Estados',
    pictos: [
      { id: 'feliz', label: 'feliz' },
      { id: 'triste', label: 'triste' },
      { id: 'enojado', label: 'enojado' },
      { id: 'nervioso', label: 'nervioso' },
      { id: 'sorpresa', label: 'sorpresa' },
      { id: 'reir', label: 'reir' },
      { id: 'llorar', label: 'llorar' },
      { id: 'miedo', label: 'miedo' },
      { id: 'cansado', label: 'cansado' },
      { id: 'hambre', label: 'hambre' },
      { id: 'sed', label: 'sed' },
      { id: 'dolor', label: 'dolor' },
      { id: 'fiebre', label: 'fiebre' }
    ]
  },
  {
    id: 'acciones',
    name: 'Acciones Diarias',
    pictos: [
      { id: 'abrir', label: 'abrir' },
      { id: 'cerrar', label: 'cerrar' },
      { id: 'agarrar', label: 'agarrar' },
      { id: 'caminar', label: 'caminar' },
      { id: 'correr', label: 'correr' },
      { id: 'saltar', label: 'saltar' },
      { id: 'tomar', label: 'tomar' },
      { id: 'beber', label: 'beber' },
      { id: 'comer', label: 'comer' },
      { id: 'cocinar', label: 'cocinar' },
      { id: 'despertar', label: 'despertar' },
      { id: 'dormir', label: 'dormir' },
      { id: 'lavar_manos', label: 'lavar manos' },
      { id: 'lavar_dientes', label: 'lavar dientes' },
      { id: 'limpiar', label: 'limpiar' },
      { id: 'hablar', label: 'hablar' },
      { id: 'escuchar', label: 'escuchar' },
      { id: 'mirar', label: 'mirar' },
      { id: 'ver', label: 'ver' },
      { id: 'escribir', label: 'escribir' },
      { id: 'dibujar', label: 'dibujar' },
      { id: 'estudiar', label: 'estudiar' },
      { id: 'trabajar', label: 'trabajar' },
      { id: 'jugar', label: 'jugar' },
      { id: 'venir', label: 'regresar' },
      { id: 'ir', label: 'ir' }
    ]
  },
  {
    id: 'lugares',
    name: 'Lugares y Espacios',
    pictos: [
      { id: 'casa', label: 'casa' },
      { id: 'cocina', label: 'cocina' },
      { id: 'dormitorio', label: 'dormitorio' },
      { id: 'escuela', label: 'escuela' },
      { id: 'biblioteca', label: 'biblioteca' },
      { id: 'ciudad', label: 'ciudad' },
      { id: 'parque', label: 'parque' },
      { id: 'playa', label: 'playa' },
      { id: 'restaurante', label: 'restaurante' },
      { id: 'hospital', label: 'hospital' },
      { id: 'farmacia', label: 'farmacia' },
      { id: 'supermercado', label: 'supermercado' }
    ]
  },
  {
    id: 'objetos',
    name: 'Objetos y Alimentos',
    pictos: [
      { id: 'agua', label: 'agua' },
      { id: 'leche', label: 'leche' },
      { id: 'pan', label: 'pan' },
      { id: 'fruta', label: 'fruta' },
      { id: 'comida', label: 'comida' },
      { id: 'desayuno', label: 'desayuno' },
      { id: 'almuerzo', label: 'almuerzo' },
      { id: 'cena', label: 'cena' },
      { id: 'libro', label: 'libro' },
      { id: 'computadora', label: 'computadora' },
      { id: 'diccionario', label: 'diccionario' },
      { id: 'medicina', label: 'medicina' },
      { id: 'pastilla', label: 'pastilla' },
      { id: 'termometro', label: 'termometro' }
    ]
  },
  {
    id: 'actividades',
    name: 'Actividades Específicas',
    pictos: [
      { id: 'arte', label: 'arte' },
      { id: 'ciencias', label: 'ciencias' },
      { id: 'matematicas', label: 'matemáticas' },
      { id: 'caminar', label: 'caminar' },
      { id: 'bailar', label: 'bailar' },
      { id: 'trabajar', label: 'trabajar' },
      { id: 'vacuna', label: 'vacuna' },
      { id: 'baño', label: 'baño' },
      { id: 'higiene', label: 'bañarme' }
    ]
  }
];

// Create a flat array of all pictos for backward compatibility
// Lista plana de todos los pictogramas
const PICTOS = CATEGORIES.flatMap(category => category.pictos);

// Extensiones de imagen soportadas
const PIC_EXTS = ['png','gif','jpg','jpeg','webp','svg'];

// Función para cargar imágenes con manejo de errores
function loadImgWithFallback(imgEl, id, onOk, onFail) {
      let i = 0;
      function tryNext() {
        if (i >= PIC_EXTS.length) { onFail?.(); return; }
        imgEl.src = `/pictos/${id}.` + PIC_EXTS[i++];
      }
      imgEl.onload = () => { onOk?.(); };
      imgEl.onerror = tryNext;
      tryNext();
    }

    const gallery = document.getElementById('gallery');
    const builder = document.getElementById('builder');
    const phraseInput = document.getElementById('phrase');

    // Función para mostrar los pictogramas en la galería
    function renderGallery() {
      gallery.innerHTML = '';
      
      // Add a container for the categories
      const categoriesContainer = document.createElement('div');
      categoriesContainer.className = 'categories-container';
      
      // Track the total number of pictos for animation delay
      let totalPictos = 0;
      
      // Create a section for each category
      CATEGORIES.forEach(category => {
        if (category.pictos.length === 0) return;
        
        // Create category section
        const section = document.createElement('div');
        section.className = 'gallery-section';
        
        // Add category separator
        const separator = document.createElement('div');
        separator.className = 'category-separator';
        separator.textContent = category.name;
        section.appendChild(separator);
        
        // Create a row for the pictos in this category
        const row = document.createElement('div');
        row.className = 'pictos-row';
        
        // Add each picto to the row
        category.pictos.forEach((p, index) => {
          const el = document.createElement('div');
          el.className = 'picto';
          el.draggable = true;
          el.dataset.pictoId = p.id;
          
          // Set animation delay based on the total number of pictos
          el.style.animationDelay = `${totalPictos * 0.03}s`;
          totalPictos++;
          
          // Create image element
          const img = document.createElement('img');
          img.className = 'picto-img';
          img.alt = p.label;
          
          // Create label element
          const label = document.createElement('div');
          label.className = 'picto-label';
          label.textContent = p.label;
          
          // Set up image loading
          loadImgWithFallback(
            img, 
            p.id, 
            () => { 
              img.style.display = 'block';
            }, 
            () => {
              // If image fails to load, we'll just show the label
              img.style.display = 'none';
            }
          );
          
          // Assemble the picto element
          el.appendChild(img);
          el.appendChild(label);
          
          // Add drag handlers
          attachDragHandlers(el);
          
          // Add to the row
          row.appendChild(el);
        });
        
        // Add the row to the section
        section.appendChild(row);
        
        // Add the section to the container
        categoriesContainer.appendChild(section);
      });
      
      // Add the categories container to the gallery
      gallery.appendChild(categoriesContainer);
    }

    // Crea un nuevo elemento de token arrastrable
function createToken(picto) {
      const t = document.createElement('div');
      t.className = 'token';
      t.draggable = true;
      t.dataset.pictoId = picto.id;
      
      const img = document.createElement('img');
      img.className = 'img';
      img.alt = picto.label;
      
      // Set up image loading
      loadImgWithFallback(
        img, 
        picto.id, 
        () => { 
          img.style.display = 'block';
        }, 
        () => {
          // If image fails to load, we'll just show the label
          img.style.display = 'none';
        }
      );
      
      const text = document.createElement('span');
      text.textContent = picto.label;
      
      // Add elements to token
      t.appendChild(img);
      t.appendChild(text);
      
      // Add drag handlers
      attachDragHandlers(t);
      
      // Add double-click to remove
      t.addEventListener('dblclick', () => { 
        t.remove(); 
        updatePhrase(); 
      });
      
      return t;
    }

    // Añade los manejadores de eventos de arrastrar y soltar
function attachDragHandlers(el) {
      el.addEventListener('dragstart', (e) => {
        e.dataTransfer.setData('text/plain', el.dataset.pictoId);
        e.dataTransfer.effectAllowed = 'copyMove';
        setTimeout(() => el.classList.add('removing'), 0);
      });
      el.addEventListener('dragend', () => el.classList.remove('removing'));
    }

    function allowDropZone(zone) {
    zone.addEventListener('dragover', (e) => {
        e.preventDefault();
        zone.classList.add('droppable');
        e.dataTransfer.dropEffect = 'copyMove';
    });

    zone.addEventListener('dragleave', () => zone.classList.remove('droppable'));

    zone.addEventListener('drop', (e) => {
        e.preventDefault();
        zone.classList.remove('droppable');

        // --- ¡CAMBIO CLAVE AQUÍ! ---
        // 1. Limpiamos el panel constructor ANTES de añadir nada
        zone.innerHTML = '';

        const id = e.dataTransfer.getData('text/plain');
        const picto = PICTOS.find(p => p.id === id);
        if (!picto) return;

        const token = createToken(picto);

        // 2. Añadimos solo el nuevo pictograma
        zone.appendChild(token);

        updatePhrase(); // Actualizamos la frase
    });
    }



    function builderSequence() {
          return [...builder.querySelectorAll('.token')].map(t => t.dataset.pictoId);
    }

/* --- PEGA ESTA FUNCIÓN CORREGIDA --- */

function updatePhrase() {
  const seq = builderSequence();

  // Si no hay pictograma, limpia el input
  if (seq.length === 0) {
    phraseInput.value = '';
    return;
  }

  const id = seq[0]; // Obtenemos el único ID
  const picto = PICTOS.find(p => p.id === id);
  if (!picto) return;

  let phrase = '';
  const label = picto.label; // Ej: "lavar manos"

  // --- Súper Lógica de Frases ---
  // Usamos un "switch" para manejar todos los casos especiales.
  // Todo lo que NO esté aquí, usará la regla "Quiero [label]" por defecto.

  switch (id) {
    // --- Categoría: ESTOY (Emociones/Estados) ---
    case 'feliz':
    case 'triste':
    case 'enojado':
    case 'nervioso':
    case 'cansado':
      phrase = `Estoy ${label}`;
      break;

    case 'sorpresa':
      phrase = 'Estoy sorprendido/a';
      break;

    case 'reir':
      phrase = 'Estoy riendo';
      break;

    case 'llorar':
      phrase = 'Estoy llorando';
      break;

    // --- Categoría: TENGO (Sensaciones/Síntomas) ---
    case 'miedo':
    case 'dolor':
    case 'fiebre':
    case 'tos':
    case 'hambre':
    case 'sed':
      phrase = `Tengo ${label}`;
      break;

    // --- Categoría: QUIERO (Acciones) ---
    case 'bailar':
    case 'caminar':
    case 'cocinar':
    case 'despertar':
    case 'dibujar':
    case 'escribir':
    case 'estudiar':
    case 'jugar':
    case 'leer':
    case 'trabajar':
      phrase = `Quiero ${label}`;
      break;

    // --- Categoría: QUIERO VER (Personas) ---
    case 'abuela':
    case 'abuelo':
    case 'amigo':
    case 'hermana':
    case 'hermano':
    case 'madre':
    case 'maestro':
      phrase = `Quiero ver a mi ${label}`;
      break;
    case 'padre':
      phrase = 'Quiero ver a mi papá';
      break;

    // --- Categoría: OBJETOS/CONCEPTOS ---
    case 'arte':
      phrase = 'Quiero hacer arte';
      break;
    case 'ciencias':
    case 'matematicas':
      phrase = `Quiero aprender ${label}`;
      break;
    case 'computadora':
    case 'diccionario':
      const article = id === 'computadora' ? 'la' : 'el';
      phrase = `Quiero usar ${article} ${label}`;
      break;
    case 'libro':
      phrase = 'Quiero un libro';
      break;

    // --- Categoría: LUGARES ---
    case 'casa':
      phrase = 'Quiero ir a casa';
      break;
    case 'cocina':
    case 'biblioteca':
    case 'ciudad':
    case 'dormitorio':
    case 'escuela':
    case 'farmacia':
    case 'hospital':
    case 'parque':
    case 'playa':
    case 'restaurante':
    case 'supermercado':
      const preposition = id === 'cocina' || id === 'ciudad' ? 'a la' : 
                         id === 'escuela' || id === 'farmacia' || id === 'playa' ? 'a la' :
                         'al';
      phrase = `Quiero ir ${preposition} ${label}`;
      break;

    // --- Categoría: QUIERO (Casos Especiales) ---
    case 'desayuno':
      phrase = 'Quiero desayunar';
      break;
    case 'almuerzo':
      phrase = 'Quiero almorzar';
      break;

    case 'cena':
      phrase = 'Quiero cenar';
      break;

    case 'baño':
      phrase = 'Quiero ir al baño';
      break;

    case 'lavar_manos':
      phrase = 'Quiero lavarme las manos';
      break;

    case 'lavar_dientes':
      phrase = 'Quiero lavarme los dientes';
      break;

    case 'doctor':
      phrase = 'Quiero ir al doctor';
      break;

    case 'dentista':
      phrase = 'Quiero ir al dentista';
      break;

    case 'enfermera':
      phrase = 'Quiero ver a la enfermera';
      break;

    case 'pastilla':
      phrase = 'Quiero una pastilla';
      break;

    case 'quiero':
      phrase = 'Quiero algo'; // Para evitar "Quiero quiero"
      break;

    case 'termometro':
      phrase = 'Me siento mal, tengo calentura';
      break;

    case 'vacuna':
      phrase = 'Quiero vacunarme';
      break;

    // --- Caso por Defecto (El resto) ---
    // 'agua', 'beber', 'tomar', 'comer', 'pan', 'fruta', 'leche',
    // 'ir', 'venir', 'abrir', 'cerrar', 'agarrar', 'dar', 'limpiar',
    // 'dormir', 'ver', 'mirar', 'escuchar', 'hablar', 'correr', 'saltar',
    // 'termometro', 'medicina', 'vacuna'
    default:
      phrase = `Quiero ${label}`;
  }

  // Ponemos la primera letra en mayúscula
  phraseInput.value = phrase.charAt(0).toUpperCase() + phrase.slice(1);
}
    document.getElementById('send').addEventListener('click', () => {
      const text = phraseInput.value.trim();
      if (!text) return;
      alert(text);
    });

    // Initialize the app
    renderGallery();
    allowDropZone(builder);
    renderHistorial(); // Load history on page load
    
    // Set up the save button
    document.getElementById('send').onclick = guardarFrase;
    
    // Set up the clear history button
    document.getElementById('clear-history').addEventListener('click', () => {
      if (confirm('¿Estás seguro de que deseas borrar todo el historial de frases?')) {
        localStorage.removeItem('toki_historial');
        renderHistorial();
        showToast('Historial borrado');
      }
    });
    
    // Function to save a phrase to history
    function guardarFrase() {
        const frase = phraseInput.value.trim();
        if (!frase) return;

        let historial = JSON.parse(localStorage.getItem("toki_historial")) || [];
        
        // Remove if already exists to avoid duplicates
        historial = historial.filter(f => f !== frase);
        
        // Add to beginning of array
        historial.unshift(frase);
        
        // Keep only the 15 most recent
        if (historial.length > 15) historial = historial.slice(0, 15);

        localStorage.setItem("toki_historial", JSON.stringify(historial));

        renderHistorial();
        showToast("✓ Frase guardada");
    }
    
    // Function to render the history list
    function renderHistorial() {
        const cont = document.getElementById("historial");
        const historial = JSON.parse(localStorage.getItem("toki_historial")) || [];

        if (historial.length === 0) {
            cont.innerHTML = '<div style="color: #7f8c8d; font-style: italic; padding: 10px; text-align: center;">No hay historial aún</div>';
            return;
        }

        cont.innerHTML = historial.map(f => 
            `<div class="historial-item" onclick="colocarFrase('${f.replace(/'/g, "\\'").replace(/"/g, '&quot;')}')">
                ${f}
            </div>`
        ).join('');
    }
    
    // Function to place a phrase in the input
    function colocarFrase(texto) {
        phraseInput.value = texto;
    }
    
    // Function to show a toast notification
    function showToast(msg) {
        const t = document.createElement("div");
        t.className = "toast";
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 2000);
    }
  </script>
</body>
</html>
