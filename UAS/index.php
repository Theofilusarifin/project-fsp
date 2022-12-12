<?php
session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php");
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
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <button name="logout" id="logout" onclick="logout()">LOGOUT</button>
    <br>
    <div class="container">
        <div class="grid-container" id="card-container">
            <!-- Get data from ajax -->
        </div>
        <!-- <div class="paging">
            <i class="fa fa-arrow-left"></i>
            <span class="pageContent"></span>
            <i class="fa fa-arrow-right"></i>
        </div> -->
    </div>

    <script>
        $(document).ready(() => {
            $.ajax({
                // URL Absolute Path
                // url: 'https://trivialteam.000webhostapp.com/api/get_memes.php',
                url: 'api/get_memes.php',

                type: 'POST',
                data: {
                    data_page: 12,
                    page: <?php echo $_GET['page'] ?>,
                },

                success: (response) => {
                    var response = JSON.parse(response)

                    // Success retrieve data
                    if (response.status == 'success') {
                        var temp = ''
                        // DO iteration on each item
                        $.each(response.msg, (i, item) => {
                            // Add each item into temp var
                            var pressed = (item.liked) ? ' press' : ''
                            temp += `<div class="card" id=${item.id}>
                                        <div class="img-container">
                                            <img src=${item.img_url} />
                                        </div>
                                        <div class="content">
                                            <div class="like-container">
                                                <i class="like${pressed}" onclick="like(${item.id})" id=like_${item.id}></i>
                                                <p id=text_like_${item.id}>${item.total_like} Likes</p>
                                            </div>
                                            <i class="fa-solid fa-comment comment"></i>
                                        </div>
                                    </div>`
                        });
                        // Replace card container html to be new item
                        $('#card-container').html(temp)
                    }
                    // Show error message 
                    else {
                        alert(response.msg)
                    }
                }
            });
        });

        // Like Function
        const like = (meme_id) => {
            if ($("#like_" + meme_id).attr('class') == 'like') {
                // Add like to database using ajax
                $.ajax({
                    // URL Absolute Path
                    // url: 'https://trivialteam.000webhostapp.com/api/like_process.php',
                    url: 'api/like_process.php',

                    type: 'POST',
                    data: {
                        meme_id: meme_id,
                    },
                    success: (response) => {

                        var response = JSON.parse(response)
                        // Success retrieve data
                        if (response.status == 'success') {
                            console.log(response.msg)
                            // Change like count
                            $("#text_like_" + meme_id).html(response.msg + " likes");
                        }
                        // Show error message 
                        else {
                            alert(response.msg)
                        }
                    }
                }).done(() => {
                    // Add animation after ajax is done
                    $("#like_" + meme_id).toggleClass("press", 1000)
                });
            } else {
                alert("You already liked this memes")
            }
        }

        // Logout Function
        const logout = () => {
            $.ajax({
                // URL Absolute Path
                url: 'api/logout_process.php',
                // url: 'https://trivialteam.000webhostapp.com/api/logout_process.php',

                data: {},
                success: (response) => {
                    response = JSON.parse(response)
                    // If logout success redirect to login
                    if (response.status == 'success') {
                        window.location.href = 'login.php';
                    }
                    // Show error message 
                    else {
                        alert(response.msg)
                    }
                }
            });
        };

        // function page(dataP) {
        //     var idLike;
        //     if (localStorage.idLiked) {
        //         idLike = JSON.parse(localStorage.idLiked);
        //     } else {
        //         idLike = '1';
        //     }
        //     $.post("api/paging.php", {
        //             command: 'showContent',
        //             page: dataP,
        //             idLiked: idLike
        //         })
        //         .done(function(data) {
        //             var jData = JSON.parse(data);
        //             $(".grid-container").html("");
        //             setLikes(jData.msg);
        //         });
        // }
    </script>
</body>

</html>