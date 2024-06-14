<?php
    session_start();
    $userLoggedIn = $_SESSION['userLoggedIn'];
    $con = mysqli_connect("localhost","root","","loms");
        $userLoggedIn = mysqli_real_escape_string($con, $_SESSION['userLoggedIn']);
        $usersql = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
        if(mysqli_num_rows($usersql) > 0){
          $userrow = mysqli_fetch_assoc($usersql);
        }
        $userId_sent = $userrow['id'];
    $sql = "SELECT * FROM users WHERE NOT username = '$userLoggedIn' ORDER BY id DESC";
    $query = mysqli_query($con, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available the moment";
    }elseif(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            $id = $row['id'];
            $sql2 = "SELECT * FROM messages WHERE (userId_received = '$id'
                    OR userId_sent = '$id') AND (userId_sent = '$userId_sent' 
                    OR userId_received = '$userId_sent') AND groupId = 0 ORDER BY id DESC LIMIT 1";
            $query2 = mysqli_query($con, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            (mysqli_num_rows($query2) > 0) ? $result = $row2['message'] : $result ="No message available";
            (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
            if(isset($row2['userId_sent'])){
                ($userId_sent == $row2['userId_sent']) ? $you = "You: " : $you = "";
            }else{
                $you = "";
            }
            if ($row['status'] == "offline") {
              $statusd =  '<div class="status-dot offline" style="color:#ccc;"><i class="fa fa-circle"></i></div>';
            }elseif ($row['status'] == "busy") {
                $statusd = '<div class="status-dot busy " style="color:#f4ec0b;""><i class="fa fa-circle"></i></div>';
            }elseif ($row['status'] == "disturb") {
                $statusd = '<div class="status-dot disturb" style="color:#130bf4;"><i class="fa fa-circle"></i></div>';
            }else{
                $statusd = '<div class="status-dot" style="color:#468669;"><i class="fa fa-circle"></i></div>';
            }

          //  ($row['status'] == "offline") ? $offline = "offline" : $offline = "";
            //($row['status'] == "busy") ? $busy = "busy" : $busy = "";
            //($row['status'] == "disturb") ? $disturb = "disturb" : $disturb = "";
            //($userId_sent == $row['id']) ? $hid_me = "hide" : $hid_me = "";
    
            $output .= '<a href="message.php?user_id='. $row['id'] .'">
                        <div class="content">
                        <img src="includes/imgs/'. $row['img'] .'" alt="">
                        <div class="details">
                            <span>'. $row['username']. "(" . $row['status'] . ")". '</span>
                            <p>'. $you . $msg .'</p>
                        </div>
                        </div>'. $statusd .'
                        
                    </a>';
        }
    }
    echo $output;
?>