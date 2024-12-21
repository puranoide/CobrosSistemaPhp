<?php
require_once __DIR__ . '/../config/bd.php';

function login($db, $username, $password) {
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);
    $result = $stmt->execute();

    return $result;
}

function register($db, $username, $password) {

    if (verifyUsernameExists($db, $username)) {
        return false;
    }else{
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $stmt->bindValue(':password', $password, SQLITE3_TEXT);
        $result = $stmt->execute();
        return $result;
    }

    
}

function verifyUsernameExists($db, $username) {
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username"); 
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute();

    return $result->fetchArray(SQLITE3_ASSOC);
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
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['idUser'];
                header("Location:../app/dasboard.php?auth=Login exitoso");
                exit();
            } else {
                header('Location:../login.php?message=Usuario o contraseña incorrectos');
                exit();
            }
            break;

        case 'register':
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = register($db, $username, $password);
            if ($result) {
                header('Location:../login.php?auth=Registro exitoso');
                exit();
            } else {
                header('Location:../register.php?message=El usuario ya existe');
                exit();
            }
            break;
        default:
            exit();
    }
}
?>

