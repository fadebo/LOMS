<?php
    session_start();
    $userLoggedIn = $_SESSION['userLoggedIn'];
    $con = mysqli_connect("localhost","root","","loms");
    if ($_POST['groupsearchTerm']) {
    
        $userLoggedIn = mysqli_real_escape_string($con, $_SESSION['userLoggedIn']);
        $usersql = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
        if(mysqli_num_rows($usersql) > 0){
          $userrow = mysqli_fetch_assoc($usersql);
        }
       
    $groupsearchTerm = mysqli_real_escape_string($con, $_POST['groupsearchTerm']);
    $sql = "SELECT * FROM groups WHERE groupname LIKE '%{$groupsearchTerm}%' ";
    $output = "";
    $query = mysqli_query($con, $sql);
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            $userId_sent = $userrow['id'];
            $groupId = $row['id'];
            $sql2 = "SELECT * FROM groupmessages WHERE (userId_received = '$groupId'
                    OR userId_sent = '$userId_sent') AND (userId_sent = '$userId_sent' 
                    OR userId_received = '$groupId') ORDER BY id DESC LIMIT 1";
            $query2 = mysqli_query($con, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            (mysqli_num_rows($query2) > 0) ? $result = $row2['message'] : $result ="No message available";
            (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
            if(isset($row2['userId_sent'])){
                ($userId_sent == $row2['userId_sent']) ? $you = "You: " : $you = "";
            }else{
                $you = "";
            }
            ($userId_sent == $row['id']) ? $hid_me = "hide" : $hid_me = "";
    
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
    }else{
        $output .= 'No user found related to your search term';
    }
    echo $output;
    }
    
?>