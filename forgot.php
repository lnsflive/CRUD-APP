<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

require_once('mysqli/mysqli_connect.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = $mysqli->real_escape_string($_POST['email']);


    $user_check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

    //check if blank
    if(empty($email)){
        array_push($errors, "Email is required");
    }

    //check for errors
    if(count($errors) == 0){
        $query = "SELECT * FROM users WHERE email='$email'";
        $results = mysqli_query($mysqli, $query);

        if(mysqli_num_rows($results) > 0 ){
          while($rowResult = mysqli_fetch_assoc($results)){
            $_SESSION['email'] = $rowResult['email'];
            header('location: mail.php');
          }
      }else{
          array_push($errors, "No email in database");
      }
}else{
  array_push($errors, "An error has occured");
}


}

?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
  <!--<![endif]-->
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="scripts/loginStyle.css" />
    <script type="text/javascript" 
    src="scripts/jquery-3.4.1.js" 
></script>
    <script type="text/javascript" src="https://kit.fontawesome.com/33507cf65a.js" crossorigin="anonymous" async></script>
  </head>
  <body>
    <!--[if lt IE 7]>
      <p class="browsehappy">
        You are using an <strong>outdated</strong> browser. Please
        <a href="#">upgrade your browser</a> to improve your experience.
      </p>
    <![endif]-->
    <?php if(isset($errors)):?> 
    <div class="container">
        <div class="login-div">
            <div class="logo"><i class="fas fa-power-off fa-6x"></i></div>
            <form action="forgot.php" method="POST">
            <div class="title">Service Now</div>
            <div class="sub-title">Login</div>
            <div class="fields">
                <div class="username">
                    <svg fill="#fff" viewBox="0 0 1024 1024">
                      <path
                        class="path1"
                        d="M896 307.2h-819.2c-42.347 0-76.8 34.453-76.8 76.8v460.8c0 42.349 34.453 76.8 76.8 76.8h819.2c42.349 0 76.8-34.451 76.8-76.8v-460.8c0-42.347-34.451-76.8-76.8-76.8zM896 358.4c1.514 0 2.99 0.158 4.434 0.411l-385.632 257.090c-14.862 9.907-41.938 9.907-56.802 0l-385.634-257.090c1.443-0.253 2.92-0.411 4.434-0.411h819.2zM896 870.4h-819.2c-14.115 0-25.6-11.485-25.6-25.6v-438.566l378.4 252.267c15.925 10.618 36.363 15.925 56.8 15.925s40.877-5.307 56.802-15.925l378.398-252.267v438.566c0 14.115-11.485 25.6-25.6 25.6z"
                      ></path>
                    </svg>
                    <input type="email" name="email" class="user-input" placeholder="Email" required />
                  </div>
            </div>
            <input type="submit" class="signin-button" value="Reset">
            <div class="layer-content">
            <?php foreach($errors as $error):?>
                <p><?php echo $error;?></p>
            <?php endforeach;?>
            </div>
          </div>
    </div>
  </form>
  <?php endif; ?>
    <!-- <script src="scripts/login.js" async defer></script> -->
  </body>
</html>
