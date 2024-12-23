<?php
require_once('../config/bd.php');

function loginUser($con, $username, $password)
{
    $stmt = $con->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : false;
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
    
    $stmt = $con->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    
    return $stmt->execute() ? $con->insert_id : false;
}

function getuserByid($con, $id)
{
    $stmt = $con->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : false;
}

function verifyUsernameExists($con, $username)
{
    $stmt = $con->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return ($result && $result->num_rows > 0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    switch ($action) {
        case 'login':
            if ($user = loginUser($con, $username, $password)) {
                createSessionUser($user);
                header("Location:../app/dasboard.php?auth=Login exitoso");
            } else {
                header('Location:../login.php?message=Usuario no encontrado, intente de nuevo.');
            }
            break;

        case 'register':
            if ($result = register($con, $username, $password)) {
                $userbd = getuserByid($con, $result);
                createSessionUser($userbd);
                header("Location:../app/dasboard.php?auth=Registro exitoso");
            } else {
                header('Location:../login.php?message=El usuario ya existe');
            }
            break;
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];
    switch ($action) {
        case 'logout':
            logoutUser();
            header("Location:../login.php?auth=Logout exitoso");
            break;
    }
}

