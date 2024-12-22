<?php
function addClient($con, $name, $email, $debt, $datePayment,$user){
    $today = new DateTime();
    $paymentDate = new DateTime($today->format('Y-m-'. $datePayment));
    if ($paymentDate > $today) {
        $nextPayment = clone $paymentDate;
    } else {
        $nextPayment=clone $paymentDate;
        $nextPayment->modify('+1 month');
    }
    $Pagodb=$nextPayment->format('Y-m-d');
    $query = "INSERT INTO clients (name,email,debitPayment,nextPayment,idUser) VALUES(?,?,?,?,?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssdss", $name, $email, $debt, $Pagodb, $user);
    if ($stmt->execute()) {
        return $con->insert_id;
    } else {
        return $con->error;
    }

}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'addClient':
            require_once('../config/bd.php');
            $name = $_POST['name'];   
            $email = $_POST['email'];
            $debt = $_POST['debt'];
            session_start();
            $datePayment = $_POST['datePayment'];
            echo $_SESSION['idUser'];
            $result=addClient($con, $name, $email, $debt, $datePayment,$_SESSION['idUser']);    
            var_dump($result);
            if($result!==false){
                header("Location:../app/dasboard.php?auth=Cliente Agregado");
            }else{
                header("Location:../app/dasboard.php?auth=Error al agregar el cliente");
            }
            break;
    }
}

?>