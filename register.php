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
    <label for="Nom">Nom</label>
    <input type="text" class="form-control" name="nom" id="nom" placeholder="Entrer vote nom">
  </div>

  <div class="form-group">
    <label for="prenom">Prènom</label>
    <input type="text" class="form-control" name="prenom" id="prenom"  placeholder="Entrer votre prenom">
  </div>

  <div class="form-group">
    <label for="Email">Email</label>
    <input type="text" class="form-control" name="email" id="email"  placeholder="Entrer votre email">
  </div>

  <div class="form-group">
    <label for="pseudo">Pseudo</label>
    <input type="text" class="form-control" name="pseudo" id="pseudo"  placeholder="Entrer votre pseudo">
  </div>

  <div class="form-group">
    <label for="Password">Password</label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
  </div>
  
  <div class="form-group">
    <label for="prof">Choisir: </label>
    <select class="form-control" name="prof" id="prof">
      <option value="1">Prof</option>
      <option value="2">étudiant</option>
    </select>
  </div>
  <input type="hidden" id="token" name="token">
  <button type="submit" name="submit" id="submit" class="btn btn-primary">Inscrir</button>

</div>





 <script src="js/jquery-3.4.1.js"></script>
<script src="js/notify.js"></script>
<script>
$(document).ready(function(){


 $('#submit').on('click',function(){
      
     var nom      = $('#nom').val(),
         prenom   = $('#prenom').val(),
         email    = $('#email').val(),
         pseudo   = $('#pseudo').val(),
         password = $('#password').val(),
         prof     = $('#prof').val()
    
       if (nom =='' || prenom =='' || email=='' || pseudo =='' || password=='')
       {
        alert("il y'a des champs vides");
       } 
       else
       {
          $.ajax({
           url:'inc/addM.php',
           method:'post',
           data:{nom:nom,prenom:prenom,email:email,pseudo:pseudo,password:password,prof:prof},
          success:function(data)
          {
            if(data=="Inscription complète")
            {
                $.notify(data,"success");
            }
            else
            { $.notify(data,"info");}

          }

          });
       } 


 }); 

});
</script>
</body>
</html>