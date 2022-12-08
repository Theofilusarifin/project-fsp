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
    <div class="grid-container"></div>
    <div class="paging">
        <i class="fa fa-arrow-left"></i>
        <span class="pageContent"></span>
        <i class="fa fa-arrow-right"></i>
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
                    if (jData.status == 'success') {
                        $.post("api/paging.php", { command: "jumpage" })
                            .done(function (data2) {
                                var jData2 = JSON.parse(data2);
                                for (i = 1; i <= jData2.msg; i++) {
                                    $(".pageContent").append("<a href='#' class='page'>" + i + "</a>");
                                }
                            });
                        $.each(jData.msg, function (i, val) {
                            if(val['liked'] == 'yes'){
                                var color = "red";
                            } else {
                                var color = "white";
                            }
                            $(".grid-container").append(
                                "<div id='item" + val['id'] + "'>" +
                                "<div>" +
                                "<img src='" + val['img_url'] + "' class='image'>" +
                                "</div>" +
                                "<div>" +
                                "<button onClick='like(" + val['id'] + ")'><i class='fa fa-heart' id='like" + val['id'] + "' style='color: " + color +"'></i></button>" +
                                "<button><i class='fa fa-comment'></i></button>" +
                                "</div>" +
                                "</div>");
                        });
                        // $('.item5').html(jData.msg[0].img_url);
                    } else {
                        console.log('gagal load');
                    }
                });
        });

        function like(id){
            $.post("api/like_process.php", {
                idMeme: id
            })
            .done(function(data){
                var jData = JSON.parse(data);
                if(jData.status == 'success'){
                    $('#like' + id).attr("style", "color: red;");
                    // alert('success to like');
                } else{
                    alert('failed to like');
                }
            });
        }

        $(".page").click(function (event) {
            event.preventDefault();

            var dataP = $(this).html();
            $.post("api/paging.php",
                {
                    command: 'showContent',
                    page: dataP
                })
                .done(function (data) {
                    var jData = JSON.parse(data);
                    $(".grid-container").html();
                    $.each(jData.msg, function (i, val) {
                        $(".grid-container").append(
                            "<div id='item" + i + "'>" +
                            "<div>" +
                            "<img src='" + val['img_url'] + "' class='image'>" +
                            "</div>" +
                            "<div>" +
                            "<i class='fa fa-heart'>" +
                            "<i class='fa fa-comment'>" +
                            "</div>" +
                            "</div>"
                        );
                    });
                });
        });
    </script>
</body>

</html>