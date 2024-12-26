<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    print_r($_POST);    
}else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
$user=$_GET['user'];
$pass=$_GET['pass'];

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

    function SendMessage($con, $id, $message){
        $date= new DateTime();
        $stmt = $con->prepare("INSERT INTO mesagessends SET message=?,clienteId=?,date=?");
        $stmt->bind_param("ssi", $message, $id, $date->format('Y-m-d'));
        return $stmt->execute() ? $con->insert_id : $con->error;
        
    }

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
                                <input type="hidden" name="action" value="edit">
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