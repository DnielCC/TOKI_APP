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
  animation: moveStripes 8s linear infinite;
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
    .picto { display:flex; align-items:center; justify-content:center; flex-direction: column; gap: 6px; width: 100%; height: 100px; border-radius: 12px; background:#f5f5f5; border:2px solid #e5e5e5; cursor: grab; user-select: none; overflow:hidden; }
    .picto:active { cursor: grabbing; }
    .picto-emoji { font-size: 36px; line-height: 1; }
    .picto-label { font-size: 13px; color:#333; }
    .picto-img { width: 56px; height: 56px; object-fit: contain; display:none; }
    .builder { display:flex; flex-wrap: wrap; gap: 12px; min-height: 200px; align-content:flex-start; }
    .token { display:flex; align-items:center; justify-content:center; gap:6px; padding: 10px 14px; border-radius: 999px; background:#f5f5f5; border:2px dashed #d7d7d7; cursor: grab; user-select:none; }
    .token .emoji { font-size: 22px; }
    .token .img { width: 24px; height: 24px; object-fit: contain; display:none; }
    .token.removing { opacity:.5; }
    .bar { display:flex; align-items:center; gap:12px; margin-top: 16px; }
    .phrase { flex:1; height: 48px; border-radius: 999px; border:none; padding: 0 16px; background: var(--white); box-shadow: inset 0 0 0 2px rgba(0,0,0,.06); font-size: 16px; }
    .send { width: 44px; height: 44px; border-radius: 50%; border:none; background: var(--green); display:flex; align-items:center; justify-content:center; cursor: pointer; box-shadow: 0 2px 0 rgba(0,0,0,.08); }
    .droppable { outline: 3px dashed #a7d6ff; outline-offset: -6px; }
    @keyframes moveStripes {
    0% {
        background-position: 0 0;
    }
    100% {
        background-position: 100px 100px; /* Debe coincidir con background-size */
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
      'agua','beber','tomar','comer','comida','pan','fruta',
      'desayuno','almuerzo','cena','leche',
      'quiero','ir','venir','abrir','cerrar','agarrar','dar',
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
      PICTOS.forEach(p => {
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

    function updatePhrase() {
  const seq = builderSequence(); // Esto ahora tendrá 0 o 1 elemento

  // Si el panel está vacío, limpia el input
  if (seq.length === 0) {
    phraseInput.value = '';
    return;
  }

  const id = seq[0]; // Obtenemos el único ID del pictograma
  const picto = PICTOS.find(p => p.id === id);
  if (!picto) return;

  let phrase = '';
  const label = picto.label;

  // --- ¡ESTA ES LA LÓGICA DE FRASES! ---
  // Definimos categorías para frases personalizadas
  const estados = ['feliz','triste','enojado','llorar','reir','miedo','nervioso','cansado','sorpresa'];
  const sintomas = ['dolor','fiebre','tos','hambre','sed'];
  const higiene = ['lavar_manos', 'lavar_dientes'];

  // Lógica para crear la frase
  if (estados.includes(id)) {
    phrase = `Estoy ${label}`;
  }
  else if (sintomas.includes(id)) {
    phrase = `Tengo ${label}`;
  }
  else if (higiene.includes(id)) {
    // "lavar manos" -> "lavarme las manos"
    phrase = `Quiero ${label.replace('lavar','lavarme')}`;
  }
  else if (id === 'baño') {
    phrase = 'Quiero ir al baño';
  }
  else {
    // La regla por defecto para todo lo demás:
    phrase = `Quiero ${label}`;
  }

  // Ponemos la primera letra en mayúscula y actualizamos el input
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
