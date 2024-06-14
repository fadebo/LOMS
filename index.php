<?php
include_once("includes/classes/config.php");


if(!isset($_SESSION["userLoggedIn"])) {
    header("Location: login.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];
$_SESSION["username"] = $userLoggedIn;


if(isset($_POST["submitButton"])) {
    $con = mysqli_connect("localhost","root","","loms");
    $status = mysqli_real_escape_string($con, $_POST["status"]);
    $username = mysqli_real_escape_string($con, $_SESSION['userLoggedIn']);
    if(isset($status)){
        $sql = mysqli_query($con, "UPDATE users SET status = '$status' WHERE username= '$username'");
    }else{
        header("location: index.php");
    }
}
?> 
<?php include('includes/classes/header.php') ?>
<body>
  <div class="wrapper"> 
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $con = mysqli_connect("localhost","root","","loms");
            $sql = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
          ?>
          <img src="includes/imgs/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <span><?php echo $row['firstName']. " " . $row['lastName'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <a href="logout.php?logout_id=<?php echo $row['username']; ?>" class="logout">Logout</a>
      </header>

    <div class="tabs">
        <ul class="tabs-list">
            <li class="active"><a href="#Chats">Chats</a></li>
            <li ><a href="#Groups">Groups</a></li>
            <li ><a href="#Settings">Settings</a></li>
        </ul>
       <div id= "Chats" class="tab active">
        <div class="search chat">
            <span class="text">Select a user to start chatting</span>
            <input type="text" placeholder="Enter name to search...">
            <button><i class="fa fa-search"></i></button>
        </div>
            <div class="users-list"></div>
        </div>
      <div id= "Groups" class="tab">
            <div class="search group">
            <span class="text">Select a group to start chatting</span>
            <input type="text" placeholder="Enter group to search...">
            <button><i class="fa fa-search"></i></button>
        </div>
            <div class="group-list"></div>
      </div>
      <div id= "Settings" class="tab">
        <div class="settings">
        <form method="POST">
            <h4>Change your profile status</h4>
            <div class="container input">
                <label>Status</label>
                <select class="form-control" name="status"> 
                    <option disabled=''>Select Status</option> 
                    <option value="online">Online</option>
				    <option value="offline">Offline</option>
				    <option value="busy">Busy</option>
                    <option value="disturb">Do not Disturb</option>
                </select>
            </div>
            <div class="container button">
                <button type="submit" name="submitButton">
                     Submit
                </button>
            </div>
        </form>
        </div>
      </div>
    </div>
    </section>
  </div>
  <style>
 .tab .settings form .container{
    display: flex;
    margin-bottom: 10px;
    flex-direction: column;
    position: relative;
  }
  .tab .settings form .container label{
    margin-bottom: 2px;
  }
  .tab .settings form .button button{
    height: 45px;
    border: none;
    color: #fff;
    font-size: 17px;
    background: #333;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 13px;
  }
  .tab .settings form .input select{
    height: 40px;
    width: 100%;
    font-size: 16px;
    padding: 0 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
    .tab .settings form .container input{
  outline: none;
}
    .tab .users-list a .status-dot .busy{
    color: #f4ec0b;
  }
  .tab .users-list a .status-dot .disturb{
    color: #130bf4;
  }
  .tab .users-list a:hover, .tab .group-list a:hover{
      background-color: #ccc;
  }
  </style>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  <script type="text/javascript">
$(document).ready(function(){

  $(".tabs-list li a").click(function(e){
     e.preventDefault();
  });

  $(".tabs-list li").click(function(){
     var tabid = $(this).find("a").attr("href");
     $(".tabs-list li,.tabs div.tab").removeClass("active");   // removing active class from tab

     $(".tab").hide();   // hiding open tab
     $(tabid).show();    // show tab
     $(this).addClass("active"); //  adding active class to clicked tab

  });

});
</script>

<script>
const chatsearchBar = document.querySelector(".chat input"),
chatsearchIcon = document.querySelector(".chat button"),
usersList = document.querySelector(".users-list");

chatsearchIcon.onclick = ()=>{
  chatsearchBar.classList.toggle("show");
  chatsearchIcon.classList.toggle("active");
  chatsearchBar.focus();
  if(chatsearchBar.classList.contains("active")){
    chatsearchBar.value = "";
    chatsearchBar.classList.remove("active");
  }
}

chatsearchBar.onkeyup = ()=>{
  let chatsearchTerm = chatsearchBar.value;
  if(chatsearchTerm != ""){
    chatsearchBar.classList.add("active");
  }else{
    chatsearchBar.classList.remove("active");
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "includes/classes/search.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          usersList.innerHTML = data;
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("chatsearchTerm=" + chatsearchTerm);
}
</script>
<script>
const groupsearchBar = document.querySelector(".group input"),
groupsearchIcon = document.querySelector(".group button"),
groupList = document.querySelector(".group-list");

groupsearchIcon.onclick = ()=>{
    groupsearchBar.classList.toggle("show");
    groupsearchIcon.classList.toggle("active");
  groupsearchBar.focus();
  if(groupsearchBar.classList.contains("active")){
    groupsearchBar.value = "";
    groupsearchBar.classList.remove("active");
  }
}

groupsearchBar.onkeyup = ()=>{
  let groupsearchTerm = groupsearchBar.value;
  if(groupsearchTerm != ""){
    groupsearchBar.classList.add("active");
  }else{
    groupsearchBar.classList.remove("active");
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "includes/classes/groupSearch.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          groupList.innerHTML = data;
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("groupsearchTerm=" + groupsearchTerm);
}
</script>
<script type="text/javascript">
    var auto_refresh = setInterval(
        function ()
        {
            $('.users-list').load('includes/classes/chats.php');
            $('.group-list').load('includes/classes/groups.php');
        }, 1000); // refresh every 1000 milliseconds
</script>
