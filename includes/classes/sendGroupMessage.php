<?php 
    session_start();
    if(isset($_SESSION['userLoggedIn'])){
        $con = mysqli_connect("localhost","root","","loms");
        $userLoggedIn = mysqli_real_escape_string($con, $_SESSION['userLoggedIn']);
        $usersql = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
        if(mysqli_num_rows($usersql) > 0){
          $userrow = mysqli_fetch_assoc($usersql);
        }
        $othersql = mysqli_query($con, "SELECT * FROM users WHERE NOT username = '$userLoggedIn' ORDER BY id DESC");
        if(mysqli_num_rows($othersql) > 0){
          $otherrow = mysqli_fetch_assoc($othersql);
        }
        $userId_received = $otherrow['id'];
        $userId_sent = $userrow['id'];
        $group_id = mysqli_real_escape_string($con, $_POST['group_id']);
        $message = mysqli_real_escape_string($con, $_POST['message']);
        if(!empty($message)){
            $sql = mysqli_query($con, "INSERT INTO messages (userId_received, userId_sent, groupId, message)
                                        VALUES ('$userId_received', '$userId_sent', '$group_id','$message')") or die();
        }

    }else{
        header("location: login.php");
    }

 
?>