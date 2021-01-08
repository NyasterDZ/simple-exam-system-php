<?php
session_start();
require "inc/config.php";
$tid = $_GET["tid"];
$mid = $_SESSION["id"];
$status = 1;
$select_qa = $conn->prepare("SELECT * FROM qa WHERE tid = ?");
$select_qa->bind_param("i",$tid);
$select_qa->execute();
$result_qa = $select_qa->get_result();


$select_test= $conn->prepare("SELECT numqa FROM test WHERE tid = ?");
$select_test->bind_param("i",$tid);
$select_test->execute();
$result_test = $select_test->get_result();


if($result_test->num_rows == 1) {
    $row_test = $result_test->fetch_assoc();
    $select_test_join = $conn->prepare("SELECT note FROM testjoin WHERE tid = ? AND mid= ? AND status = ?");
    $select_test_join->bind_param("iii", $tid, $mid,$status);
    $select_test_join->execute();
    $result_test_join = $select_test_join->get_result();
    if ($result_test_join->num_rows == 1) {
        $row_test_join = $result_test_join->fetch_assoc();
        if ($row_test_join["note"] != 0) {
            echo "vous avez passé ce test";
            exit();
        } else {
            if (isset($_POST["submit"])) {
                $cmpt = 1;
                $score = 0;
                $error = '';
                for ($i = 1; $i <= $row_test["numqa"]; $i++) {
                    $answers[$i] = $_POST["qa_" . $i];
                }
                while ($row_qa2 = $result_qa->fetch_assoc()) {
                    if ($row_qa2["answer"] == $answers[$cmpt]) {
                        $score += $row_qa2["point"]; // score = score + row_qa2["note"]
                        $error .= "<b style='color:green;'>La question '.$cmpt.' est correcte <br></b> ";

                    } else {
                        $error .= "<b style='color:red;'>La question '.$cmpt.' est incorrecte <br></b> ";

                    }
                    $cmpt++;
                }
                $update_score = $conn->prepare("UPDATE testjoin SET note = ? WHERE mid = ? AND tid = ?");
                $update_score->bind_param("iii", $score, $mid, $tid);
                $update_score->execute();

            }
        }
    }
    else{
            echo "vous n'avez pas participé a ce test";
            exit();
        }
}
else{
    echo"pas de test avec cet id";
    exit();
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
<?php require "inc/navbar.php"; ?>
<div class="container">
    <?php if(isset($error) && $error !='') {?>
        <div class="alert alert-primary" role="alert">
            <?php echo $error;?>
        </div>
    <?php }?>
    <form action="" method="post">
        <?php
        $cpt = 1;
        if($result_qa->num_rows > 0 ){
            while ($row_qa = $result_qa->fetch_assoc()){
                ?>
                <div class="form-group">
                    <label><?php echo $row_qa["question"];?></label>
                    <input type="text" name="qa_<?php echo $cpt;?>" class="form-control"  placeholder="Entrer la réponse ">
                </div>
            <?php
            $cpt++;
            }
        }else{
            echo "Le test est vide pour l'instant";
        }
        ?>
        <?php
        if(!isset($_POST["submit"]) && ($row_test_join["note"] ==0)){
        ?>
        <input type="submit" name="submit" class="btn btn-success" value="Valider">
        <?php } ?>
    </form>
</div>
</body>
</html>