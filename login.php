<?php
session_start();
if(isset($_SESSION["username"]))
{
   header('Location:profile.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require "inc/navbar.php";?>

<div class="container">



  <div class="form-group">
    <label for="pseudo">Pseudo</label>
    <input type="text" class="form-control" name="pseudo" id="pseudo"  placeholder="Entrer votre pseudo">
  </div>

  <div class="form-group">
    <label for="Password">Password</label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
  </div>

  <div class="infos alert alert-primary" role="alert">
  </div>

  <button type="submit" name="submit" id="submit" class="btn btn-primary">Entrer</button>

</div>





 <script src="js/jquery-3.4.1.js"></script>  
<script>
$(document).ready(function(){
  
    $('.infos').css('display','none');

$('#submit').on('click',function(){
     
    var pseudo   = $('#pseudo').val(),
        password = $('#password').val();
       
   
      if ( pseudo =='' || password=='')
      {
       alert("il y'a des champs vides");
      } 
      else
      {
         $.ajax({
          url:'inc/loginM.php',
          method:'post',
          data:{pseudo:pseudo,password:password},
         success:function(data)
         {
            $('.infos').css('display','block');
             if (data =="<b style='color:green;'>Ok</b>")
             {
                  
                    $('.infos').html(data);
                    setTimeout("window.location.href='profile.php'",2000);
             }
             else
             {
                    
                    $('.infos').html(data);
             }
          
         }

         });
      } 


}); 

});

</script>
</body>
</html>