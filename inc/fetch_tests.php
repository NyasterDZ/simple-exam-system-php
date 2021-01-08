<?php
session_start();
$mid= $_SESSION["id"];
require_once "config.php";
$html = '';
$status = '1';
$select = $conn->prepare("SELECT * from test");
$select->execute();
$result = $select->get_result();

if($result->num_rows > 0)
{
    while($row = $result->fetch_assoc())
    {
        $html .= '
                <div class="card m-2" style="width: 18rem;">
                <img class="card-img-top" src="img/test.png" alt="Card image cap">
                <div class="card-body text-center">
                    <h5 class="card-title">'.$row["testName"].'</h5>
                    <p class="card-text">'.$row["description"].'</p>
                    ';
                    if (isset($_SESSION["type"]) && $_SESSION["type"] !=1) {
                        $select_test = $conn->prepare("SELECT * FROM testjoin WHERE mid= ? AND tid= ? AND status = ?");
                        $select_test->bind_param("iii", $mid,$row["tid"],$status);
                        $select_test->execute();
                        $result_test = $select_test->get_result();
                        if ($result_test->num_rows == 1)
                        {
                            $html .= '<a href="#" id="unjoin_'.$row["tid"].'" class="join btn btn-danger">Cancel</a>';
                        }
                        else{
                            $html .= '<a href="#" id="join_'.$row["tid"].'" class="join btn btn-success">Join</a>';
                        }
                    }else{
                        $html .= '<a href="view_test.php?tid='.$row["tid"].'"  class="join btn btn-primary">View</a>';
                    }


          $html .= '        
                </div>
            </div>
        ';
    }
    echo $html;
}




?>