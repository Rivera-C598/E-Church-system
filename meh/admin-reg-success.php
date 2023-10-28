<?php

session_start();

if (!isset($_SESSION['admin-registered']) || $_SESSION['admin-registered'] !== true) {
    // Redirect to the registration page or display an error message
    echo 'value: ' . $_SESSION['admin-registered'];
    header('Location: admin-registration.php');
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <title>Archidiocesan Shrine of Apostol de Compostela - Success</title>
    <style>
        .container {
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .display-4 {
            color: #333;
            font-size: 3rem;
        }

        h3 {
            color: #333;
            font-size: 1.5rem;
            margin-top: 20px;
        }

        #content-main {
            height: 50vh;
        }
    </style>
</head>

<body>
    <header class="bg-dark text-light">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="#">
                    <img src="imgs/church-logo.png" alt="Church Logo" width="40" height="auto" />
                    Archidiocesan Shrine of Apostol de Compostela
                </a>
            </nav>
        </div>
    </header>

    <div class="container mt-5" id="content-main">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h1 class="display-4">Admin Registration Success</h1>
                <button class="btn btn-primary" id="goToLoginBtn">Go to Login</button>

            </div>
        </div>
    </div>

    <footer class="bg-dark text-light text-center py-3">
        <div class="container">&copy; 2023 Your Website</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const goToLoginBtn = document.getElementById("goToLoginBtn");

            goToLoginBtn.addEventListener("click", function() {
                const xhr = new XMLHttpRequest();

                xhr.open("GET", "unset-var-script.php", true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        window.location.href = "admin-login.php";
                    }
                };

                xhr.send();
            });
        });
    </script>
</body>

</html>