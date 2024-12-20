<?php
require_once __DIR__ . '/../config/bd.php';

function login($db, $username, $password) {
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);
    $result = $stmt->execute();

    return $result;
}

// Lógica para manejar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'login':
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = login($db, $username, $password);
            if ($result && $row = $result->fetchArray(SQLITE3_ASSOC)) {
                session_start();
                echo    "Login exitoso";
                $_SESSION['username'] = $row['username'];
                //header("Location:../index.php");
                exit();
            } else {
                header('Location:../login.php?message=Usuario o contraseña incorrectos');
                exit();
            }
            break;

        default:
            exit();
    }
}
?>

