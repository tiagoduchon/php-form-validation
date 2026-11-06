window.onload = function () {
    const formulario = document.getElementById('formularioRegistro');
    const apellido = document.getElementById('apellido');
    const nombre = document.getElementById('nombre');
    const email = document.getElementById('email');
    const sistema = document.getElementById('sistema');
    const comentario = document.getElementById('comentario');
    const contadorComentario = document.getElementById('contadorComentario');
    const estadoFormulario = document.getElementById('estadoFormulario');

    const expresionEmail = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    function mostrarError(elemento, idError, mensaje) {
        elemento.classList.add('input-error');
        document.getElementById(idError).textContent = mensaje;
    }

    function limpiarError(elemento, idError) {
        elemento.classList.remove('input-error');
        document.getElementById(idError).textContent = '';
    }

    function limpiarErrores() {
        limpiarError(apellido, 'errorApellido');
        limpiarError(nombre, 'errorNombre');
        limpiarError(email, 'errorEmail');
        limpiarError(sistema, 'errorSistema');
        document.getElementById('errorArea').textContent = '';
        estadoFormulario.textContent = '';
        estadoFormulario.className = 'form-status';
    }

    function validarFormulario() {
        let valido = true;
        limpiarErrores();

        if (apellido.value.trim() === '' || apellido.value.trim().length > 60) {
            mostrarError(apellido, 'errorApellido', 'Ingrese su apellido.');
            valido = false;
        }

        if (nombre.value.trim() === '' || nombre.value.trim().length > 60) {
            mostrarError(nombre, 'errorNombre', 'Ingrese su nombre.');
            valido = false;
        }

        if (email.value.trim() === '') {
            mostrarError(email, 'errorEmail', 'Ingrese su e-mail.');
            valido = false;
        } else if (!expresionEmail.test(email.value.trim())) {
            mostrarError(email, 'errorEmail', 'Ingrese un e-mail válido.');
            valido = false;
        }

        if (sistema.value === '') {
            mostrarError(sistema, 'errorSistema', 'Seleccione un sistema operativo.');
            valido = false;
        }

        const areaSeleccionada = document.querySelector('input[name="area"]:checked');
        if (!areaSeleccionada) {
            document.getElementById('errorArea').textContent = 'Seleccione una opción.';
            valido = false;
        }

        if (!valido) {
            estadoFormulario.textContent = 'Revise los campos marcados antes de enviar.';
            estadoFormulario.classList.add('error');
        } else {
            estadoFormulario.textContent = 'Datos validados correctamente. Enviando al servidor...';
            estadoFormulario.classList.add('ok');
        }

        return valido;
    }

    formulario.addEventListener('submit', function (evento) {
        if (!validarFormulario()) {
            evento.preventDefault();
        }
    });

    formulario.addEventListener('reset', function () {
        setTimeout(function () {
            limpiarErrores();
            contadorComentario.textContent = '0/500';
        }, 0);
    });

    apellido.addEventListener('input', function () {
        if (apellido.value.trim() !== '') limpiarError(apellido, 'errorApellido');
    });

    nombre.addEventListener('input', function () {
        if (nombre.value.trim() !== '') limpiarError(nombre, 'errorNombre');
    });

    email.addEventListener('input', function () {
        if (expresionEmail.test(email.value.trim())) limpiarError(email, 'errorEmail');
    });

    sistema.addEventListener('change', function () {
        if (sistema.value !== '') limpiarError(sistema, 'errorSistema');
    });

    document.querySelectorAll('input[name="area"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.getElementById('errorArea').textContent = '';
        });
    });

    comentario.addEventListener('input', function () {
        contadorComentario.textContent = comentario.value.length + '/500';
    });
};
