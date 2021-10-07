<?php
session_start();
require_once('mysqli/mysqli_connect.php');

//register users

$message = "";

if(isset($_POST['register'])){
    $username = $mysqli->real_escape_string($_POST['username']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $password2 = $mysqli->real_escape_string($_POST['password2']);

//form validation
if(empty($username)){array_push($errors, "Username is required");}
if(empty($email)){array_push($errors, "Email is required");}
if(empty($password)){array_push($errors, "Password is required");}
if(empty($password2)){array_push($errors, "Confirm your password");}
if($password != $password2){array_push($errors, "Passwords do not match");}
//check db for existing user with same username

$user_check_query = "SELECT * FROM users WHERE username = '$username' or email = '$email' LIMIT 1";

$results = mysqli_query($mysqli,$user_check_query);
$user = mysqli_fetch_assoc($results);

if($user) {
  if($user['username'] === $username){array_push($errors, "Username already exists");}
  if($user['email'] === $email){array_push($errors, "This email id already has a registered username");}
}

    // register user if no errors
    if(count($errors) == 0){
      $password = md5($_POST['password']);
      $sql = "INSERT INTO users (username,email,password) "
      . "VALUES ('$username','$email','$password')";
      mysqli_query($mysqli, $sql);
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "Your are now logged in";
      header('location: home.php'); 
    }
}

?>

<?php if(isset($errors)):?> 
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
    <title>Registration</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="scripts/registerStyle.css" />
    <script type="text/javascript" 
    src="scripts/jquery-3.4.1.js" 
defer></script>
    <script type="text/javascript" src="https://kit.fontawesome.com/33507cf65a.js" crossorigin="anonymous" defer></script>
    <script src="scripts/register.js" defer></script>
  </head>
  <body>
    <!--[if lt IE 7]>
      <p class="browsehappy">
        You are using an <strong>outdated</strong> browser. Please
        <a href="#">upgrade your browser</a> to improve your experience.
      </p>
    <![endif]-->
    <div class="container">
        <div class="login-div">
            <div class="logo">
                <div class="logo"><i class="fas fa-power-off fa-6x"></i></div>
            </div><form action="index.php" method="POST">
            <div class="title">CRUD APP</div>
            <div class="sub-title">Register</div>
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
              <div class="username">
                <svg fill="#fff" viewBox="0 0 1024 1024">
                  <path
                    class="path1"
                    d="M896 307.2h-819.2c-42.347 0-76.8 34.453-76.8 76.8v460.8c0 42.349 34.453 76.8 76.8 76.8h819.2c42.349 0 76.8-34.451 76.8-76.8v-460.8c0-42.347-34.451-76.8-76.8-76.8zM896 358.4c1.514 0 2.99 0.158 4.434 0.411l-385.632 257.090c-14.862 9.907-41.938 9.907-56.802 0l-385.634-257.090c1.443-0.253 2.92-0.411 4.434-0.411h819.2zM896 870.4h-819.2c-14.115 0-25.6-11.485-25.6-25.6v-438.566l378.4 252.267c15.925 10.618 36.363 15.925 56.8 15.925s40.877-5.307 56.802-15.925l378.398-252.267v438.566c0 14.115-11.485 25.6-25.6 25.6z"
                  ></path>
                </svg>
                <input type="email" name="email" class="user-input" placeholder="Email" required />
              </div>
              <div class="password">
                <svg fill="#fff" viewBox="0 0 1024 1024">
                  <path
                    class="path1"
                    d="M742.4 409.6h-25.6v-76.8c0-127.043-103.357-230.4-230.4-230.4s-230.4 103.357-230.4 230.4v76.8h-25.6c-42.347 0-76.8 34.453-76.8 76.8v409.6c0 42.347 34.453 76.8 76.8 76.8h512c42.347 0 76.8-34.453 76.8-76.8v-409.6c0-42.347-34.453-76.8-76.8-76.8zM307.2 332.8c0-98.811 80.389-179.2 179.2-179.2s179.2 80.389 179.2 179.2v76.8h-358.4v-76.8zM768 896c0 14.115-11.485 25.6-25.6 25.6h-512c-14.115 0-25.6-11.485-25.6-25.6v-409.6c0-14.115 11.485-25.6 25.6-25.6h512c14.115 0 25.6 11.485 25.6 25.6v409.6z"
                  ></path></svg
                ><input type="password" id="password" name="password" class="pass-input" placeholder="Password" required />
              </div>
              <div class="password">
                  <svg fill="#fff" viewBox="0 0 1024 1024">
                    <path
                      class="path1"
                      d="M742.4 409.6h-25.6v-76.8c0-127.043-103.357-230.4-230.4-230.4s-230.4 103.357-230.4 230.4v76.8h-25.6c-42.347 0-76.8 34.453-76.8 76.8v409.6c0 42.347 34.453 76.8 76.8 76.8h512c42.347 0 76.8-34.453 76.8-76.8v-409.6c0-42.347-34.453-76.8-76.8-76.8zM307.2 332.8c0-98.811 80.389-179.2 179.2-179.2s179.2 80.389 179.2 179.2v76.8h-358.4v-76.8zM768 896c0 14.115-11.485 25.6-25.6 25.6h-512c-14.115 0-25.6-11.485-25.6-25.6v-409.6c0-14.115 11.485-25.6 25.6-25.6h512c14.115 0 25.6 11.485 25.6 25.6v409.6z"
                    ></path></svg
                  ><input type="password" id="confirm_password" name="password2" class="pass-input" placeholder="Confirm Password"  required />
                </div>
            </div>
            <div class="layer-content">
              <p id="message"></p>
              <?php foreach($errors as $error):?>
                <p><?php echo $error;?></p>
            <?php endforeach;?>
            </div>
            <input type="submit" class="signin-button" name="register" value="Register">
            <div class="link"><a href="login.php">Already a User?</a></div>
          </div>
    </div>
  </form>
  <?php endif; ?>
  </body>
</html>
