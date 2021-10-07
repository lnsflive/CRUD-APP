<?php

//session start
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

//connect db
require_once('mysqli/mysqli_connect.php');

// Recipient

$to = "";
$errors = "";
$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);

$url = "http://www.yourwebsite.com/reset.php?selector=" . $selector . "&validator=" . bin2hex($token);

$expires = date("U") + 1800;
$to = $_SESSION['email'];
$userEmail = $to; 

$sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
$stmt = mysqli_stmt_init($mysqli);

if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error! 01";
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?);";

$stmt = mysqli_stmt_init($mysqli);

if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error! 02";
    exit();
}else{
    $hashedToken = password_hash($token,PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
    mysqli_stmt_execute($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($mysqli);
}



// Subject
$subject = "Reset password";

// Message
$message = "<h1>Looks like you forgot your password,</h1><p>We recieved a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email</p>";
$message .= "<p>Here is your password reset link:<br>";
$message .= '<a href="' . $url . '">' . $url . '</a></p>';

// Headers
$headers = "From: Security <your@email.com>\r\n";
$headers .= "Reply-To: your@email.com\r\n";
$headers .= "Content-type: text/html\r\n";

// Send Mail
$to = $_SESSION['email'];

if(empty($to)){
    echo "Email not in system";
}else{
    mail($to, $subject, $message, $headers);
    $_SESSION['sentEmail'] = "Email has been sent!";
    header("Location: login.php");
}

?>