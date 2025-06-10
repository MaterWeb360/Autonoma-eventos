//Funcion para obtener los utms
function getGET() {
    var loc = document.location.href;
    var getString = loc.split("?")[1];
    if (!getString) return {};
  
    var GET = getString.split("&");
  
    let utms = {
      cUtmSource: "",
      cUtmMedium: "",
      cUtmCampaign: "",
      cGclid: "",
    };
  
    for (var i = 0, l = GET.length; i < l; i++) {
      let utmstring = GET[i];
  
      if (utmstring.includes("utm_source")) {
        var arr = utmstring.split("=");
        utms.cUtmSource = arr.length > 1 ? decodeURIComponent(arr[1]) : "";
      }
  
      if (utmstring.includes("utm_medium")) {
        var arr = utmstring.split("=");
        utms.cUtmMedium = arr.length > 1 ? decodeURIComponent(arr[1]) : "";
      }
  
      if (utmstring.includes("utm_campaign")) {
        var arr = utmstring.split("=");
        utms.cUtmCampaign = arr.length > 1 ? decodeURIComponent(arr[1]) : "";
      }
  
      if (utmstring.includes("gclid")) {
        var arr = utmstring.split("=");
        utms.cGclid = arr.length > 1 ? decodeURIComponent(arr[1]) : "";
      }
    }
  
    return utms;
  }
  $.fn.serializeObject = function () {
    var obj = {};
    var arr = this.serializeArray();
    
    arr.forEach(function (item) {
      // Si el campo ya existe, lo convertimos en un array y agregamos el valor
      if (obj[item.name] === undefined) {
        obj[item.name] = item.value || "";
      } else {
        if (!Array.isArray(obj[item.name])) {
          obj[item.name] = [obj[item.name]];
        }
        obj[item.name].push(item.value || "");
      }
    });
  
    // Aseguramos que los checkboxes y radios no seleccionados también se incluyan
    this.find('input[type="checkbox"], input[type="radio"]').each(function () {
      var name = this.name;
      if (obj[name] === undefined) {
        obj[name] = "";  // Si no está en el objeto, lo agregamos con un valor vacío
      }
    });
    
    // Captura UTM desde la URL y los agrega con los nombres correctos
    var utms = getGET();
  
    obj.cUtmSource = utms.cUtmSource || "";
    obj.cUtmMedium = utms.cUtmMedium || "";
    obj.cUtmCampaign = utms.cUtmCampaign || "";
    obj.cGclid = utms.cGclid || "";
  
    return obj;
  }
  
var camposRequeridos = {
    cKeyAccess: "",
    cCodFormExterno: "",
    cNombres: "",
    cApellidos: "",
    cCelular: "",
    cCorreo: "",
    nTipDocumento: "",
    cDocumento: "",
    nPrograma: "",
    cPrograma: "",
    nSubPrograma: "",
    cSubPrograma: "",
    nModalidad: "",
    cModalidad: "",
    nCarrera: "",
    cCarrera: "",
    cDistrito: "",
    cDepartamento: "",
    cPais: "",
    cProvincia: "",
    cColegio: "",
    cGrado: "",
    cPerCodColegio: "",
    nHorario: "",
    cHorario: "",
    cGenero: "",
    cNacionalidad: "",
    cNombrePadreApo: "",
    cCelPadreApo: "",
    cCorreoPadreApo: "",
    cAnioEgreso: "",
    cTurno: "",
    cOcupacion: "",
    cEmpresa: "",
    cCargo: "",
    cUtmSource: "",
    cUtmMedium: "",
    cUtmCampaign: "",
    cGclid: "",
    cAux1: "",
    cAux2: "",
    cAux3: "",
    cAux4: "",
    cAux5: "",
    cAux6: "",
    cAux7: "",
    cAux8: "",
    cAux9: "",
    cAux10: "",
    cAux11: "",
    cAux12: "",
    cAux13: "",
    cAux14: "",
    cAux15: ""
  };

//Manejo de niveles  
document.addEventListener('DOMContentLoaded', () => {
  const formulario = document.querySelector('form');
  const maxNivel = 4;

  function manejarCambioNivel(nivelActual, nivelHijo) {
    const elementosNivel = formulario.querySelectorAll(`[data-nivel="${nivelActual}"]`);

    elementosNivel.forEach((div) => {
      const select = div.querySelector('select');
      if (!select) return;

      select.addEventListener('change', (e) => {
        const valorSeleccionado = e.target.value;

        // 🔍 Verificamos si este select tiene hijos asociados
        const hijos = formulario.querySelectorAll(`[data-nivel="${nivelHijo}"][data-parent="${valorSeleccionado}"]`);
        const tieneHijos = hijos.length > 0;

        if (!tieneHijos) {
          // 👇 Este nivel no tiene hijos, no toca niveles posteriores
          return;
        }

        // 🔁 Ocultar todos los niveles hijos del actual
        for (let n = nivelHijo; n <= maxNivel; n++) {
          const siguientes = formulario.querySelectorAll(`[data-nivel="${n}"]`);
          siguientes.forEach(el => {
            el.classList.add('oculto');
            const contenedor = el.closest('.form__selects');
            if (contenedor) contenedor.classList.add('oculto');

            const selectInterno = el.querySelector('select');
            if (selectInterno) selectInterno.selectedIndex = 0;
          });
        }

        // 🔓 Mostrar los hijos directos válidos
        hijos.forEach(hijo => {
          hijo.classList.remove('oculto');
          const contenedor = hijo.closest('.form__selects');
          if (contenedor) contenedor.classList.remove('oculto');
        });
      });
    });
  }

  manejarCambioNivel(1, 2);
  manejarCambioNivel(2, 3);
  manejarCambioNivel(3, 4);
});


//manejo de asignacion de names/data-names
document.addEventListener('DOMContentLoaded', () => {
  const todosLosSelects = document.querySelectorAll('select[data-name^="n"]');

  todosLosSelects.forEach(select => {
    select.addEventListener('change', () => {
      const selectedOption = select.options[select.selectedIndex];
      const textoSeleccionado = selectedOption ? selectedOption.text.trim() : '';
      const dataName = select.dataset.name;

      if (!dataName || !dataName.startsWith('n')) return;

      const clave = 'c' + dataName.substring(1);
      const contenedor = select.closest('.form__input-select-wrapper');
      if (!contenedor) return;

      let inputOculto = contenedor.querySelector(`input[name="${clave}"]`) || contenedor.querySelector(`input[data-name="${clave}"]`);
      if (!inputOculto) return;

      // Paso 1: Resetear todos los inputs que tengan el mismo name activo
      const todosLosInputsMismoNombre = document.querySelectorAll(`input[name="${clave}"]`);
      todosLosInputsMismoNombre.forEach(input => {
        input.setAttribute('data-name', clave);
        input.removeAttribute('name');
      });

      // Paso 2: Activar solo el input correspondiente a este select
      inputOculto.setAttribute('name', clave);
      inputOculto.removeAttribute('data-name');
      inputOculto.value = textoSeleccionado;
    });
  });
});


// ✅ Asignar automáticamente name al SELECT desde su data-name
document.addEventListener('DOMContentLoaded', () => {
  const selectsConDataName = document.querySelectorAll('select[data-name]');

  selectsConDataName.forEach(select => {
    select.addEventListener('change', () => {
      const dataNameActual = select.getAttribute('data-name');
      if (!dataNameActual) return;

      // Paso 1: Quitar el name de todos los selects con el mismo data-name
      document.querySelectorAll(`select[name="${dataNameActual}"]`).forEach(otherSelect => {
        if (otherSelect !== select) {
          otherSelect.removeAttribute('name');
          otherSelect.setAttribute('data-name', dataNameActual); // restaurar data-name si se perdió
          console.log(`🧹 Limpiado name en otro SELECT con mismo data-name="${dataNameActual}"`);
        }
      });

      // Paso 2: Asegurar que el select actual tenga el name activo
      select.setAttribute('name', dataNameActual);
      console.log(`✅ Asignado name="${dataNameActual}" al SELECT seleccionado`);
    });
  });
});

//✅ Asignar automático name al input oculto CODFORM
document.addEventListener('DOMContentLoaded', () => {
  const selects = document.querySelectorAll('select[data-name^="n"]');

  selects.forEach(select => {
    select.addEventListener('change', () => {
      const wrapper = select.closest('.form__input-select-wrapper');
      if (!wrapper) return;

      const codFormInput = wrapper.querySelector('input[type="hidden"][data-name="cCodFormExterno"]');
      if (!codFormInput) return;

      // 1. Limpiar cualquier otro input con name activo
      const otrosActivos = document.querySelectorAll('input[name="cCodFormExterno"]');
      otrosActivos.forEach(input => {
        if (input !== codFormInput) {
          input.removeAttribute('name');
          input.setAttribute('data-name', 'cCodFormExterno');
          console.log('🧹 Se limpió otro input oculto con name="cCodFormExterno"');
        }
      });

      // 2. Activar este input
      codFormInput.setAttribute('name', 'cCodFormExterno');
      codFormInput.removeAttribute('data-name');
      console.log('✅ Se activó name="cCodFormExterno" en el input oculto correspondiente');
    });
  });
});

  
//Recopilacion y envio de datos
document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.getElementById('formularioAutonoma');
    //Evento de recoleccion de datos del formulario
    formulario.addEventListener('submit', function (e) {
    e.preventDefault();
    let action = formulario.getAttribute('action');
    let form = $(this);
    let submitButton = form.find('button[type="submit"], input[type="submit"]');
    let datosForm = form.serializeObject();

    let checkboxRequeridosNoMarcados = false;

    const esValido = validarDatos(datosForm,form,submitButton);

    if(esValido){
        submitButton.attr('disabled', 'disabled');
        submitButton.text('Enviando datos...');

        let datosFinales = {};
        for (let key in camposRequeridos) {
            if (datosForm.hasOwnProperty(key)) {
                datosFinales[key] = datosForm[key];
            } else {
                datosFinales[key] = "";
            }
        }

        console.log(datosFinales);
        sendDatos(action, datosFinales);

        // 🔄 RESET sólo después de enviar
        form[0].reset();
    } else {
        console.log('❌ No pasó la validación');
        submitButton.removeAttr('disabled');
    }
});

    //Validacion de datos
    function validarDatos(datos, formulario,submitButton) {
      const errores = [];
      const inputs = formulario[0].querySelectorAll('input[type="text"], input[type="email"], input[type="number"], select, textarea');
      let err = 0;
    
      inputs.forEach(input => {
        const valor = input.value.trim();
        const tipo = input.type;
    
        // Quitar clases previas de error
        input.classList.remove('error-input');
        input.classList.remove('sucess-input');
    
       // Validación de SELECT
        if (input.tagName === 'SELECT') {
          console.log('➡️ Validando un SELECT:', input.name || input.dataset.name);

          const wrapper = input.closest('.form__input-select-wrapper');
          if (!wrapper) {
            console.warn('⚠️ No se encontró el wrapper para el SELECT');
            return;
          }

          const selectedText = input.options[input.selectedIndex].textContent.trim();
          console.log('🔍 Texto seleccionado:', `"${selectedText}"`);
          console.log('🔢 Índice seleccionado:', input.selectedIndex);

          // Ignorar selects ocultos
          if (!input.offsetParent) {
            console.log('⛔ SELECT oculto, se omite la validación.');
            return;
          }

          // Buscar si ya existe el mensaje
          let errorMsg = wrapper.querySelector('.error-message');

          if (!errorMsg) {
            console.log('📌 No existe mensaje de error, creando nuevo elemento <p>');
            errorMsg = document.createElement('p');
            errorMsg.classList.add('error-message', 'selectableWp');
            wrapper.appendChild(errorMsg);
          } else {
            console.log('📎 Ya existe mensaje de error, actualizándolo...');
          }

          const isInvalid =
            !selectedText ||
            selectedText.toLowerCase().includes('tipo') ||
            selectedText.toLowerCase().includes('seleccione') ||
            input.selectedIndex === 0;

          if (isInvalid) {
            console.log(`❌ Error: selección no válida en SELECT "${input.dataset.name}"`);

            wrapper.classList.remove('sucess-input');
            wrapper.classList.add('error-input');
            wrapper.style.marginBottom = '1rem';

            errorMsg.textContent = 'Debe seleccionar una opción';
            errorMsg.style.color = 'red';

            err++;
          } else {
            console.log(`✅ SELECT "${input.dataset.name}" validado correctamente`);

            wrapper.classList.remove('error-input');
            wrapper.classList.add('sucess-input');
            wrapper.style.marginBottom = '1rem';

            errorMsg.textContent = 'Campo validado correctamente';
            errorMsg.style.color = 'green';
          }

          return;
        }
  
       // Función para mostrar mensajes de error debajo del input
        function mostrarError(input, mensaje) {
          const contenedor = input.parentElement;

          // Eliminar mensaje anterior si existe
          const errorExistente = contenedor.querySelector('.error-message');
          if (errorExistente) errorExistente.remove();

          // Crear nuevo mensaje
          const errorMsg = document.createElement('p');
          errorMsg.textContent = mensaje;
          errorMsg.style.color = 'red';
          errorMsg.classList.add('error-message');

          contenedor.appendChild(errorMsg);
          input.classList.add('error-input');
          input.classList.remove('sucess-input');
        }

        // Función para limpiar mensajes de error si está correcto
        function limpiarError(input) {
          const contenedor = input.parentElement;
          const errorExistente = contenedor.querySelector('.error-message');
          if (errorExistente) errorExistente.remove();

          input.classList.add('sucess-input');
          input.classList.remove('error-input');
        }

        // Validación de INPUT tipo TEXT (incluye cDocumento con reglas personalizadas)
        if (tipo === 'text') {
          if (input.name === 'cDocumento') {
            const select = document.querySelector('[data-name="nTipDocumento"]');
            const opcionSeleccionada = select.options[select.selectedIndex].textContent.trim();

            if (valor) {
              if (opcionSeleccionada === 'DNI') {
                if (/^\d{8}$/.test(valor)) {
                  limpiarError(input);
                } else {
                  mostrarError(input, 'El DNI debe contener exactamente 8 dígitos numéricos.');
                  err++;
                }
              } else if (opcionSeleccionada === 'Carnet de extranjería') {
                if (/^[a-zA-Z0-9]{9,}$/.test(valor)) {
                  limpiarError(input);
                } else {
                  mostrarError(input, 'El Carnet de extranjería debe tener al menos 9 caracteres alfanuméricos.');
                  err++;
                }
              } else if (opcionSeleccionada === 'Pasaporte') {
                if (/^[a-zA-Z0-9]{6,}$/.test(valor)) {
                  limpiarError(input);
                } else {
                  mostrarError(input, 'El Pasaporte debe tener al menos 6 caracteres alfanuméricos.');
                  err++;
                }
              }
            } else {
              mostrarError(input, 'Por favor ingresa un número de documento.');
              err++;
            }

            return;
          }

          // Validación texto genérico (solo letras y espacios)
          if (valor) {
            if (!/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(valor)) {
              limpiarError(input);
            } else {
              mostrarError(input, 'Este campo solo permite letras y espacios. No uses números ni caracteres especiales.');
              err++;
            }
          } else {
            mostrarError(input, 'Por favor completa la información.');
            err++;
          }
        }

        // Validación EMAIL
        if (tipo === 'email') {
          if (valor) {
            if (/^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/.test(valor)) {
              limpiarError(input);
            } else {
              mostrarError(input, 'Ingresa un correo electrónico válido. Ejemplo: nombre@dominio.com');
              err++;
            }
          } else {
            mostrarError(input, 'Por favor ingresa tu correo electrónico.');
            err++;
          }
        }

        // Validación NÚMERO (teléfono)
        if (tipo === 'number') {
          if (valor) {
            if (/^9\d{8}$/.test(valor)) {
              limpiarError(input);
            } else {
              mostrarError(input, 'El número debe comenzar con 9 y tener exactamente 9 dígitos.');
              err++;
            }
          } else {
            mostrarError(input, 'Por favor ingresa tu número de teléfono.');
            err++;
          }
        }
        // Validación de TEXTAREA
        if (input.tagName === 'TEXTAREA') {
          // Ignorar textareas ocultos
          if (!input.offsetParent) {
            return;
          }

          const wrapper = input.parentElement; // El div contenedor del textarea
          const esRequerido = input.dataset.requerido === 'required';
          const valor = input.value.trim();

          // Eliminar mensaje de error previo si existe
          const errorExistente = wrapper.querySelector('.error-message');
          if (errorExistente) errorExistente.remove();

          // Limpia clases previas
          input.classList.remove('error-input', 'sucess-input');

          if (esRequerido && valor === '') {
            console.log(`❌ Error en TEXTAREA requerido: ${input.name}`);

            // Crear el mensaje de error
            const errorMsg = document.createElement('p');
            errorMsg.textContent = 'Este campo es obligatorio. Por favor, completa la información.';
            errorMsg.style.color = 'red';
            errorMsg.classList.add('error-message');

            // Insertar el mensaje justo después del textarea
            input.insertAdjacentElement('afterend', errorMsg);

            input.classList.add('error-input');
            err++;
          } else {
            input.classList.add('sucess-input');
          }

          return;
        }
      });
    
      if (err === 0) {
        return true; // Todo validado correctamente
        
      } else {
        console.log(`❌ Validación fallida con ${err} error(es)`);
        return false; // Hubo errores
      }
    }
    //Funcion para envio de datos
    function sendDatos(action,datosForm) {
        //var typ ="http://localhost/autonoma-webinars/gracias/";
        //var typ ="https://autonoma.performlab.co/gracias/";
        var typ ="https://www.autonoma.pe/eventos-autonoma/gracias/";
        jQuery.ajax({
          type: "POST",
          url: action,
          data: JSON.stringify(datosForm),
          contentType: "application/json; charset=utf-8",
          dataType: "json",
          async: false,
          beforeSend: function () {
            jQuery(".error").empty();
          },
          success: function (data) {
            console.log(data);
            //window.location = typ;
          },
          error: function (e) {
            console.log(e, e.response);
          },
        });
      }
  })

 //validacion en tiempo real
document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');
  if (!form) return;

  const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="number"], select, textarea');

  inputs.forEach(input => {
    const tipo = input.type;
    const evento = input.tagName === 'SELECT' ? 'change' : 'input';

    const mostrarError = (mensaje) => {
      const contenedor = input.parentElement;
      const existente = contenedor.querySelector('.error-message');
      if (existente) existente.remove();

      const p = document.createElement('p');
      p.className = 'error-message';
      p.style.color = 'red';
      p.textContent = mensaje;
      contenedor.appendChild(p);

      input.classList.add('error-input');
      input.classList.remove('sucess-input');
    };

    const limpiarError = () => {
      const contenedor = input.parentElement;
      const existente = contenedor.querySelector('.error-message');
      if (existente) existente.remove();

      input.classList.remove('error-input');
      input.classList.add('sucess-input');
    };

    const validarCampo = () => {
      const valor = input.value.trim();

      // Validación SELECT
    if (input.tagName === 'SELECT') {
      const wrapper = input.closest('.form__input-select-wrapper');
      const text = input.options[input.selectedIndex].textContent.trim();

      if (!input.offsetParent || !wrapper) return;

      let errorMsg = wrapper.querySelector('.error-message');

      // Si no existe el mensaje, lo creamos
      if (!errorMsg) {
        errorMsg = document.createElement('p');
        errorMsg.classList.add('error-message', 'selectableWp');
        wrapper.appendChild(errorMsg);
      }

      const isInvalid =
        !text ||
        text.toLowerCase().includes('tipo') ||
        text.toLowerCase().includes('seleccione') ||
        input.selectedIndex === 0;

      if (isInvalid) {
        wrapper.classList.remove('sucess-input');
        wrapper.classList.add('error-input');
        wrapper.style.marginBottom = '1rem';

        errorMsg.textContent = 'Debe seleccionar una opción';
        errorMsg.style.color = 'red';
      } else {
        wrapper.classList.remove('error-input');
        wrapper.classList.add('sucess-input');
        wrapper.style.marginBottom = '1rem'; // mantener el espacio

        errorMsg.textContent = 'Campo validado correctamente';
        errorMsg.style.color = 'green';
      }

      return;
    }


      // TEXT
      if (tipo === 'text') {
        if (input.name === 'cDocumento') {
          const select = document.querySelector('[data-name="nTipDocumento"]');
          const opcion = select.options[select.selectedIndex].textContent.trim();

          if (valor) {
            if (opcion === 'DNI' && /^\d{8}$/.test(valor)) limpiarError();
            else if (opcion === 'Carnet de extranjería' && /^[a-zA-Z0-9]{9,}$/.test(valor)) limpiarError();
            else if (opcion === 'Pasaporte' && /^[a-zA-Z0-9]{6,}$/.test(valor)) limpiarError();
            else mostrarError('Número de documento no válido para el tipo seleccionado.');
          } else {
            mostrarError('Por favor ingresa un número de documento.');
          }
          return;
        }

        if (valor && /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(\s[a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/.test(valor)) {
          limpiarError();
        } else {
          mostrarError(valor ? 'Solo letras y un espacio entre palabras.' : 'Por favor completa la información.');
        }
        return;
      }

      // EMAIL
      if (tipo === 'email') {
        if (valor && /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/.test(valor)) limpiarError();
        else mostrarError(valor ? 'Correo electrónico no válido.' : 'Por favor ingresa tu correo.');
        return;
      }

      // TELÉFONO
      if (tipo === 'number') {
        if (valor && /^9\d{8}$/.test(valor)) limpiarError();
        else mostrarError(valor ? 'Número inválido. Debe comenzar con 9 y tener 9 dígitos.' : 'Por favor ingresa tu número.');
        return;
      }

      // TEXTAREA
      if (input.tagName === 'TEXTAREA') {
        if (!input.offsetParent) return;
        const requerido = input.dataset.requerido === 'required';
        if (requerido && !valor) {
          mostrarError('Este campo es obligatorio.');
        } else {
          limpiarError();
        }
      }
    };

    input.addEventListener(evento, validarCampo);

    // BLUR: limpia espacios Y valida nuevamente
    input.addEventListener('blur', () => {
      if (input.type === 'text') {
        input.value = input.value.trim().replace(/\s+/g, ' ');
      }
      validarCampo(); // ← Aquí hacemos que vuelva a validar
    });
  });
});






