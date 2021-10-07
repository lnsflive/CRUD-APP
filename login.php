<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once('mysqli/mysqli_connect.php');

if(isset($_SESSION['sentEmail'])){
  array_push($errors, $_SESSION['sentEmail']);
  unset($_SESSION['sentEmail']);
}
if(isset($_SESSION['pwdReset'])){
  array_push($errors, $_SESSION['pwdReset']);
  unset($_SESSION['pwdReset']);
}


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $user_check_query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";



    //check if blank
    if(empty($username)){
        array_push($errors, "Username is required");
    }
    if(empty($password)){
        array_push($errors, "Password is required");
    }
    

    //check for errors
    if(count($errors) == 0){
        $passwords = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$passwords' ";
        $results = mysqli_query($mysqli, $query);

        if(mysqli_num_rows($results) > 0 ){
          while($rowResult = mysqli_fetch_assoc($results)){
            $_SESSION['username'] = $rowResult['username'];
            $_SESSION['id'] = $rowResult['id'];
            $_SESSION['success'] = "Logged in successful";
            header('location: home.php');
          }
      }else{
          array_push($errors, "Wrong username/password combination, please try again.");
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
defer ></script>
    <script type="text/javascript" src="https://kit.fontawesome.com/33507cf65a.js" crossorigin="anonymous" defer></script>
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
            <form action="login.php" method="POST">
            <div class="title">CRUD APP</div>
            <div class="sub-title">Login</div>
            <div class="fields">
                <div class="username">
                    <svg fill="#fff" viewBox="0 0 1024 1024">
                      <path
                        class="path1"
                        d="M896 307.2h-819.2c-42.347 0-76.8 34.453-76.8 76.8v460.8c0 42.349 34.453 76.8 76.8 76.8h819.2c42.349 0 76.8-34.451 76.8-76.8v-460.8c0-42.347-34.451-76.8-76.8-76.8zM896 358.4c1.514 0 2.99 0.158 4.434 0.411l-385.632 257.090c-14.862 9.907-41.938 9.907-56.802 0l-385.634-257.090c1.443-0.253 2.92-0.411 4.434-0.411h819.2zM896 870.4h-819.2c-14.115 0-25.6-11.485-25.6-25.6v-438.566l378.4 252.267c15.925 10.618 36.363 15.925 56.8 15.925s40.877-5.307 56.802-15.925l378.398-252.267v438.566c0 14.115-11.485 25.6-25.6 25.6z"
                      ></path>
                    </svg>
                    <input type="username" name="username" class="user-input" placeholder="Username" required />
                  </div>
              <div class="password">
                <svg fill="#fff" viewBox="0 0 1024 1024">
                  <path
                    class="path1"
                    d="M742.4 409.6h-25.6v-76.8c0-127.043-103.357-230.4-230.4-230.4s-230.4 103.357-230.4 230.4v76.8h-25.6c-42.347 0-76.8 34.453-76.8 76.8v409.6c0 42.347 34.453 76.8 76.8 76.8h512c42.347 0 76.8-34.453 76.8-76.8v-409.6c0-42.347-34.453-76.8-76.8-76.8zM307.2 332.8c0-98.811 80.389-179.2 179.2-179.2s179.2 80.389 179.2 179.2v76.8h-358.4v-76.8zM768 896c0 14.115-11.485 25.6-25.6 25.6h-512c-14.115 0-25.6-11.485-25.6-25.6v-409.6c0-14.115 11.485-25.6 25.6-25.6h512c14.115 0 25.6 11.485 25.6 25.6v409.6z"
                  ></path></svg
                ><input type="password" name="password" class="pass-input" placeholder="Password" required />
              </div>
            </div>
            <input type="submit" class="signin-button" value="Login">
            <div class="link"><a href="forgot.php">Forgot Password?</a></div>
            <div class="link"><a href="index.php">Register</a></div>
            <div class="layer-content">
            <?php foreach($errors as $error):?>
                <p><?php echo $error;    ?></p>
            <?php endforeach;?>
            </div>
          </div>
    </div>
  </form>
  <?php endif; ?>
    <!-- <script src="scripts/login.js" async defer></script> -->
  </body>
</html>
