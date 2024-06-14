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
          $group_id = mysqli_real_escape_string($con, $_GET['group_id']);
          $sql = mysqli_query($con, "SELECT * FROM groups WHERE id = '$group_id'");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: index.php");
          }
        ?>
        <a href="index.php" class="back-icon"><i class="fa fa-arrow-left"></i></a>
        <img src="includes/imgs/<?php echo $row['group_img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['groupname'] ?></span>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="userId_received" name="group_id" value="<?php echo $group_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Enter a here..." autocomplete="off">
        <button><i class="fa fa-paper-plane"></i></button>
      </form>
    </section>
  </div>

<script>
const form = document.querySelector(".typing-area"),
group_id = form.querySelector(".userId_received").value,
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
    xhr.open("POST", "includes/classes/sendGroupMessage.php", true);
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
    xhr.open("POST", "includes/classes/receiveGroupMessage.php", true);
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
    xhr.send("group_id="+group_id);
}, 500);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  
  </script>

</body>
</html>
