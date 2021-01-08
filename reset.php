<?php
session_start();
require_once "inc/config.php";
if (isset($_SESSION["username"]))
{
    header('Location:profile.php');
}
if (isset($_POST["send"]))
{
    $error = '';
    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $verfiyEmail = mysqli_query($conn,"SELECT email FROM members  WHERE email='".$email."'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($verfiyEmail);

    if ($count == 1)
    {
            $token = bin2hex(random_bytes(60));
            $updateToken = mysqli_query($conn,"UPDATE members SET token='".$token."',
                                        tokenDate=NOW()
                                        WHERE email='".$email."'") or die(mysqli_error($conn));
        if ($updateToken)
        {
            $to ="$email";
            $subject = "Reset Password";
            $txt = "http://localhost:8080/mp11/forget.php?email=".$email."&token=".$token;
            $headers = "From:admin@galaxyprog.com";
            $send = mail($to,$subject,$txt,$headers);
            if ($send)
            {
                $error = "verifier votre boite email";
            }
        }
    }
    else
    {
        $error = "pas d'email ...";
    }
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
<h1>Reset.php</h1>

<form action="" method="post">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control"  placeholder="Entrer votre email ">
        </div>
        <?php if(isset($error))
        {
        ?>
        <div class="info alert alert-primary" role="alert">
            <?php echo $error;?>
        </div>
        <?php } ?>
        <button type="submit" name="send" class="btn btn-primary">Envoyer</button>

</form>

</div>


</body>
</html>