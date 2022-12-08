<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login.css">
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
                    <!-- <label>Username :</label> -->
                    <input type="text" name="username" id="username" required="required">
                    <span>Username</span>
                </div>
                <div class="input">
                    <!-- <label>Password :</label> -->
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
            console.log('masuk script')
            event.preventDefault();

            var fData = new FormData($("#frmLogin")[0]);
            $.ajax({
                url: 'api/login_process.php',
                type: 'POST',
                data: fData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: (response) => {
                    response = JSON.parse(response)
                    if (response.status == 'success') {
                        localStorage.username = $("#username").val();
                        window.location.href = 'index.php';
                    } else {
                        $('#error-message').html(response.msg)
                        $('#error-message').hide();
                        $('#error-message').fadeIn();
                        setTimeout(() => {
                            $('#error-message').fadeOut();
                        }, 3000);
                    }
                }
            });

        });
    </script>
</body>

</html>