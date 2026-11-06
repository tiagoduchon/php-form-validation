<?php
// Trabajo Práctico N° 3 - Programación I
// Procesamiento de datos recibidos mediante POST.

function valorTexto($clave) {
    $valor = $_POST[$clave] ?? '';
    return is_string($valor) ? trim($valor) : '';
}
function escapar($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function longitud($valor) {
    return function_exists('mb_strlen') ? mb_strlen($valor, 'UTF-8') : strlen($valor);
}
function mostrarBooleano($valor) {
    return $valor ? 'Verdadero' : 'Falso';
}

$errores = [];
$esPost = ($_SERVER['REQUEST_METHOD'] === 'POST');
$apellido = $esPost ? valorTexto('apellido') : '';
$nombre = $esPost ? valorTexto('nombre') : '';
$email = $esPost ? valorTexto('email') : '';
$sistema = $esPost ? valorTexto('sistema') : '';
$experiencia = ($esPost && valorTexto('experiencia') === 'Si') ? 'Si' : 'No';
$area = $esPost ? valorTexto('area') : '';
$comentario = $esPost ? valorTexto('comentario') : '';

if ($esPost) {
    if ($apellido === '' || longitud($apellido) > 60) $errores[] = 'Ingrese un apellido válido (máximo 60 caracteres).';
    if ($nombre === '' || longitud($nombre) > 60) $errores[] = 'Ingrese un nombre válido (máximo 60 caracteres).';
    if ($email === '' || longitud($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'Ingrese un e-mail válido (máximo 100 caracteres).';
    if (!in_array($sistema, ['Windows', 'Linux', 'macOS', 'Android', 'iOS', 'Otro'], true)) $errores[] = 'Seleccione un sistema operativo válido.';
    if (!in_array($area, ['Analisis y Diseno', 'Programacion', 'Bases de Datos'], true)) $errores[] = 'Seleccione un área de interés válida.';
    if (longitud($comentario) > 500) $errores[] = 'El comentario supera los 500 caracteres.';
    if (isset($_POST['experiencia']) && valorTexto('experiencia') !== 'Si') $errores[] = 'El valor de experiencia no es válido.';
}

$comprobaciones = [
    'isset_apellido' => isset($_POST['apellido']),
    'empty_comentario' => empty($comentario),
    'is_null_comentario' => is_null($comentario),
    'is_string_nombre' => is_string($nombre),
    'is_array_post' => is_array($_POST),
];

// Ejemplos de comprobaciones de variables solicitadas en la consigna.
$comprobaciones = [
    'isset_apellido' => isset($_POST['apellido']),
    'empty_comentario' => empty($comentario),
    'is_null_comentario' => is_null($comentario),
    'is_string_nombre' => is_string($nombre),
    'is_array_post' => is_array($_POST),
];

// Valores demostrativos para is_numeric(), is_int() e is_float().
$edadTexto = '19';
$edadNumero = intval($edadTexto);       // intval()
$promedioTexto = '8.5';
$promedioNumero = floatval($promedioTexto); // floatval()

$comprobaciones['is_numeric_edadTexto'] = is_numeric($edadTexto);
$comprobaciones['is_int_edadNumero'] = is_int($edadNumero);
$comprobaciones['is_float_promedioNumero'] = is_float($promedioNumero);

// strval(): convierte un valor a string.
$edadComoTexto = strval($edadNumero);

// settype(): convierte el tipo de una variable.
$ejemploSettype = '10';
settype($ejemploSettype, 'integer');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado | Formulario de registro</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #172033;
        }
        .container {
            width: min(100% - 32px, 900px);
            margin: 42px auto;
        }
        .card {
            background: #fff;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 20px 55px rgba(0,0,0,.28);
        }
        h1 { margin-top: 0; }
        h2 { margin-top: 28px; font-size: 1.15rem; }
        .ok {
            padding: 12px 14px;
            border-radius: 10px;
            background: #ecfdf5;
            color: #047857;
            font-weight: 700;
        }
        .error {
            padding: 12px 14px;
            border-radius: 10px;
            background: #fef2f2;
            color: #b91c1c;
        }
        .data-grid {
            display: grid;
            grid-template-columns: 220px 1fr;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }
        .data-grid div {
            padding: 11px 13px;
            border-bottom: 1px solid #e2e8f0;
        }
        .data-grid div:nth-last-child(-n+2) { border-bottom: 0; }
        .label {
            background: #f8fafc;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        th { background: #f8fafc; }
        .btn {
            display: inline-block;
            margin-top: 24px;
            padding: 11px 16px;
            border-radius: 9px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-weight: 700;
        }
        code { background: #f1f5f9; padding: 2px 6px; border-radius: 6px; }
        @media (max-width: 650px) {
            .data-grid { grid-template-columns: 1fr; }
            .data-grid .label { border-bottom: 0; }
        }
    </style>
</head>
<body>
<div class="container">
    <section class="card">
        <h1>Resultado del formulario</h1>

        <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
            <div class="error">Esta página debe abrirse enviando el formulario mediante el método POST.</div>
        <?php elseif (!empty($errores)): ?>
            <div class="error">
                <strong>No se pudieron procesar los datos:</strong>
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo escapar($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <p class="ok">✓ Datos recibidos y procesados correctamente.</p>

            <h2>Datos recibidos</h2>
            <div class="data-grid">
                <div class="label">Apellido</div><div><?php echo escapar($apellido); ?></div>
                <div class="label">Nombre</div><div><?php echo escapar($nombre); ?></div>
                <div class="label">E-mail</div><div><?php echo escapar($email); ?></div>
                <div class="label">Sistema Operativo</div><div><?php echo escapar($sistema); ?></div>
                <div class="label">Experiencia web</div><div><?php echo escapar($experiencia); ?></div>
                <div class="label">Área favorita</div><div><?php echo escapar($area); ?></div>
                <div class="label">Comentario</div><div><?php echo escapar($comentario !== '' ? $comentario : 'Sin comentario'); ?></div>
            </div>
        <?php endif; ?>

        <?php if ($esPost): ?>
        <h2>Comprobaciones de variables en PHP</h2>
        <table>
            <thead>
                <tr><th>Función</th><th>Resultado</th></tr>
            </thead>
            <tbody>
                <tr><td><code>isset()</code></td><td><?php echo mostrarBooleano($comprobaciones['isset_apellido']); ?></td></tr>
                <tr><td><code>empty()</code></td><td><?php echo mostrarBooleano($comprobaciones['empty_comentario']); ?></td></tr>
                <tr><td><code>is_null()</code></td><td><?php echo mostrarBooleano($comprobaciones['is_null_comentario']); ?></td></tr>
                <tr><td><code>is_string()</code></td><td><?php echo mostrarBooleano($comprobaciones['is_string_nombre']); ?></td></tr>
                <tr><td><code>is_array()</code></td><td><?php echo mostrarBooleano($comprobaciones['is_array_post']); ?></td></tr>
                <tr><td><code>is_numeric()</code></td><td><?php echo mostrarBooleano($comprobaciones['is_numeric_edadTexto']); ?></td></tr>
                <tr><td><code>is_int()</code></td><td><?php echo mostrarBooleano($comprobaciones['is_int_edadNumero']); ?></td></tr>
                <tr><td><code>is_float()</code></td><td><?php echo mostrarBooleano($comprobaciones['is_float_promedioNumero']); ?></td></tr>
            </tbody>
        </table>

        <h2>Conversión de tipos</h2>
        <table>
            <thead>
                <tr><th>Función</th><th>Ejemplo resultante</th></tr>
            </thead>
            <tbody>
                <tr><td><code>intval()</code></td><td><?php echo $edadNumero; ?> (<?php echo gettype($edadNumero); ?>)</td></tr>
                <tr><td><code>strval()</code></td><td><?php echo $edadComoTexto; ?> (<?php echo gettype($edadComoTexto); ?>)</td></tr>
                <tr><td><code>floatval()</code></td><td><?php echo $promedioNumero; ?> (<?php echo gettype($promedioNumero); ?>)</td></tr>
                <tr><td><code>settype()</code></td><td><?php echo $ejemploSettype; ?> (<?php echo gettype($ejemploSettype); ?>)</td></tr>
            </tbody>
        </table>

        <?php endif; ?>
        <a class="btn" href="TP.html">← Volver al formulario</a>
    </section>
</div>
</body>
</html>
