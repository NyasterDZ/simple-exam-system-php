<?php
session_start();
require "config.php";
$mid = $_SESSION["id"];
$tid = $_POST["id"];

$note = 0;

$select_test = $conn->prepare("SELECT * FROM testjoin WHERE mid= ? AND tid = ?");
$select_test->bind_param("ii",$mid,$tid);
$select_test->execute();
$result = $select_test->get_result();
$fetch = $result->fetch_assoc();

if($result->num_rows== 1 && ($fetch["status"] == 1)){
    $status = 0;
    $update = $conn->prepare("UPDATE testjoin SET status = ? WHERE mid= ? AND tid = ?");
    $update->bind_param("iii", $status,$mid,$tid);
    if($update->execute()){
        echo"unjoin";
    }
}elseif($result->num_rows== 1 && ($fetch["status"] == 0)){
    $status = 1;
    $update = $conn->prepare("UPDATE testjoin SET status = ? WHERE mid= ? AND tid = ?");
    $update->bind_param("iii", $status,$mid,$tid);
    if($update->execute()){
        echo"join";
    }

}else {
    $status = 1;
    $insert = $conn->prepare("INSERT INTO testjoin(tid,mid,status,note) VALUES(?,?,?,?)");
    $insert->bind_param("iiii",$tid,$mid,$status,$note);
    if($insert->execute())
    {
        echo"join";
    }
}






?>