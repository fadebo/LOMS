<?php
require_once("includes/classes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/redirect.php");

$account = new Account($con);
    if(isset($_POST["submitButton"])) {
 
        $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
        
        $success = $account->login($username, $password);

        if($success) {
            $connection = mysqli_connect("localhost","root","","loms");
            $listTime = "UPDATE users SET last_activity = CURRENT_TIMESTAMP, status = 'online' WHERE username = '$username' ";
            $updateTime = mysqli_query($connection, $listTime);
            if($updateTime){
                $_SESSION["userLoggedIn"] = $username;
                $loginSucc = $account->getError(Constants::$loginSuccess);
                movePage(301,"index.php");
                    }
                    else{
                     $info = "<div class='error-msg'>'$loginSucc'</div>";
                    }
            }
        }

    function getInputValue($name) { 
        if(isset($_POST[$name])) {
            echo $_POST[$name];
        }
    } 
if(isset($_SESSION["userLoggedIn"])) {
        header("Location: index.php");
    }
?>

<?php include('includes/classes/header.php') ?>
<body>
  <div class="wrapper">
    <section class="form login">
      <header>LOMS Login</header>
      <form method="POST">
        <div class="error-msg">
            <?php echo $account->getError(Constants::$loginFailed); ?>
        </div>
        <div class="success-msg">
         <?php echo $account->getError(Constants::$loginSuccess); ?>
        </div>
        <div class="container input">
          <label>Username</label>
          <input type="text" name="username" placeholder="Username" value="<?php getInputValue('username'); ?>" required>
          <i class="fa fa-user" aria-hidden="true"></i>
        </div>
        <div class="container input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <i class="fa fa-eye"></i>
        </div>
        <div class="container input">
          <label>Department</label>
          <select class="form-control"  name="department"> 
                <option disabled=''>Select Department</option> 
                <option>Admin</option>
				<option>Student</option>
				<option>Teacher</option>
            </select>
        </div>
        <div class="container button">
          <button type="submit" name="submitButton">
          Login
          </button>
        </div>
      </form>
      <div class="link">Create an account 
        <a href="register.php">Signup now
        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
    </section>
  </div>
  <?php include('includes/classes/footer.php') ?>