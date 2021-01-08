<?php
session_start();
if((isset($_SESSION["type"]) && $_SESSION["type"] != 1) || !isset($_SESSION["type"]))
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
    <title>Tests Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require "inc/navbar.php";
require "inc/config.php";
?>

<div class="container">
    <?php
    $tid = $_GET["tid"];
    $select_test = $conn->prepare("SELECT tid FROM test WHERE tid = ?");
    $select_test->bind_param("i",$tid);
    $select_test->execute();
    $result_test = $select_test->get_result();
    if($result_test->num_rows == 0){
        echo "Ce test n'existe pas";
    }
    else{
        ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">question</th>
                <th scope="col">Answer</th>
                <th scope="col">Point</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $select_qa = $conn->prepare("SELECT * FROM qa WHERE tid=?");
            $select_qa->bind_param("i",$tid);
            $select_qa->execute();
            $result_qa = $select_qa->get_result();
            if($result_qa->num_rows == 0)
            {
                echo "Pas de Q/A pour l'instant";
            }
            else{
                 while($row = $result_qa->fetch_assoc()){
                     ?>
                     <tr>
                         <th scope="row"><?php echo $row["qaid"];?></th>
                         <td><?php echo $row["question"];?></td>
                         <td><?php echo $row["answer"];?></td>
                         <td><?php echo $row["point"];?></td>
                     </tr>
            <?php
                 }
            }
            ?>

            </tbody>
        </table>
    <?php
    }
    ?>

</div>
</body>
</html>