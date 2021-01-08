<?php

if (isset($_GET["email"]) && isset($_GET["token"]))
{
    require_once("inc/config.php");
    $error = "";
    $email = mysqli_real_escape_string($conn,$_GET['email']);
    $token = mysqli_real_escape_string($conn,$_GET['token']);
    $verifyTokenEmail = mysqli_query($conn,"SELECT * FROM members WHERE email='".$email."'
                                AND token='".$token."' AND tokenDate > DATE_SUB(NOW(), INTERVAL 30 MINUTE)") or die(mysqli_error($conn));

    $count = mysqli_num_rows($verifyTokenEmail);
    if ($count ==1)
    {
            if (isset($_POST["change"]))    
            {
                $password  = mysqli_real_escape_string($conn,$_POST['pswd']);
                $cpassword = mysqli_real_escape_string($conn,$_POST['cpswd']);  
                if ((empty($password) || empty($cpassword)) || ($password != $cpassword))  
                {
                    $error = "les champs vides / mot de passe non identique";
                }
                if (strlen($password) < 8)
                {
                    $error .= "le mot de passe doit contenir plus que 7 caractères";
                }
                if(empty($error))
                {
                    $pass = password_hash($password,PASSWORD_BCRYPT);
                    $updatePassword = mysqli_query($conn,"UPDATE members SET password='".$pass."'
                                          WHERE email='".$email."' ") or die(mysqli_error($conn));
                  if ($updatePassword)
                  {
                    $updateToken = mysqli_query($conn,"UPDATE members SET token=NULL
                    WHERE email='".$email."'")  or die (mysqli_error($conn));
                    if ($updateToken)
                        {
                            $error = "ok!!!!";
                        }
                    else
                    {
                        $error ="erreur !!!!";
                    }
                  }
                  else
                  {
                    $error = "probleme de changement du mot de passe";
                  }
                }
            }
    }
    else
    {
      header("Location:login.php");
      exit();
    }


}
else
{
 header("Location:login.php");
 exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Changer Votre mot de passe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require "inc/navbar.php";?>
<div class="container">
   
   <form action="" method="post">
   <div class="form-group">
     <label for="username">Nouveau Mot de passe</label>
     <input type="password" name="pswd" class="form-control"  placeholder="Entrer votre nouveau mot de passe ">
   </div>
   <div class="form-group">
     <label for="password">confirmation</label>
     <input type="password" name="cpswd" class="form-control"  placeholder="confirmation ">
   </div>
   <?php if($error != '')
   {
   ?>
   <div class="info alert alert-primary" role="alert">
       <?php echo $error;?>
   </div>
   <?php } ?>
   <button type="submit" name="change" class="btn btn-primary">changement le mot de passe</button>
</form>
</div>
</body>
</html>