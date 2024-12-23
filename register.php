<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="icon" type="image/png" href="assets/img/logo.png" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(assets/img/9019796.jpg);
            background-size: cover;
            background-position: center;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
            max-width: 100%;
            overflow-x: hidden;
        }

        .navbar {
            background-color: rgb(255, 255, 255);
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
            color: #000;
            text-decoration: none;
            margin: 0 10px;
        }

        .navbar a:hover {
            text-decoration: underline #000;

        }

        .container {
            background-color: rgb(255, 255, 255);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .container h1 {
            text-align: center;
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container form label {
            margin-bottom: 5px;
        }

        .container form input[type="text"],
        .container form input[type="password"] {
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .container form input[type="submit"] {
            padding: 10px;
            background-color: rgb(96, 98, 255);
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .container form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .container form .password-container {
            position: relative;
        }

        .container form .password-container button {
            position: absolute;
            top: 50%;
            right: 0px;
            transform: translateY(-60%);
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .container form .password-container input {
            padding-right: 180px;
        }

        footer {
            background-color: rgb(255, 255, 255);
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        footer p a {
            margin: 5px 0;
            color: #000;
        }

        .copyright {
            font-size: 14px;
            color: #000;
        }

        .error {
            color: red;
        }
        .auth{
            color: green;
        }
        /* Media Queries */
        @media screen and (max-width: 768px) {

            .container {
                width: 90%;
                margin: 0 10px;
            }

            .navbar {
                height: auto;
                padding: 10px 0;
            }

            .navbar a {
                margin: 5px 0;
                margin: 0 10px;
            }

            body {
                height: 90vh;
            }

            footer {
                margin-top: 10px;
                position: absolute;
                width: 95%;

            }
        }

        @media screen and (max-width: 480px) {

            .container form input[type="text"],
            .container form input[type="password"] {
                font-size: 16px;
            }

            .container h1 {
                font-size: 24px;
            }

            .container form .password-container input {
                padding-right: 40px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <a href="index.html">Home</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </div>

    <div class="container">
        <h1>Register</h1>
        <form method="post" action="logic/authUser.php">
            <input type="hidden" name="action" value="register">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <button type="button" onclick="togglePasswordVisibility()" id="toggleBtn">👀</button>
            </div>
            <br>
            <input type="submit" value="Login"><br>
            <?php
            if (isset($_GET["message"])): ?>
                <p class="error"><?php echo $_GET["message"]; ?></p>
            <?php endif; ?>
            <?php
            if (isset($_GET["auth"])): ?>
                <p class="auth"><?php echo $_GET["auth"]; ?></p>
            <?php endif; ?>
        </form>
    </div>




    <footer>
        <p class="copyright">&copy; 2024 kipupay. Todos los derechos reservados</p>
        <p><a href="privacy_policy.php">Politica de Privacidad</a> | <a href="terms_of_service.php">Terminos de Servicio</a></p>
        <p><a href="contact.php">Contactanos</a></p>
    </footer>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleBtn = document.getElementById("toggleBtn");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleBtn.textContent = "🔒";
            } else {
                passwordInput.type = "password";
                toggleBtn.textContent = "👀";
            }
        }
    </script>
</body>

</html>