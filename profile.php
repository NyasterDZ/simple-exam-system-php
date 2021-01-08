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
    <title>Register Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require "inc/navbar.php";
require "inc/config.php";
?>
<div class="container d-flex m-5 flex-wrap">
  <?php
  $mid = $_SESSION["id"];
  $status =1;
  if (isset($_SESSION["type"]) && $_SESSION["type"] !=1) {
      $select = $conn->prepare("SELECT tid FROM testjoin WHERE mid= ? AND status = ?");
      $select->bind_param("ii",$mid,$status);
      $select->execute();
      $reslut = $select->get_result();
      if ($reslut->num_rows > 0 )
      {
          while($row = $reslut->fetch_assoc()) {
              $id_test = $row["tid"];
              $select_test = $conn->prepare("SELECT * FROM test WHERE tid = ?");
              $select_test->bind_param("i",$id_test);
              $select_test->execute();
              $result_test = $select_test->get_result();
              if($result_test->num_rows > 0 ){
                  while($row_test = $result_test->fetch_assoc()){
                      ?>
                      <div class="card m-2">
                          <img class="card-img-top" src="img/test.png" alt="Card image cap">
                          <div class="card-body text-center">
                              <h5 class="card-title"><?php echo $row_test["testName"];?></h5>
                              <p class="card-text"><?php echo $row_test["description"];?></p>
                              <a href="qa.php?tid=<?php echo $row_test["tid"];?>"  class="join btn btn-primary">Start</a>
                          </div>
                      </div>
                      <?php
                  }
              }else {
                  echo "Pas de Résultat";
              }
          }
      }else{
          echo "Pas de Résultat";
      }
  }
  else{
      $select_test = $conn->prepare("SELECT * FROM test WHERE mid = ?");
      $select_test->bind_param("i",$mid);
      $select_test->execute();
      $result_test = $select_test->get_result();
      if($result_test->num_rows > 0 ){
          while($row_test = $result_test->fetch_assoc()){
              ?>
              <div class="card m-2">
                  <img class="card-img-top" src="img/test.png" alt="Card image cap">
                  <div class="card-body text-center">
                      <h5 class="card-title"><?php echo $row_test["testName"];?></h5>
                      <p class="card-text"><?php echo $row_test["description"];?></p>
                      <a href="view_test.php?tid=<?php echo $row_test["tid"];?>"  class="join btn btn-primary">View</a>
                  </div>
              </div>
              <?php
          }
      }else {
          echo "Pas de Résultat";
      }
  }

  ?>



</div>
</body>
</html>