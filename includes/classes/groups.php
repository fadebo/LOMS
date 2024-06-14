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
        $othersql = mysqli_query($con, "SELECT * FROM users WHERE NOT username = '$userLoggedIn' ORDER BY id DESC");
        if(mysqli_num_rows($othersql) > 0){
          $otherrow = mysqli_fetch_assoc($othersql);
        }
        $userId_received = $otherrow['id'];
        
    $sql = "SELECT * FROM groups ORDER BY id DESC";
    $query = mysqli_query($con, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No groups are available the moment";
    }elseif(mysqli_num_rows($query) > 0){
        
        while($row = mysqli_fetch_assoc($query)){
            $id = $row['id'];
            $sql2 = "SELECT * FROM messages WHERE groupId = '$id' ORDER BY id DESC LIMIT 1";
            $query2 = mysqli_query($con, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            
      //      $sql3 = "SELECT * FROM users WHERE groupId = '$id' AND NOT (userId_sent = '$userId_sent' OR userId_sent = '$userId_sent') ORDER BY id DESC LIMIT 1";
        //    $query3 = mysqli_query($con, $sql3);
          //  $row3 = mysqli_fetch_assoc($query3);
            
            $sql3 = mysqli_query($con, "SELECT * FROM users WHERE NOT (id = '$userId_sent' AND id = '$userId_received') ORDER BY id DESC");
            if(mysqli_num_rows($sql3) > 0){
              $sql3row = mysqli_fetch_assoc($sql3);
            }
            $userNames_received = $sql3row['username'];
            $sql4 = mysqli_query($con, "SELECT * FROM users WHERE NOT (id = '$userId_sent' OR id = '$userId_received') ORDER BY id DESC");
            if(mysqli_num_rows($sql4) > 0){
              $sql4row = mysqli_fetch_assoc($sql4);
            }
            $userName_received = $sql4row['username'];
            if(isset($row2['userId_sent'])){
                ($userId_sent == $row2['userId_sent'] && $id == $row2['groupId']) ? $you = "You: " : $you = "";
                (mysqli_num_rows($query2) > 0) ? $result = $row2['message'] : $result ="No message available";
                (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;

                if ($userId_sent != $row2['userId_sent'] && $id == $row2['groupId']) {
                    ($userId_sent != $row2['userId_sent'] && $id == $row2['groupId']) ? $you = "{$userName_received}: " : $you = "";
                (mysqli_num_rows($query2) > 0) ? $result = $row2['message'] : $result ="No message available";
                (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
                }
                if ($userId_sent != $row2['userId_sent'] && $id == $row2['groupId'] && $userId_received != $row2['userId_received']) {
                    ($userId_sent != $row2['userId_sent'] && $id == $row2['groupId'] && $userId_received != $row2['userId_received']) ? $you = "{$userNames_received}: " : $you = "";
                (mysqli_num_rows($query2) > 0) ? $result = $row2['message'] : $result ="No message available";
                (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
                }
                
            }
            else{
                $you = "";
            }
            //($userId_sent == $userrow['id']) ? $hid_me = "hide" : $hid_me = "";
    
            $output .= '<a href="group.php?group_id='. $row['id'] .'">
                        <div class="content">
                        <img src="includes/imgs/'. $row['group_img'] .'" alt="">
                        <div class="details">
                            <span>'. $row['groupname']. '</span>
                            <p>'. $you . $msg .'</p>
                        </div>
                        </div>
                    </a>';
        }
    }
    echo $output;
?>