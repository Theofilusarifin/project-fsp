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
                    memes: "memes"
                })
                .done(function (data) {
                    var jData = JSON.parse(data);
                    if (jData.status == 'success') {
                        $.post("api/paging.php", { command: "jumpage" })
                            .done(function (data2) {
                                var jData2 = JSON.parse(data2);
                                // console.log(jData2.msg);
                                for (i = 1; i <= jData2.msg; i++) {
                                    $(".pageContent").append("<a href='#' class='page'>" + i + "</a>");
                                }
                            });
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
                                "</div>");
                        });
                        // $('.item5').html(jData.msg[0].img_url);
                    } else {
                        console.log('gagal load');
                    }
                });
        });

        $(".page").click(function(event) {
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
                    // $.each(jData.msg, function (i, val) {
                    //     $(".grid-container").append(
                    //         "<div id='item" + i + "'>" +
                    //         "<div>" +
                    //         "<img src='" + val['img_url'] + "' class='image'>" +
                    //         "</div>" +
                    //         "<div>" +
                    //         "<i class='fa fa-heart'>" +
                    //         "<i class='fa fa-comment'>" +
                    //         "</div>" +
                    //         "</div>"
                    //     );
                    // });
                });
        });
    </script>
</body>

</html>