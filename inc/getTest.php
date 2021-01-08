<?php
$fetch = $_POST["fetch"];
$data ='';
if(isset($fetch) && $fetch == 'fetch')
{
    require_once "config.php";
    $selectTest = $conn->prepare("SELECT * FROM test");
    $selectTest->execute();
    $result = $selectTest->get_result();
    if($result->num_rows > 0 )
    {
        while( $row = $result->fetch_assoc())
        {
            $data .='<option value="'.$row["tid"].'">'.$row["testName"].'</option>';
        }
        echo $data;
    }
    else{
        echo"pas de test pour le moment";
    }

}