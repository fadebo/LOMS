<?php
require_once("includes/classes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/redirect.php");

$account = new Account($con);
    if(isset($_POST["submitButton"])) {
 
        $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
        $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
        $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
        $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
        $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
        $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);
        $profile = FormSanitizer::sanitizeFormImage($_POST["profile"]);
        $success = $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2, $profile);

        if($success) {
            movePage(301,"login.php");
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
    <section class="form register">
      <header>LOMS Registeration</header>
      <form method="POST">
      <div class="error-msg">
        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
        <?php echo $account->getError(Constants::$usernameCharacters); ?>
        <?php echo $account->getError(Constants::$usernameTaken); ?>
        <?php echo $account->getError(Constants::$emailsDontMatch); ?>
        <?php echo $account->getError(Constants::$emailInvalid); ?>
        <?php echo $account->getError(Constants::$emailTaken); ?>
        <?php echo $account->getError(Constants::$passwordsDontMatch); ?>
        <?php echo $account->getError(Constants::$passwordLength); ?>
        </div>
        <div class="success-msg">
        <?php echo $account->getError(Constants::$registerSuccess); ?>
        </div>   
        <div class="container input">
          <label>Username</label>
          <input type="text" name="username" placeholder="Username" value="<?php getInputValue('username'); ?>" required>
          <i class="fa fa-user" aria-hidden="true"></i>
        </div>
          <div class="container input">
            <label>First Name</label>
            <input type="text" name="firstName" placeholder="First name" value="<?php getInputValue('firstName'); ?>" required>
            <i class="fa fa-user" aria-hidden="true"></i>  
        </div>
          <div class="container input">
            <label>Last Name</label>
            <input  type="text" name="lastName" placeholder="Last name" value="<?php getInputValue('lastName'); ?>" required>
            <i class="fa fa-user" aria-hidden="true"></i>  
        </div>
        <div class="container input" data-validate = "Valid email is required: ex@abc.xyz">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Email" value="<?php getInputValue('email'); ?>" required>
          <i class="fa fa-envelope" aria-hidden="true"></i>
        </div>
        <div class="container input" data-validate = "Valid email is required: ex@abc.xyz">
        <label>Confirm Email Address</label>
          <input type="text" name="email2" placeholder="Confirm Email" value="<?php getInputValue('email2'); ?>" required>
          <i class="fa fa-envelope" aria-hidden="true"></i>
        </div>
        <div class="container input" data-validate = "Password is required">
          <label>Password</label>
          <input type="password" name="password" placeholder="Password" required>
          <i class="fa fa-eye"></i>
        </div>
        <div class="container input" data-validate = "Password confirmation is required">
          <label>Confirm Password</label>
          <input type="password" name="password2" placeholder="Confirm Password" required>
          <i class="fa fa-lock"></i>
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
        <div class="container image">
          <label>Select Profile Photo</label>
          <input type="text" name="profile" value="default.png" hidden>
        </div>
        <div class="container button">
          <button type="submit" name="submitButton">
          Signup
          </button>
        </div>
      </form>
      <div class="link">Already have an account?<a href="login.php">Login here
      <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
      </a></div>
    </section>
  </div>
  <?php include('includes/classes/footer.php') ?>