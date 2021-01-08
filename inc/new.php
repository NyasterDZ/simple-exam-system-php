<?php
session_start();
require_once "config.php";
$mid = $_SESSION["id"];
$typeAction = $_POST["typeAction"];

if (isset($_POST["typeAction"]) && $_POST["typeAction"] =='test')
{

    $testName       = $_POST["testName"];
    $description    = $_POST["description"];
    if(empty($testName))
    {
        echo"le champ test name est vide";
    }
    else
    {
      /*
        $insertTest = mysqli_query($conn,"INSERT INTO test(mid,testName,description,numqa,part)
                                   VALUES('$mid','$testName','$description','0','0')") or die(mysqli_error($conn));
    */
        $insertTest = $conn->prepare("INSERT INTO test(mid,testName,description,numqa,part)
                                            VALUES(?,?,?,'0','0')");
        $insertTest->bind_param("iss",$mid,$testName,$description);
        if ($insertTest->execute())
        {
            echo"test ajouté...";
        }
        else
        {
            echo"test non ajouté...";
        }

    }
}
if(isset($_POST["typeAction"]) && $_POST["typeAction"] =='qa')
{
$testName = $_POST["testName"];
$question = $_POST["question"];
$answer   = $_POST["answer"];
$point    = $_POST["point"];

if (empty($question) || empty($answer) || empty($point))
{
    echo "il y'a des champs vides";
}else{

    try {
        $addQa = $conn->prepare("INSERT INTO qa(mid,tid,question,answer,point)
                                    VALUES(?,?,?,?,?)");
        $addQa->bind_param("iissi",$mid,$testName,$question,$answer,$point);
        $addQa->execute();
        //
        $selectQa = $conn->prepare("SELECT * FROM qa WHERE tid= ? ");
        $selectQa->bind_param("i",$testName);
        $selectQa->execute();
        $result = $selectQa->get_result();
        $numQa = $result->num_rows;
        $updataQa = $conn->prepare("UPDATE test SET numqa= ? WHERE tid = ?");
        $updataQa->bind_param("ii",$numQa,$testName);
        $updataQa->execute();
        echo"paire question/reponse ajouté";
    }catch (Exception $e){
        echo $e->getMessage();
    }

}



}



?>