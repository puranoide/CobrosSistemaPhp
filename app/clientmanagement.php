<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("Location: ../login.php");
    exit();
}

$Clientid = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;
if ($Clientid == null):
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agregar Cliente</title>
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

            .formAddClient {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                display: flex;
                flex-direction: column;
                align-items: start;
                color: #fff;
                text-align: start;
                width: 100%;
                max-width: 400px;
                padding: 20px;
                background-color: rgb(92, 48, 105);
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            }
            .formAddClient label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            .formAddClient input[type="text"],
            .formAddClient input[type="email"],
            .formAddClient input[type="password"] {
                width: 80%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 16px;
            }
            .formAddClient input[type="number"] {
                width: 80%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 16px;
            }

            .formAddClient input[type="submit"] {
                background-color: #4CAF50;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
            }   

            .formAddClient input[type="submit"]:hover {
                background-color: #45a049;
            }
            .formAddClient select{
                width: 80%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 16px;
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

            <form action="../logic/client.php" method="POST" class="formAddClient">
                <input type="hidden" name="action" value="addClient">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Correo:</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">pago mensual:</label>
                <input type="number" step="0.01" id="debt" name="debt" required>

                <label for="datePayment">Fecha de Pago mensual:</label>
                <select name="datePayment" id="datePayment">

                </select>

                <input type="submit" value="Agregar Cliente">
            </form>


        <div class="identification">
        <p><span class="onlineindicator">Online:</span> <?php echo $_SESSION['username']; ?> </p>
    </div>
    </body>

            <script>
                function obtenerDias() {
                    var fechaActual = new Date();
                    var diaActual = fechaActual.getDate();
                    var mesActual = fechaActual.getMonth() + 1;
                    var anioActual = fechaActual.getFullYear();

                    var select = document.getElementById("datePayment");

                    for (var i = 1; i <= 31; i++) {
                        var option = document.createElement("option");
                        option.value = i;
                        option.text = i;
                        select.add(option);
                    }
                }

                obtenerDias();
            </script>

    </html>

<?php 
elseif (isset($_GET['action']) && $_GET['action'] == 'view'):?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
            
           pagina en construccion 
           <?=$_GET['id']?>

        </body>
        </html>
<?php  endif;
?>