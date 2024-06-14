<?php
    session_start();
    $userLoggedIn = $_SESSION['userLoggedIn'];
    $con = mysqli_connect("localhost","root","","loms");
    if ($_POST['chatsearchTerm']) {
        $userLoggedIn = mysqli_real_escape_string($con, $_SESSION['userLoggedIn']);
        $usersql = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
        if(mysqli_num_rows($usersql) > 0){
          $userrow = mysqli_fetch_assoc($usersql);
        }  
    $chatsearchTerm = mysqli_real_escape_string($con, $_POST['chatsearchTerm']);
    $sql = "SELECT * FROM users WHERE NOT username = '$userLoggedIn' AND (username LIKE '%{$chatsearchTerm}%') ";
    $output = "";
    $query = mysqli_query($con, $sql);
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            $userId_sent = $userrow['id'];
            $sql2 = "SELECT * FROM messages WHERE (userId_received = {$row['id']}
                    OR userId_sent = {$row['id']}) AND (userId_sent = '$userId_sent' 
                    OR userId_received = '$userId_sent') ORDER BY id DESC LIMIT 1";
            $query2 = mysqli_query($con, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            (mysqli_num_rows($query2) > 0) ? $result = $row2['message'] : $result ="No message available";
            (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
            if(isset($row2['userId_sent'])){
                ($userId_sent == $row2['userId_sent']) ? $you = "You: " : $you = "";
            }else{
                $you = "";
            }
            ($row['status'] == "offline") ? $offline = "offline" : $offline = "";
            ($userId_sent == $row['id']) ? $hid_me = "hide" : $hid_me = "";
    
            $output .= '<a href="message.php?user_id='. $row['id'] .'">
                        <div class="content">
                        <img src="includes/imgs/'. $row['img'] .'" alt="">
                        <div class="details">
                        <span>'. $row['username']. "(" . $row['status'] . ")". '</span>
                            <p>'. $you . $msg .'</p>
                        </div>
                        </div>
                        <div class="status-dot '. $offline .'"><i class="fa fa-circle"></i></div>
                    </a>';
        }
    }else{
        $output .= 'No user found related to your search term';
    }
    echo $output;
    }
?>
