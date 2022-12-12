<?php session_start();

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROJECT FSP</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/login.css">
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div id="container">
        <header>
            <h1>LOG IN</h1>
        </header>

        <main>
            <form method='post' action='api/login_process.php' id="frmLogin">
                <div class="input">
                    <input type="text" name="username" id="username" required="required">
                    <span>Username</span>
                </div>
                <div class="input">
                    <input type="password" name="password" id="password" required="required">
                    <span>Password</span>
                </div>
                <div class="input">
                    <button type="submit" name="login" id="login">LOGIN</button>
                </div>
                <br>
                <p id='error-message'>
                </p>
            </form>
        </main>
    </div>

    <script>
        $("#frmLogin").submit((event) => {
            event.preventDefault()

            var fData = new FormData($("#frmLogin")[0]);
            $.ajax({
                // URL Absolute Path
                // url: 'https://trivialteam.000webhostapp.com/api/login_process.php',
                url: 'api/login_process.php',

                type: 'POST',
                data: fData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: (response) => {
                    response = JSON.parse(response)
                    // If login success redirect to index
                    if (response.status == 'success') {
                        window.location.href = 'index.php?page=1'
                    }
                    // Show error message 
                    else {
                        $('#error-message').html(response.msg)
                        $('#error-message').hide()
                        $('#error-message').fadeIn()
                    }
                }
            });
        });
    </script>
</body>

</html>