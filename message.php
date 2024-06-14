<?php
include_once("includes/classes/config.php");

if(!isset($_SESSION["userLoggedIn"])) {
    header("Location: login.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];
$_SESSION["username"] = $userLoggedIn;
?> 
<?php include('includes/classes/header.php') ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $con = mysqli_connect("localhost","root","","loms");
          $user_id = mysqli_real_escape_string($con, $_GET['user_id']);
          $sql = mysqli_query($con, "SELECT * FROM users WHERE id = {$user_id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: index.php");
          }
        ?>
        <a href="index.php" class="back-icon"><i class="fa fa-arrow-left"></i></a>
        <img src="includes/imgs/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['firstName']. " " . $row['lastName'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="userId_received" name="userId_received" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Enter a here..." autocomplete="off">
        <button><i class="fa fa-paper-plane"></i></button>
      </form>
    </section>
  </div>

<script>
const form = document.querySelector(".typing-area"),
userId_received = form.querySelector(".userId_received").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "includes/classes/sendMessage.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              scrollToBottom();
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "includes/classes/receiveMessage.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("userId_received="+userId_received);
}, 500);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  
  </script>

</body>
</html>
