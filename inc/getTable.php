<?php
$fetch = $_POST["fetch"];
$data ='';
if(isset($fetch) && $fetch == 'fetch')
{
    require_once "config.php";
    $selectTable = $conn->prepare("SELECT * FROM test");
    $selectTable->execute();
    $result = $selectTable->get_result();
    if($result->num_rows > 0 )
    {
        while( $row = $result->fetch_assoc())
        {
            $data .='<tr>
                       <td>'.$row["tid"].'</td>
                       <td>'.$row["testName"].'</td>
                       <td>'.$row["numqa"].'</td>
                       <td>'.$row["part"].'</td>
                      </tr>';
        }
        echo $data;
    }
    else{
        echo"pas de test pour le moment";
    }

}