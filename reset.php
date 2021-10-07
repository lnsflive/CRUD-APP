<?php


if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
require_once('mysqli/mysqli_connect.php');

$_SESSION['selector'] = $_GET['selector'];
$_SESSION['validator'] = $_GET['validator'];


if(isset($_POST['reset'])){

$selector = $_SESSION['selector'];
$validator = $_SESSION['validator'];

    $password = $mysqli->real_escape_string($_POST['password']);
    $password2 = $mysqli->real_escape_string($_POST['password2']);

//form validation
if(empty($password)){array_push($errors, "Password is required");}
if(empty($password2)){array_push($errors, "Confirm your password");}
if($password != $password2){array_push($errors, "Passwords do not match");}
//check db for existing user with same username



if(empty($selector) || empty($validator)){
    echo "There was an error! 02";
    array_push($errors, "Could not validate your request!");
}else{
    if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ){
        $hiddenDivs = '<input type="hidden" name="selector" value="' . $selector . '"' . '>' . '<input type="hidden" name="validator" value="' . $validator . '">';
    }
}

$currentDate = date("U");

$sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
$stmt = mysqli_stmt_init($mysqli);

if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error! 03";
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "ss", $selector,$currentDate);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if(!$row = mysqli_fetch_assoc($result)){
        echo "There was an error! 04";
        array_push($errors, "You need to re-submit your reset request.");
        exit();
    }else{
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

        if($tokenCheck === false){
            echo "There was an error! 05";
            array_push($errors, "You need to re-subimt your reset request. 02");
            exit();
        }elseif($tokenCheck === true){
            $tokenEmail = $row['pwdResetEmail'];
            $sql = "SELECT * FROM users WHERE email=?";
            $stmt = mysqli_stmt_init($mysqli);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "There was an error! 06";
                array_push($errors, "There was an error. 08");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if(!$row = mysqli_fetch_assoc($result)){
                    echo "There was an error! 07";
                    array_push($errors, "There was an error. 08");
                    exit();
                }else{
                    $sql = "UPDATE users SET password=? WHERE email=?";
                    $stmt = mysqli_stmt_init($mysqli);
                    if(!mysqli_stmt_prepare($stmt,$sql)){
                        echo "There was an error! 09";
                        array_push($errors, "There was an error. 09");
                        exit();
                    }else{
                        $newPwdHash = md5($password);
                        mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                        mysqli_stmt_execute($stmt);

                        $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                        $stmt = mysqli_stmt_init($mysqli);

                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            echo "There was an error! 10";
                            array_push($errors, "There was an error. 10");
                            exit();
                        }else{
                            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                            mysqli_stmt_execute($stmt);
                            $_SESSION['pwdReset'] = "Password has been Reset";
                            header("Location: login.php");
                    }
                }


                }
            }
        }
    }


}
mysqli_stmt_close($stmt);
mysqli_close($mysqli);

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
    <title>Registration</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="scripts/registerStyle.css" />
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
    <div class="container">
        <div class="login-div">
            <div class="logo">
                <div class="logo"><i class="fas fa-power-off fa-6x"></i></div>
            </div><form method="POST">
            <div class="title">Service Now</div>
            <div class="sub-title">Login</div>
            <div class="fields">
   
            <br><br><br><br>
              <div class="password">
                <svg fill="#fff" viewBox="0 0 1024 1024">
                  <path
                    class="path1"
                    d="M742.4 409.6h-25.6v-76.8c0-127.043-103.357-230.4-230.4-230.4s-230.4 103.357-230.4 230.4v76.8h-25.6c-42.347 0-76.8 34.453-76.8 76.8v409.6c0 42.347 34.453 76.8 76.8 76.8h512c42.347 0 76.8-34.453 76.8-76.8v-409.6c0-42.347-34.453-76.8-76.8-76.8zM307.2 332.8c0-98.811 80.389-179.2 179.2-179.2s179.2 80.389 179.2 179.2v76.8h-358.4v-76.8zM768 896c0 14.115-11.485 25.6-25.6 25.6h-512c-14.115 0-25.6-11.485-25.6-25.6v-409.6c0-14.115 11.485-25.6 25.6-25.6h512c14.115 0 25.6 11.485 25.6 25.6v409.6z"
                  ></path></svg
                ><input type="password" id="password" name="password" class="pass-input" placeholder="New Password" required />
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
            <?php echo $hiddenDivs; ?>
            <?php if(isset($errors)):?> 
              <p id="message"></p>
              <?php foreach($errors as $error):?>
                <p><?php echo $error;?></p>
            <?php endforeach;?>
            </div>
           
            <input type="submit" class="signin-button" name="reset" value="Reset">
          </div>
    </div>
  </form>
  <?php endif; ?>
    <script src="scripts/register.js" async defer></script>
  </body>
</html> 
