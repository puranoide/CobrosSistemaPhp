<?php
function addClient($con, $name, $email, $debt, $datePayment, $userId, $message)
{
    $query = "INSERT INTO clients (name, email, debitPayment, nextPayment, idUser, message) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);

    $today = new DateTime();
    $paymentDate = new DateTime($today->format("Y-m-" . $datePayment));
    $nextPayment = $paymentDate > $today ? $paymentDate : $paymentDate->modify('+1 month');
    $nextPaymentDate = $nextPayment->format('Y-m-d');

    $stmt->bind_param("ssdsis", $name, $email, $debt, $nextPaymentDate, $userId, $message);
    return $stmt->execute() ? $con->insert_id : $con->error;
}
function editClient($con, $id, $name, $email, $debt, $datePayment, $message)
{
    $query = "UPDATE clients SET name = ?, email = ?, debitPayment = ?, nextPayment = ?, message = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $today = new DateTime();
    $paymentDate = new DateTime($today->format("Y-m-" . $datePayment));
    $nextPayment = $paymentDate > $today ? $paymentDate : $paymentDate->modify('+1 month');
    $nextPaymentDate = $nextPayment->format('Y-m-d');
    $stmt->bind_param("ssdssi", $name, $email, $debt, $nextPaymentDate, $message, $id);
    return $stmt->execute() ? $con->insert_id : $con->error;
}
function getClientById($con, $id)
{
    $query = "SELECT * FROM clients WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
function compareDay($dateActual, $dateaenvular)
{
    $dateActual = new DateTime($dateActual);
    $date = new DateTime();
    $dateaenvular = new DateTime($date->format("Y-m-" . $dateaenvular));

    $dateActual = $dateActual->format('d');
    $dateaenvular = $dateaenvular->format('d');
    return $dateaenvular == $dateActual;
}
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'addClient':
            session_start();
            require_once('../config/bd.php');

            $message = !empty($_POST['mesagge']) ? $_POST['mesagge'] : "te recordamos de parte de " . $_SESSION['username'] . " que debes pagar tu mensualidad de " . $_POST['debt'] . " para el dia  " . $_POST['datePayment'];

            header("Location:../app/dasboard.php?auth=" . (addClient($con, $_POST['name'], $_POST['email'], $_POST['debt'], $_POST['datePayment'], $_SESSION['idUser'], $message) !== false ? "Cliente Agregado" : "Error al agregar el cliente"));
            break;
        case 'editClient':
            session_start();
            require_once('../config/bd.php');
            $client = getClientById($con, $_POST['id']);
            if ($rst) {
                $message=$_POST['mesagge'];
            } else {
                $message = "te recordamos de parte de " . $_SESSION['username'] . " que debes pagar tu mensualidad de " . $_POST['debt'] . " para el dia  " . $_POST['datePayment'];
            }

            header("Location:../app/dasboard.php?auth=" . (editClient($con, $_POST['id'], $_POST['name'], $_POST['email'], $_POST['debt'], $_POST['datePayment'], $message) !== false ? "Cliente Actualizado" : "Error al actualizar el cliente"));
            break;
    }
}
