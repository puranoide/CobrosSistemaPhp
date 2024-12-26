<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function sendMessage($con, $id, $message){
        date_default_timezone_set('America/Lima');
        $date= new DateTime();
        $formattedDate = $date->format('Y-m-d'); // Asignar el resultado a una variable
        $stmt = $con->prepare("INSERT INTO mesagesSends (message, clientsId, dateMessageSend) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $message, $id, $formattedDate);
        return $stmt->execute() ? $con->insert_id : $con->error;
    }
    function sendMail(){
        $para="puranogame@gmail.com";
        $asunto="Nuevo Registro correo'";
        $mensaje="mensaje de prueba";
        $cabecera="From: no-reply@darkslateblue-fly-946582.hostingersite.com";
        if(mail($para,$asunto,$mensaje,$cabecera)){
            return true;
        }else{
            return false;
        }
    }
    print_r($_POST);    

    $action=$_POST['action'];
    
    
    switch ($action) {
        case 'sendMenssage':
            require_once('../config/bd.php');
            $id=$_POST['id'];
            $message=$_POST['message'];
            $respuesta = sendMessage($con, $id, $message);
            if ($respuesta === false) {
                header("Location:../app/adminpanel.php?user=admin&pass=3_0i1n{-TJ-XUBQ_2azQ-;;3h1PDygV-]4*7}kCC))yR-{e3c(en[5=-/}bXS:g*:4-TcG[GZ{XZh-5@jXByU-dt-YA0DfWqXY)-uQYZ6*c5_4&message=Error al enviar el mensaje");
            }
            sendMail();
            header("Location:../app/adminpanel.php?user=admin&pass=3_0i1n{-TJ-XUBQ_2azQ-;;3h1PDygV-]4*7}kCC))yR-{e3c(en[5=-/}bXS:g*:4-TcG[GZ{XZh-5@jXByU-dt-YA0DfWqXY)-uQYZ6*c5_4&message=mensaje enviado id=$respuesta");
            print_r($respuesta);
            break;
        
        default:
            # code...
            break;
    }
}else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
$user=$_GET['user'];
$pass=$_GET['pass'];
$message=isset($_GET['message']) ? $_GET['message'] : null;
if ($user == 'admin' && $pass == '3_0i1n{-TJ-XUBQ_2azQ-;;3h1PDygV-]4*7}kCC))yR-{e3c(en[5=-/}bXS:g*:4-TcG[GZ{XZh-5@jXByU-dt-YA0DfWqXY)-uQYZ6*c5_4'):
    function listClients($con)
    {
        $query = "SELECT * FROM clients";
        $result = $con->query($query);
        $clients = array();
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }
        return $clients;
    }
    function listUserById($con, $id){
        $stmt = $con->prepare("SELECT * FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : false;
    }
    require_once('../config/bd.php');
    $clients = listClients($con);

 

    function listClientstodayPayment($con){
        date_default_timezone_set('America/Lima');
        $date= new DateTime();
        $query = "SELECT * FROM clients WHERE nextPayment = '" . $date->format('Y-m-d') . "'";
        $result = $con->query($query);
        $clients = array();
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }
        return $clients;
    }

    $clientsPaymentToday = listClientstodayPayment($con);
     /*
    echo "<pre>";
    print_r($clientsPaymentToday);
    echo "</pre>";
   
    echo "<pre>";
    print_r($clients);
    echo "</pre>";
    */
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>admin view</title>
    </head>
    <body>
         <?php if (isset($message)): ?>
            <p><?= $message ?></p>
        <?php endif; ?>   

        <h1>admin panel</h1>
        <table>
            <thead>
                <tr>
                    <th>username Name</th>
                    <th>Client Name</th>
                    <th>debt Amount</th>
                    <th>Payment Date</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client) : 

                    $user = listUserById($con, $client['idUser']);

                    ?>
                    <tr>
                        <td><?= $user['username'] ?></td>
                        <td><?= $client['name'] ?></td>
                        <td>S/.<?= $client['debitPayment'] ?></td>
                        <td><?= $client['nextPayment'] ?></td>
                        <td title="<?= $client['message'] ?>">
                            <?= substr($client['message'], 0, 20) . '...' ?>
                        </td>
                        <td>
                            <button onclick="window.location.href = 'clientmanagement.php?action=edit&id=<?= $client['id'] ?>';">Editar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h1>pagos de hoy</h1>

        <table>
            <thead>
                <tr>
                    <th>username Name</th>
                    <th>Client Name</th>
                    <th>debt Amount</th>
                    <th>Payment Date</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientsPaymentToday as $client) : 
                    $user = listUserById($con, $client['idUser']);
                    ?>
                    <tr>
                        <td><?= $user['username'] ?></td>
                        <td><?= $client['name'] ?></td>
                        <td>S/.<?= $client['debitPayment'] ?></td>
                        <td><?= $client['nextPayment'] ?></td>
                        <td title="<?= $client['message'] ?>">
                            <?= substr($client['message'], 0, 20) . '...' ?>
                        </td>
                        <td>
                            <form action="adminpanel.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="sendMenssage">
                                <input type="hidden" name="message" value="<?= $client['message'] ?>">
                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                <button type="submit">enviar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </body>
    </html>
<?php else:
    echo "Acceso denegado";
endif;
}

?>