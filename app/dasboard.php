<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("Location: ../login.php");
    exit();
}
function listClients($con)
{
    $query = "SELECT * FROM clients WHERE idUser = " . $_SESSION['idUser'];
    $result = $con->query($query);
    $clients = array();
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
    return $clients;
}

include_once('../config/bd.php');

$clients = listClients($con);
$countClients = count($clients);
function limitClients($count, $limit){
    if ($count> $limit) {
        return true;
    } else {
        return false;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KipuPay App</title>
    <link rel="icon" type="image/png" href="../assets/img/logo.png" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            background-size: cover;
            background-position: center;
            margin: 0;
            display: block;
            justify-content: center;
            height: 90vh;
            max-width: 100%;
            overflow-x: hidden;
        }

        .navbar {
            background-color: #2c3e50;
            color: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 50px;
        }

        .navbar a {
            font-size: 18px;
            color: #ecf0f1;
            text-decoration: none;
            margin: 0 10px;
        }

        .navbar a:hover {
            text-decoration: underline #ecf0f1;
        }

        .auth {
            font-size: 18px;
            color: #34495e;
            text-decoration: none;
            position: fixed;
            top: 8%;
            left: 2%;
            width: 10%;
            text-align: center;
            background-color: #bdc3c7;
            padding: 10px;
            border-radius: 5px;
        }

        .table-clients {
            width: 70%;
            height: 50px;
            margin: 0 auto;
            border-collapse: collapse;
        }

        .table-clients td {
            padding: 10px;
            background-color: #2c3e50;
            text-align: center;
            font-weight: bold;
            color: #ecf0f1;
        }

        .table-clients th {
            padding: 10px;
            background-color: #ecf0f1;
            text-align: center;
            color: #34495e;
        }

        .table-clients button {
            padding: 5px 10px;
            background-color: #3498db;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            color: #ecf0f1;
        }

        .table-clients button:hover {
            background-color: #2980b9;
            transition: background-color 0.3s ease;
        }

        .title-page {
            text-align: center;
            color: #34495e;
            margin-top: 5%;
        }

        .add-client {
            display: block;
            background-color: #95a5a6;
            color: #ecf0f1;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin: 2% auto;
            font-size: 16px;
            text-align: center;
        }

        .add-client:hover {
            background-color: #7f8c8d;
            transition: background-color 0.3s ease;
        }

        .add-client:active {
            background-color: #7f8c8d;
        }

        .identification {
            font-size: 18px;
            color: #ecf0f1;
            text-decoration: none;
            position: fixed;
            top: 90%;
            left: 90%;
            width: 8%;
            text-align: center;
            background-color: #2c3e50;
            padding: 1px;
            border-radius: 5px;
        }

        .onlineindicator {
            color: #ecf0f1;
            animation: pulse 1s infinite alternate;
        }

        @keyframes pulse {
            0% {
                color: #ecf0f1;
            }

            50% {
                color: #1abc9c;
                text-shadow: 0 0 10px #1abc9c;
            }

            100% {
                color: #1abc9c;
                text-shadow: 0 0 20px #1abc9c;
            }
        }

        @media screen and (max-width: 768px) {

            .navbar {
                height: auto;
                padding: 10px 0;
            }

            .navbar a {
                margin: 5px 0;
                margin: 0 10px;
            }

            .title-page {
                font-size: 20px;
            }

            .add-client {
                font-size: 14px;
            }

            .table-clients {
                font-size: 12px;
            }

            .identification {
                font-size: 14px;
                width: 40%;
                top: 90%;
                left: 55%;
            }
        }
    </style>
</head>

<body>
    <div class="navbar">

        <a href="../login.php">Login</a>
        <a href="../register.php">Register</a>
        <a href="../logic/authUser.php?action=logout">Cerrar Sesion</a>
    </div>

    <h1 class="title-page">Dashboard</h1>

    <button <?php echo (limitClients($countClients,5)) ? 'disabled' : ''; ?> onclick="window.location.href = 'clientmanagement.php?action=add';" class="add-client"><?php echo (limitClients($countClients, 5)) ? 'usted no puede agregar mas de 5 clientes' : 'add client'; ?></button>

    <table class="table-clients">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>debt Amount</th>
                <th>Payment Date</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client) : ?>
                <tr>
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
            <?php endforeach;
            if (empty($clients)): ?>
                <tr>
                    <td colspan="5">No clients found.</td>
                </tr>
            <?php endif;
            ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET["auth"])): ?>
        <p class="auth" id="message"><?php echo $_GET["auth"]; ?></p>
    <?php
    endif;
    ?>

    <div class="identification">
        <p><span class="onlineindicator">Online:</span> <?php echo $_SESSION['username']; ?> </p>
    </div>


    <script>
        setInterval(cleanMessage, 1000);

        function cleanMessage() {
            const messageElement = document.getElementById("message");
            messageElement.style.opacity = 1;
            (function fade() {
                if ((messageElement.style.opacity -= 0.1) < 0) {
                    messageElement.style.display = "none";
                } else {
                    requestAnimationFrame(fade);
                }
            })();
        }
    </script>
</body>

</html>