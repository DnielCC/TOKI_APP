<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TOKI</title>
  <style>
    :root { --sky:#cfeefb; --card:#fdeaa6; --white:#ffffff; --green:#99e2a1; --text:#2a2a2a; }
    * { box-sizing: border-box; }
    body { margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji"; color: var(--text); background: var(--sky); }
    .wrap { min-height: 100vh; display:flex; align-items:center; justify-content:center; padding: 24px; }
    .card { width: min(1100px, 96vw); background: var(--card); border-radius: 14px; padding: 28px; box-shadow: 0 8px 20px rgba(0,0,0,.08); }
    .logo { display:flex; align-items:center; justify-content:center; margin-bottom: 14px; }
    .logo-badge { width: 56px; height: 56px; border-radius: 50%; background: #86d7f7; display:flex; align-items:center; justify-content:center; margin-right: 8px; font-size: 28px; }
    .logo-title { font-weight: 800; font-size: 28px; letter-spacing: 1px; color: #2e6f73; text-shadow: 0 1px 0 #fff; }
    .panel { background: var(--white); border-radius: 14px; min-height: 140px; padding: 14px; }
    .panel + .panel { margin-top: 16px; }
    .gallery { display:flex; flex-wrap: wrap; gap: 12px; }
    .picto { display:flex; align-items:center; justify-content:center; flex-direction: column; gap: 6px; width: 96px; height: 96px; border-radius: 12px; background:#f5f5f5; border:2px solid #e5e5e5; cursor: grab; user-select: none; }
    .picto:active { cursor: grabbing; }
    .picto-emoji { font-size: 36px; line-height: 1; }
    .picto-label { font-size: 13px; color:#333; }
    .builder { display:flex; flex-wrap: wrap; gap: 12px; min-height: 120px; align-content:flex-start; }
    .token { display:flex; align-items:center; justify-content:center; gap:6px; padding: 10px 14px; border-radius: 999px; background:#f5f5f5; border:2px dashed #d7d7d7; cursor: grab; user-select:none; }
    .token .emoji { font-size: 22px; }
    .token.removing { opacity:.5; }
    .bar { display:flex; align-items:center; gap:12px; margin-top: 16px; }
    .phrase { flex:1; height: 48px; border-radius: 999px; border:none; padding: 0 16px; background: var(--white); box-shadow: inset 0 0 0 2px rgba(0,0,0,.06); font-size: 16px; }
    .send { width: 44px; height: 44px; border-radius: 50%; border:none; background: var(--green); display:flex; align-items:center; justify-content:center; cursor: pointer; box-shadow: 0 2px 0 rgba(0,0,0,.08); }
    .droppable { outline: 3px dashed #a7d6ff; outline-offset: -6px; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <div class="logo">
        <div class="logo-badge">💬</div>
        <div class="logo-title">TOKI</div>
      </div>
      <div class="panel">
        <div id="gallery" class="gallery" aria-label="Pictogramas disponibles"></div>
      </div>
      <div class="panel">
        <div id="builder" class="builder" aria-label="Construir frase aquí"></div>
      </div>
      <div class="bar">
        <input id="phrase" class="phrase" type="text" placeholder="La frase aparecerá aquí" readonly />
        <button id="send" class="send" title="Decir/Enviar" aria-label="Enviar">📨</button>
      </div>
    </div>
  </div>
  <script>
    const PICTOS = [
      { id: 'boca', label: 'boca', emoji: '👄' },
      { id: 'agua', label: 'agua', emoji: '💧' },
      { id: 'quiero', label: 'quiero', emoji: '👉' },
      { id: 'tomar', label: 'tomar', emoji: '🥤' },
      { id: 'comer', label: 'comer', emoji: '🍽️' },
      { id: 'pan', label: 'pan', emoji: '🍞' }
    ];

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
        el.innerHTML = `<div class="picto-emoji">${p.emoji}</div><div class="picto-label">${p.label}</div>`;
        attachDragHandlers(el);
        gallery.appendChild(el);
      });
    }

    function createToken(picto) {
      const t = document.createElement('div');
      t.className = 'token';
      t.draggable = true;
      t.dataset.pictoId = picto.id;
      t.innerHTML = `<span class="emoji">${picto.emoji}</span><span>${picto.label}</span>`;
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
        const id = e.dataTransfer.getData('text/plain');
        const picto = PICTOS.find(p => p.id === id);
        if (!picto) return;
        const after = getDragAfterElement(zone, e.clientX, e.clientY);
        const token = createToken(picto);
        if (after == null) zone.appendChild(token); else zone.insertBefore(token, after);
        updatePhrase();
      });
    }

    function getDragAfterElement(container, x, y) {
      const elements = [...container.querySelectorAll('.token:not(.removing)')];
      return elements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = Math.hypot(x - (box.left + box.width/2), y - (box.top + box.height/2));
        if (offset < closest.offset) return { offset, element: child };
        return closest;
      }, { offset: Number.POSITIVE_INFINITY, element: null }).element;
    }

    function builderSequence() {
      return [...builder.querySelectorAll('.token')].map(t => t.dataset.pictoId);
    }

    function updatePhrase() {
      const seq = builderSequence();
      let out = seq.map(id => PICTOS.find(p => p.id === id)?.label || id).join(' ');
      const has = id => seq.includes(id);
      if (has('boca') && has('agua')) {
        out = 'quiero tomar agua';
      }
      phraseInput.value = out.trim();
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
