<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TOKI</title>
  <link rel="stylesheet" href="/static/toki.css" />
  <script src="/static/tj.js" defer></script>
</head>
<body>
    <div class="wrap">
    <div class="card">
      <div class="logo">
        <img class="logo-img" src="/images/toki-logo.png" alt="TOKI" />
      </div>
      <div class="layout">
        <aside class="sidebar">
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
</body>
</html>
