<?php
require_once('../config/bd.php');

function login($db, $username, $password)
{
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows === 1) {
        return $result;
    } else {
        return false;
    }
}
function register($db, $username, $password)
{

    if (verifyUsernameExists($db, $username)) {
        return false;
    } else {
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $result = $stmt->execute();
        if ($result) {
            return $db->insert_id;
        } else {
            return false;
        }
    }
}



function verifyUsernameExists($db, $username)
{
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_array(MYSQLI_ASSOC);
}

// Lógica para manejar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'login':
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = login($con, $username, $password);
            if ($result) {
                session_start();
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['password'] = $row['password'];
                if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['password'])) {
                    header("Location:../app/dasboard.php?auth=Login exitoso");
                    exit();
                }
            } else {
                header('Location:../login.php?message=Usuario o contraseña incorrectos');
                exit();
            }
            break;

        case 'register':
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = register($con, $username, $password);
            if ($result) {
                
                session_start();
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['password'] = $row['password'];
                if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['password'])) {
                    header("Location:../app/dasboard.php?auth=Registro exitoso");
                    exit();
                }
                exit();
            } else {
                header('Location:../login.php?message=El usuario ya existe');
                exit();
            }
            break;
        default:
            exit();
    }
}
