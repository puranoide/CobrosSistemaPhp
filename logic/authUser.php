<?php
require_once('../config/bd.php');

function loginUser($con, $username, $password)
{
    $userQuery = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = $con->prepare($userQuery);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $loginResult = $stmt->get_result();
    
    if ($loginResult) {
        if ($loginResult->num_rows > 0) {
            return $loginResult->fetch_assoc();
        } else {
            return "Usuario no encontrado, intente de nuevo.";
        }
    } else {
        return "Error al conectarse a la base de datos, contacte con soporte.";
    }
}

function createSessionUser($user)
{
    session_start();
    $_SESSION['idUser'] = $user['id'];
    $_SESSION['username'] = $user['username'];
}

function logoutUser()
{
    session_start();
    session_destroy();
}

function register($con, $username, $password)
{
    if (verifyUsernameExists($con, $username)) {
        return false;
    }
    
    $query = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        return $con->insert_id;
    } else {
        return false;
    }
}

function getuserByid($con, $id)
{
    $userQuery = "SELECT * FROM users WHERE id=?";
    $stmt = $con->prepare($userQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $loginResult = $stmt->get_result();
    
    if ($loginResult) {
        if ($loginResult->num_rows > 0) {
            return $loginResult->fetch_assoc();
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function verifyUsernameExists($con, $username)
{
    $userQuery = "SELECT * FROM users WHERE username=?";
    $stmt = $con->prepare($userQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $loginResult = $stmt->get_result();
    
    return ($loginResult && $loginResult->num_rows > 0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    switch ($action) {
        case 'login':
            $result = loginUser($con, $username, $password);
            if (is_array($result)) {
                createSessionUser($result);
                header("Location:../app/dasboard.php?auth=Login exitoso");
            } else {
                header('Location:../login.php?message=' . $result);
            }
            break;

        case 'register':
            $result = register($con, $username, $password);
            if ($result !== false) {
                $userbd = getuserByid($con, $result);
                createSessionUser($userbd);
                header("Location:../app/dasboard.php?auth=Registro exitoso");
            } else {
                header('Location:../login.php?message=El usuario ya existe');
            }
            break;
            logoutUser();
            header("Location:../login.php?auth=Logout exitoso");
            break;    

        default:
            exit();
    }
}else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];
    switch ($action) {
        case 'logout':
            logoutUser();
            header("Location:../login.php?auth=Logout exitoso");
            break;
        default:
            exit();
    }
}

