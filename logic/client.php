<?php

function addClient($con, $name, $email, $debt, $datePayment, $userId) {
    $query = "INSERT INTO clients (name, email, debitPayment, nextPayment, idUser) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);

    $today = new DateTime();
    $paymentDate = new DateTime($today->format("Y-m-" . $datePayment));
    $nextPayment = $paymentDate > $today ? clone $paymentDate : $paymentDate->modify('+1 month');
    $nextPaymentDate = $nextPayment->format('Y-m-d');

    $stmt->bind_param("ssdsi", $name, $email, $debt, $nextPaymentDate, $userId);
    return $stmt->execute() ? $con->insert_id : $con->error;
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'addClient':
            require_once('../config/bd.php');
            session_start();
            $result = addClient($con, $_POST['name'], $_POST['email'], $_POST['debt'], $_POST['datePayment'], $_SESSION['idUser']);
            header("Location:../app/dasboard.php?auth=" . ($result !== false ? "Cliente Agregado" : "Error al agregar el cliente"));
            break;
    }
}

