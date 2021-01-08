<?php
session_start();

    require "config.php";

    
    $pseudo   = $_POST["pseudo"];
    $password = $_POST["password"];
    $error    = '';
    
    if ( empty($pseudo) || empty($password))
    {
      $error = "<b style='color:red;'>ll y'a des champs vides </b>";
    }
    else
    {    
       /*
          $selectM = mysqli_query($conn,"SELECT * FROM members WHERE username='".$pseudo."'")
                     or die (mysqli_error($conn));
          $numM   = mysqli_num_rows($selectM);   
          $fetchM = mysqli_fetch_assoc($selectM);
          $pass   = $fetchM["password"];
    */
        $selectM = $conn->prepare("SELECT * FROM members WHERE (username= ? OR email= ?) ");
        $selectM->bind_param("ss",$pseudo,$pseudo);
        $selectM->execute();
        $result = $selectM->get_result();

          if ($result->num_rows === 1)
          {
              $fetchM = $result->fetch_assoc();
              $pass   = $fetchM["password"];
             if (password_verify($password,$pass))
             {
              $_SESSION["username"] = $fetchM["username"];
              $_SESSION["id"]       = $fetchM["mid"];
              $_SESSION["type"]     = $fetchM["type"];
              $error = "<b style='color:green;'>Ok</b>";
             }
             else
             {
              $error = "<b style='color:red;'>mot de passe incorrecte</b>";
             }
           
          }   
          else
          {
            $error = "<b style='color:red;'> le pseudo/Email est incorrecte </b>";
          }     
        
     
    }


echo $error;




?>