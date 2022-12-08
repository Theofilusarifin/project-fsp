<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <a class="logout">Log Out</a>
    <div class="container">
        <div class="grid-container"></div><br>
        <div class="paging">
            <i class="fa fa-arrow-left"></i>
            <span class="pageContent"></span>
            <i class="fa fa-arrow-right"></i>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $.post("api/onload.php",
                {
                    memes: "memes",
                    username: localStorage.username
                })
                .done(function (data) {
                    var jData = JSON.parse(data);

                    if (!localStorage.idLiked) {
                        if (typeof jData.idLiked != 'undefined') {
                            const arrayLike = JSON.stringify(jData.idLiked);
                            localStorage.idLiked = arrayLike;
                        }
                    }
                    if (jData.status == 'success') {
                        $.post("api/paging.php", { command: "jumpage" })
                            .done(function (data2) {
                                var jData2 = JSON.parse(data2);
                                for (i = 1; i <= jData2.msg; i++) {
                                    $(".pageContent").append("<button onClick='page(" + i + ")'>" + i + "</button>");
                                }
                            });
                        setLikes(jData.msg);
                        // $('.item5').html(jData.msg[0].img_url);
                    } else {
                        console.log('gagal load');
                    }
                });
        });

        function like(id) {
            $.post("api/like_process.php", {
                idMeme: id,
                username: localStorage.username
            })
                .done(function (data) {
                    var jData = JSON.parse(data);
                    if (jData.status == 'success') {
                        $('#like' + id).attr("style", "color: red;");
                        $('#total_like'+id).html((parseInt($('#total_like'+id).html()) + 1));
                        $('#btnLike'+id).prop('disabled', true);
                        if (!localStorage.idLiked) {
                            var idLike = [id];
                        } else {
                            var idLike = JSON.parse(localStorage.idLiked);
                            idLike.push(id);
                        }
                        localStorage.idLiked = JSON.stringify(idLike);

                        // alert('success to like');
                    } else {
                        alert('failed to like');
                    }
                });
        }

        function page(dataP) {
            var idLike;
            if (localStorage.idLiked) {
                idLike = JSON.parse(localStorage.idLiked);
            } else {
                idLike = '1';
            }
            $.post("api/paging.php",
                {
                    command: 'showContent',
                    page: dataP,
                    idLiked: idLike
                })
                .done(function (data) {
                    var jData = JSON.parse(data);
                    $(".grid-container").html("");
                    setLikes(jData.msg);
                });
        }

        function setLikes(arrLike) {
            $.each(arrLike, function (i, val) {
                if (val['liked'] == 'yes') {
                    var color = "red";
                    var disabledStatus = 'disabled';
                } else {
                    var color = "white";
                    var disabledStatus = '';
                }
                $(".grid-container").append(
                    "<div id='item" + val['id'] + "'>" +
                    "<div>" +
                    "<img src='" + val['img_url'] + "' class='image'>" +
                    "</div>" +
                    "<div>" +
                    "<button onClick='like(" + val['id'] + ")' " + disabledStatus + " class='btnLike' id='btnLike" + val['id'] + 
                        "'><i class='fa fa-heart' id='like" + val['id'] + "' style='color: " + 
                        color + "'></i> <span id='total_like" + val['id'] + "'>" + val['total_like'] + "</span> likes</button>" +
                    "<button class='btnComment'><i class='fa fa-comment'></i></button>" +
                    "</div>" +
                    "</div>");
            });
        }
        $(".logout").click(function () {
            window.location.href = 'login.php';
        });
    </script>
</body>

</html>