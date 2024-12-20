<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KipuPay App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(31, 17, 36);
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
            background-color: rgb(92, 48, 105);
            color: #fff;
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
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }

        .navbar a:hover {
            text-decoration: underline #fff;

        }

        .auth {
            font-size: 18px;
            color: rgb(0, 0, 0);
            text-decoration: none;
            position: fixed;
            top: 8%;
            left: 2%;
            width: 10%;
            text-align: center;
            background-color: rgb(78, 245, 128);
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

            background-color: rgb(92, 48, 105);
            text-align: center;
            font-weight: bold;
            color: #fff;
        }

        .table-clients th {
            padding: 10px;
            background-color: rgb(224, 224, 224);
            text-align: center;
            color: #000;
        }

        .table-clients button {
            padding: 5px 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            color: #fff;
        }

        .table-clients button:hover {
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }

        .title-page {
            text-align: center;
            color: #fff;
            margin-top: 5%;
        }

        .add-client {
            display: block;
            background-color: rgb(153, 152, 152);
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin: 2% auto;
            font-size: 16px;
            text-align: center;
        }

        .add-client:hover {
            background-color: rgb(102, 101, 101);
            transition: background-color 0.3s ease;
        }

        .add-client:active {
            background-color: rgb(102, 101, 101);
        }

        .identification {

            font-size: 18px;
            color: rgb(255, 255, 255);
            text-decoration: none;
            position: fixed;
            top: 90%;
            left: 90%;
            width: 8%;
            text-align: center;
            background-color: rgb(92, 48, 105);
            padding: 1px;
            border-radius: 5px;
        }

        .onlineindicator {
            color: #fff;
            animation: pulse 1s infinite alternate;
        }

        @keyframes pulse {
            0% {
                color: #fff;

            }

            50% {
                color: rgb(78, 245, 128);
                text-shadow: 0 0 10px rgb(78, 245, 128);
            }

            100% {
                color: rgb(78, 245, 128);
                text-shadow: 0 0 20px rgb(78, 245, 128);
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
                left:55%;
                
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

    <button onclick="window.location.href = 'clientmanagement.php?action=add';" class="add-client">Add Client</button>

    <table class="table-clients">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>debt Amount</th>
                <th>amount paid</th>
                <th>Balance</th>
                <th>Payment Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>John Doe</td>
                <td>$1000</td>
                <td>$500</td>
                <td>$500</td>
                <td>2023-06-01</td>
                <td>
                    <button>View</button>
                    <button>View</button>
                </td>
            </tr>
            <tr>
                <td>Jane Smith</td>
                <td>$2000</td>
                <td>$1000</td>
                <td>$1000</td>
                <td>2023-06-15</td>
                <td>
                    <button>View</button>
                    <button>View</button>
                </td>
            </tr>
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