<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Interacción con Modelo 3D</title>
  <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      height: 100vh;
      margin: 0;
      background-color: #f0f0f0;
    }

    model-viewer {
      width: 100%;
      max-width: 800px;
      height: 600px;
    }

    #info {
      position: absolute;
      top: 10px;
      right: 10px;
      padding: 10px;
      background: rgba(0, 0, 0, 0.8);
      color: #fff;
      border-radius: 8px;
      display: none;
      width: 250px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
      cursor: grab;
    }

    .comic-button {
      margin-top: 20px;
      padding: 10px 20px;
      font-size: 24px;
      font-weight: bold;
      color: #fff;
      background-color: #ff5252;
      border: 2px solid #000;
      border-radius: 10px;
      box-shadow: 5px 5px 0px #000;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .comic-button:hover {
      background-color: #fff;
      color: #ff5252;
      border: 2px solid #ff5252;
      box-shadow: 5px 5px 0px #ff5252;
    }

    .comic-button:active {
      background-color: #fcf414;
      box-shadow: none;
      transform: translateY(4px);
    }
  </style>
</head>
<body>
  <model-viewer 
    id="viewer" 
    src="./../models/nike_dunk_low_retro_black.glb" 
    alt="Un modelo 3D" 
    auto-rotate 
    camera-controls 
    ar>
  </model-viewer>

  <div id="info">Selecciona una parte del modelo para ver más información.</div>

  <a href="inicio.php" class="comic-button">Regresar</a>

  <script>
    const viewer = document.getElementById('viewer');
    const info = document.getElementById('info');

    // Partes definidas del modelo con descripciones
    const partesModelo = [
      {
        nombre: 'Suela',
        descripcion: 'Material resistente al desgaste, diseñado para un mejor agarre.',
        rango: { x: [-0.5, 0.5], y: [-1, -0.5], z: [-0.5, 0.5] }
      },
      {
        nombre: 'Parte Superior',
        descripcion: 'Material ligero y transpirable para mayor comodidad.',
        rango: { x: [-0.5, 0.5], y: [0, 1], z: [-0.5, 0.5] }
      }
    ];

    // Mostrar información
    function showInfo(parte) {
      info.style.display = 'block';
      info.innerHTML = `
        <p><strong>${parte.nombre}</strong></p>
        <p>${parte.descripcion}</p>
      `;
    }

    // Hacer movible el cuadro de información
    info.onmousedown = function(event) {
      info.style.position = 'absolute';
      let shiftX = event.clientX - info.getBoundingClientRect().left;
      let shiftY = event.clientY - info.getBoundingClientRect().top;

      function moveAt(pageX, pageY) {
        info.style.left = pageX - shiftX + 'px';
        info.style.top = pageY - shiftY + 'px';
      }

      document.addEventListener('mousemove', onMouseMove);

      function onMouseMove(event) {
        moveAt(event.pageX, event.pageY);
      }

      document.onmouseup = function() {
        document.removeEventListener('mousemove', onMouseMove);
        document.onmouseup = null;
      };
    };

    info.ondragstart = () => false;

    // Detectar clics en el modelo
    viewer.addEventListener('click', async (event) => {
      const rect = viewer.getBoundingClientRect();
      const x = event.clientX - rect.left;
      const y = event.clientY - rect.top;

      try {
        const intersection = await viewer.positionAndNormalFromPoint(x, y);
        if (intersection) {
          const { position } = intersection;
          console.log(`Coordenadas: x=${position.x}, y=${position.y}, z=${position.z}`);

          // Verificar qué parte del modelo fue clicada
          const parte = partesModelo.find(p =>
            position.x >= p.rango.x[0] && position.x <= p.rango.x[1] &&
            position.y >= p.rango.y[0] && position.y <= p.rango.y[1] &&
            position.z >= p.rango.z[0] && position.z <= p.rango.z[1]
          );

          if (parte) {
            showInfo(parte);
          } else {
            showInfo({ nombre: 'Sin información', descripcion: 'No hay detalles disponibles para esta área.' });
          }
        } else {
          console.warn('Haz clic fuera del modelo.');
        }
      } catch (error) {
        console.error('Error al detectar intersección:', error);
      }
    });

    // Ocultar información al mover el mouse fuera del modelo
    viewer.addEventListener('mouseleave', () => {
      info.style.display = 'none';
    });
  </script>
</body>
</html>
