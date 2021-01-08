<?php
session_start();

if (!isset($_SESSION["username"]))
{
    header('Location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tests Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require "inc/navbar.php";?>
<div class="container mt-5 d-flex flex-wrap" id="tests">

</div>
<script src="js/jquery-3.4.1.js"></script>
<script>
    $(document).ready(function(){

        fetch_tests();
        function fetch_tests(){
            $.ajax({
                url:"inc/fetch_tests.php",
                method:"post",
                success: function(data){
                    $("#tests").html(data);

                  $('.join').on('click',function(){
                    var id = $(this).attr('id').split('_');

                    $.ajax({
                        url:"inc/join.php",
                        method:"post",
                        data:{id:id[1]},
                        success:function(data){
                            if (data=="join"){
                               $('#join_'+id[1]).text("Cancel").attr('id','unjoin_'+id[1],'class','join btn btn-danger');
                               setTimeout(function(){
                                   fetch_tests();
                               },100);
                            }else{
                                $('#unjoin_'+id[1]).text("Join").attr('id','join_'+id[1],'class','join btn btn-success');
                                setTimeout(function(){
                                    fetch_tests();
                                },100);
                            }
                        }

                    });


                  });

                }
            });
        }
    });
</script>
</body>
</html>