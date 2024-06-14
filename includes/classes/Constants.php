<?php
class Constants {
    # First name
    public static $firstNameCharacters = "Your first name must be between 2 and 25 characters";
    # Last Name
    public static $lastNameCharacters = "Your last name must be between 2 and 25 characters";
    # Username
    public static $usernameCharacters = "Your username must be between 2 and 25 characters";
    public static $usernameTaken = "Username already in use";
    # Emails
    public static $emailsDontMatch = "Your emails don't match";
    public static $emailInvalid = "Invalid Email";
    public static $emailTaken = "Email already in use";
    # Passwords
    public static $passwordsDontMatch = "Passwords don't match";
    public static $passwordLength = "Your password must be between 2 and 30 characters";
    #login
    public static $loginFailed = "Your username or password was incorrect";
    #old password
    public static $PasswordIncorrect = "Your old password was incorrect";
    #email sent
    public static $emailSent = "An Email to reset your password has benn sent";

    public static $loginSuccess = "Login successful";
    public static $registerSuccess = "registeration successful";
}
?>