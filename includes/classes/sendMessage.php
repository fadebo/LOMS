<?php 
    session_start();
    if(isset($_SESSION['userLoggedIn'])){
        $con = mysqli_connect("localhost","root","","loms");
        $userLoggedIn = mysqli_real_escape_string($con, $_SESSION['userLoggedIn']);
        $usersql = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
        if(mysqli_num_rows($usersql) > 0){
          $userrow = mysqli_fetch_assoc($usersql);
        }
        $userId_sent = $userrow['id'];
        $userId_received = mysqli_real_escape_string($con, $_POST['userId_received']);
        $message = mysqli_real_escape_string($con, $_POST['message']);
        if(!empty($message)){
            $sql = mysqli_query($con, "INSERT INTO messages (userId_received, userId_sent, message)
                                        VALUES ('$userId_received', '$userId_sent', '$message')") or die();
        }

    }else{
        header("location: login.php");
    }

 
?>