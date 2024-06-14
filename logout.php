<?php
session_start();

if(isset($_GET['logout_id'])){
    $con = mysqli_connect("localhost","root","","loms");
    $userLoggedOut = mysqli_real_escape_string($con, $_GET['logout_id']);
    if(isset($userLoggedOut)){
        $sql = mysqli_query($con, "UPDATE users SET status = 'offline' WHERE username= '$userLoggedOut'");
        if($sql){
            session_unset();
            session_destroy();
            header("location: login.php");
        }
    }else{
        header("location: index.php");
    } 
}else{  
    header("location: login.php");
}
session_destroy();
?>