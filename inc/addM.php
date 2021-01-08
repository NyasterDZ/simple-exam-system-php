<?php

    require "config.php";

    $nom      = $_POST["nom"];
    $prenom   = $_POST["prenom"];
    $email    = $_POST["email"];
    $pseudo   = $_POST["pseudo"];
    $password = $_POST["password"];
    $prof     = $_POST["prof"];
    $error    = '';
    
    if (empty($nom) || empty($prenom) || empty($email) || empty($pseudo) || empty($password))
    {
      $error = "ll y'a des champs vides";
    }
    else
    {
         if (strlen($pseudo) < 4)
         {
           $error = "le pseudo doit contenir plus que 3 caractères";
         }
         if (!preg_match('/^[a-zA-Z0-9]+$/',$pseudo))
         {
           $error .= "le pseudo doit contenir des chiffres et des lettres seulement";
         }
         if (is_numeric($pseudo[0]))
         {
           $error .= "le pseudo ne doit pas commencer par un chiffre";
           
         }
         if (strlen($password) < 8)
         {
           $error .= "le mot de passe doit contenir plus que 7 caractères";
         }
         if (!filter_var($email,FILTER_VALIDATE_EMAIL))
         {
          $error .= "l'email est incorrecte";
         }

        if (empty($error))
        {
          $pass = password_hash($password,PASSWORD_BCRYPT);
          /*
          $selectM = mysqli_query($conn,"SELECT username,email FROM members WHERE username='".$pseudo."' OR email='".$email."'")
                     or die (mysqli_error($conn));
          $numM   = mysqli_num_rows($selectM);
           */
          $selectM = $conn->prepare("SELECT username,email FROM members WHERE username= ? OR email = ?");
          $selectM->bind_param("ss",$pseudo,$email);
          $selectM->execute();
          $result = $selectM->get_result();

          if ($result->num_rows == 0)
          {
              /*
            $insertM = mysqli_query($conn,"INSERT INTO members(nom,prenom,email,username,password,type)
                     VALUES('$nom','$prenom','$email','$pseudo','$pass','$prof') 
               ")  or die (mysqli_error($conn));
            */
              $insertM = $conn->prepare("INSERT INTO members(nom,prenom,email,username,password,type) VALUES(?,?,?,?,?,?)");
              $insertM->bind_param("sssssi",$nom,$prenom,$email,$pseudo,$pass,$prof);
               if ($insertM->execute())
               {
                $error = "Inscription complète";
               }
               else
               {
                $error = "Inscription incomplète";
               }
          }   
          else
          {
            $error = "ce pseudo existe/Cet email existe";
          }     
        } 
     
    }
  echo $error;

?>