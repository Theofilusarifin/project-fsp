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
        <div class="pagination-container">
            <div class="pagination" id="pagination">
                <!-- Get data from ajax -->
            </div>
        </div>
    </div>

    <script>
        // page 1 as default
        var page = 1
        // Document ready
        $(() => {
            // Get pagination on page 1 as default
            pagination(page)
        });

        // Get memes function
        const get_memes = (page) => {
            $.ajax({
                // URL Absolute Path
                // url: 'https://trivialteam.000webhostapp.com/api/get_memes.php',
                url: 'api/get_memes.php',

                type: 'POST',
                data: {
                    data_page: 12,
                    page: page,
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
        }

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

        // Pagination Function
        const pagination = (selected_page) => {
            $.ajax({
                // URL Absolute Path
                // url: 'https://trivialteam.000webhostapp.com/api/count_memes.php',
                url: 'api/count_memes.php',

                type: 'POST',
                data: {},
                success: (response) => {
                    var response = JSON.parse(response)
                    // Success retrieve data
                    if (response.status == 'success') {
                        // Define variable
                        total_data = response.msg
                        var max_page = total_data / 12
                        page = selected_page;

                        // Get memes on selected page
                        get_memes(page)
                        var temp = ""

                        // Show left arrow
                        if (page > 1) {
                            temp += `<a><i class="fa-solid fa-arrow-left pagination-arrow" onclick="pagination(${page-1})"></i></a>`
                        } else {
                            temp += `<a class="arrow-disabled"><i class="fa-solid fa-arrow-left pagination-arrow arrow-disabled"></i></a>`
                        }
                        // Show before page is available
                        if (page - 1 > 0) {
                            temp += `<a onclick="pagination(${page-1})">${page-1}</a>`
                        }
                        // Show current page
                        temp += `<a class="active">${page}</a>`
                        // Show next page is available
                        if (page + 1 < max_page + 1) {
                            temp += `<a onclick="pagination(${page+1})">${page+1}</a>`
                        }
                        // Show right arrow
                        if (page < max_page) {
                            temp += `<a><i class="fa-solid fa-arrow-right pagination-arrow" onclick="pagination(${page+1})"></i></a>`
                        } else {
                            temp += `<a class="arrow-disabled"><i class="fa-solid fa-arrow-right pagination-arrow arrow-disabled"></i></a>`
                        }
                        // Update pagination using jquery
                        $("#pagination").html(temp)
                    }
                    // Show error message 
                    else {
                        alert(response.msg)
                    }
                }
            });
        }
    </script>
</body>

</html>