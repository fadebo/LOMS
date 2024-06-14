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
        $output = "";
        $sql = "SELECT * FROM messages LEFT JOIN users ON users.id = messages.userId_sent
                WHERE messages.groupId = '$group_id' ORDER BY messages.id";
        $query = mysqli_query($con, $sql);

        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['userId_sent'] == $userId_sent){
                    $output .= '<div class="chat sending">
                                <div class="details">
                                    <p>'. $row['message'] .'</p>
                                </div>
                                </div>';
                }
                else{
                    $output .= '<div class="chat receiving">
                                <img src="includes/imgs/'.$row['img'].'" alt="">
                                <div class="details">
                                    <p>'. $row['message'] .'</p>
                                </div>
                                </div>';
                }
            }
        }else{
            $output .= '<div class="text">No messages are available.</div>';
        }
        echo $output;
    }else{
        header("location: login.php");
    }

?>