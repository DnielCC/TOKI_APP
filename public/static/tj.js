
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

const PICTOS = CATEGORIES.flatMap(category => category.pictos);


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
      
      const categoriesContainer = document.createElement('div');
      categoriesContainer.className = 'categories-container';
      
      let totalPictos = 0;
      
      CATEGORIES.forEach(category => {
        if (category.pictos.length === 0) return;
        
        const section = document.createElement('div');
        section.className = 'gallery-section';
        
        const separator = document.createElement('div');
        separator.className = 'category-separator';
        separator.textContent = category.name;
        section.appendChild(separator);
        
        const row = document.createElement('div');
        row.className = 'pictos-row';
        
        category.pictos.forEach((p, index) => {
          const el = document.createElement('div');
          el.className = 'picto';
          el.draggable = true;
          el.dataset.pictoId = p.id;
          
          el.style.animationDelay = `${totalPictos * 0.03}s`;
          totalPictos++;
          
          const img = document.createElement('img');
          img.className = 'picto-img';
          img.alt = p.label;
          
          const label = document.createElement('div');
          label.className = 'picto-label';
          label.textContent = p.label;
          
          loadImgWithFallback(
            img, 
            p.id, 
            () => { 
              img.style.display = 'block';
            }, 
            () => {
              img.style.display = 'none';
            }
          );
          
          el.appendChild(img);
          el.appendChild(label);
          
          attachDragHandlers(el);
          
          row.appendChild(el);
        });
        
        section.appendChild(row);
        
        categoriesContainer.appendChild(section);
      });
      
      gallery.appendChild(categoriesContainer);
    }

function createToken(picto) {
      const t = document.createElement('div');
      t.className = 'token';
      t.draggable = true;
      t.dataset.pictoId = picto.id;
      
      const img = document.createElement('img');
      img.className = 'img';
      img.alt = picto.label;
      
      loadImgWithFallback(
        img, 
        picto.id, 
        () => { 
          img.style.display = 'block';
        }, 
        () => {
          img.style.display = 'none';
        }
      );
      
      const text = document.createElement('span');
      text.textContent = picto.label;
      
      t.appendChild(img);
      t.appendChild(text);
      
      attachDragHandlers(t);
      
      t.addEventListener('dblclick', () => { 
        t.remove(); 
        updatePhrase(); 
      });
      
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

        zone.innerHTML = '';

        const id = e.dataTransfer.getData('text/plain');
        const picto = PICTOS.find(p => p.id === id);
        if (!picto) return;

        const token = createToken(picto);

        zone.appendChild(token);

        updatePhrase(); 
    });
    }



    function builderSequence() {
          return [...builder.querySelectorAll('.token')].map(t => t.dataset.pictoId);
    }


function updatePhrase() {
  const seq = builderSequence();

  if (seq.length === 0) {
    phraseInput.value = '';
    return;
  }

  const id = seq[0]; 
  const picto = PICTOS.find(p => p.id === id);
  if (!picto) return;

  let phrase = '';
  const label = picto.label; 


  switch (id) {
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

    case 'miedo':
    case 'dolor':
    case 'fiebre':
    case 'tos':
    case 'hambre':
    case 'sed':
      phrase = `Tengo ${label}`;
      break;

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
      phrase = 'Quiero algo'; 
      break;

    case 'termometro':
      phrase = 'Me siento mal, tengo calentura';
      break;

    case 'vacuna':
      phrase = 'Quiero vacunarme';
      break;

    default:
      phrase = `Quiero ${label}`;
  }

  phraseInput.value = phrase.charAt(0).toUpperCase() + phrase.slice(1);
}
    document.getElementById('send').addEventListener('click', () => {
      const text = phraseInput.value.trim();
      if (!text) return;
      alert(text);
    });

    renderGallery();
    allowDropZone(builder);
    renderHistorial(); 
    
    document.getElementById('send').onclick = guardarFrase;
    
    document.getElementById('clear-history').addEventListener('click', () => {
      if (confirm('¿Estás seguro de que deseas borrar todo el historial de frases?')) {
        localStorage.removeItem('toki_historial');
        renderHistorial();
        showToast('Historial borrado');
      }
    });
    
    function guardarFrase() {
        const frase = phraseInput.value.trim();
        if (!frase) return;

        let historial = JSON.parse(localStorage.getItem("toki_historial")) || [];
        
        historial = historial.filter(f => f !== frase);
        
        historial.unshift(frase);
        
        if (historial.length > 15) historial = historial.slice(0, 15);

        localStorage.setItem("toki_historial", JSON.stringify(historial));

        renderHistorial();
        showToast("✓ Frase guardada");
    }
    
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
    
    function colocarFrase(texto) {
        phraseInput.value = texto;
    }
    
    function showToast(msg) {
        const t = document.createElement("div");
        t.className = "toast";
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 2000);
    }
