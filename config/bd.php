<?php
// Ruta absoluta al archivo de la base de datos
$db_file = __DIR__ . '/cobros.db';

// Crear conexión SQLite
$db = new SQLite3($db_file);

// Verificar conexión
if (!$db) {
    die("Error al conectar con la base de datos: " . $db->lastErrorMsg());
}
?>
