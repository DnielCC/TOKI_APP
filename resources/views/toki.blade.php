<!DOCTYPE html>
<html lang="es">
<head>
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
  animation:
      moveStripes 4s linear infinite, /* ¡Más rápido! */
      scaleBackground 8s ease-in-out infinite alternate;
}    .wrap { min-height: 100vh; display:flex; align-items:center; justify-content:center; padding: 24px; }
    .card { width: min(1100px, 96vw); background: var(--card); border-radius: 14px; padding: 28px; box-shadow: 0 8px 20px rgba(0,0,0,.08); }
    .logo { display:flex; align-items:center; justify-content:center; gap: 8px; margin-bottom: 18px; }
    .logo-badge { display: none; }
    .logo-img { height: 96px; width: auto; object-fit: contain; }
    .logo-title { font-weight: 800; font-size: 28px; letter-spacing: 1px; color: #2e6f73; text-shadow: 0 1px 0 #fff; text-transform: uppercase; }
    .layout { display:flex; gap: 20px; align-items: stretch; }
    .main { flex: 1; display:flex; flex-direction: column; gap: 16px; }
    .sidebar { width: 360px; max-width: 38vw; }
    .panel { background: var(--white); border-radius: 14px; min-height: 140px; padding: 16px; }
    .panel + .panel { margin-top: 0; }
    .sidebar .panel { height: 100%; max-height: 560px; overflow: auto; }
    .gallery { display:grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .picto {
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction: column;
    gap: 6px;
    width: 100%;
    height: 100px;
    border-radius: 12px;
    background:#f5f5f5;
    border:2px solid #e5e5e5;
    cursor: grab;
    user-select: none;
    overflow:hidden;

    /* --- LÍNEAS MODIFICADAS/AÑADIDAS --- */
    opacity: 0; /* Empieza invisible */
    animation: popIn 0.4s ease-out forwards; /* 'forwards' lo mantiene visible */
    }
    .picto:active { cursor: grabbing; }
    .picto-emoji { font-size: 36px; line-height: 1; }
    .picto-label { font-size: 13px; color:#333; }
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

    @keyframes moveStripes {
        0% { background-position: 0 0; }
        100% { background-position: 200px 200px; } /* Mueve más rápido y en diagonal */
    }
    @keyframes scaleBackground {
    0% { transform: scale(1); }
    100% { transform: scale(1.05); } /* Crece ligeramente */
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
  <div class="wrap">
    <div class="card">
      <div class="logo">
        <img class="logo-img" src="/images/toki-logo.png" alt="TOKI" />
      </div>
      <div class="layout">
        <div class="main">
          <div class="panel">
            <div id="builder" class="builder" aria-label="Construir frase aquí"></div>
          </div>
          <div class="bar">
            <input id="phrase" class="phrase" type="text" placeholder="La frase aparecerá aquí" readonly />
            <button id="send" class="send" title="Decir/Enviar" aria-label="Enviar">📨</button>
          </div>
        </div>
        <aside class="sidebar">
          <div class="panel">
            <div id="gallery" class="gallery" aria-label="Pictogramas disponibles"></div>
          </div>
        </aside>
      </div>
    </div>
  </div>
  <script>
    const PIC_IDS = [
      'agua','beber','tomar','comer','pan','fruta',
      'desayuno','almuerzo','cena','leche',
      'ir','venir','abrir','cerrar','agarrar','dar',
      'doctor','dentista','enfermera',
      'baño','higiene','lavar_manos','lavar_dientes','limpiar',
      'dormir','ver','mirar','escuchar','hablar','correr','saltar',
      'feliz','triste','enojado','llorar','reir','miedo','nervioso','cansado','sorpresa',
      'dolor','fiebre','tos','termometro','medicina','pastilla','vacuna','hambre','sed'
    ];
    function makePicto(id, emoji='🖼️') { return { id, label: id.replace(/_/g,' '), emoji }; }
    const PICTOS = PIC_IDS.map(id => makePicto(id));

    const PIC_EXTS = ['png','gif','jpg','jpeg','webp','svg'];
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

    function renderGallery() {
      gallery.innerHTML = '';
PICTOS.forEach((p, index) => { // <-- Añade (p, index)
        const el = document.createElement('div');
        el.className = 'picto';
        el.draggable = true;
        el.dataset.pictoId = p.id;
        const img = document.createElement('img');
        img.className = 'picto-img';
        img.alt = p.label;
        loadImgWithFallback(img, p.id, () => { img.style.display = 'block'; emoji.style.display = 'none'; }, () => { img.style.display = 'none'; emoji.style.display = 'block'; });
        const emoji = document.createElement('div');
        emoji.className = 'picto-emoji';
        emoji.textContent = p.emoji;
        const label = document.createElement('div');
        label.className = 'picto-label';
        label.textContent = p.label;
        // handlers set in loadImgWithFallback
        el.style.animationDelay = `${index * 0.03}s`;
        el.appendChild(img);
        el.appendChild(emoji);
        el.appendChild(label);
        attachDragHandlers(el);
        gallery.appendChild(el);
      });
    }

    function createToken(picto) {
      const t = document.createElement('div');
      t.className = 'token';
      t.draggable = true;
      t.dataset.pictoId = picto.id;
      const img = document.createElement('img');
      img.className = 'img';
      img.alt = picto.label;
      loadImgWithFallback(img, picto.id, () => { img.style.display = 'block'; em.style.display = 'none'; }, () => { img.style.display = 'none'; em.style.display = 'inline'; });
      const em = document.createElement('span');
      em.className = 'emoji';
      em.textContent = picto.emoji;
      const text = document.createElement('span');
      text.textContent = picto.label;
      // handlers set in loadImgWithFallback
      t.appendChild(img);
      t.appendChild(em);
      t.appendChild(text);
      attachDragHandlers(t);
      t.addEventListener('dblclick', () => { t.remove(); updatePhrase(); });
      return t;
    }

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

    renderGallery();
    allowDropZone(builder);
  </script>
</body>
</html>
