<?php
// sugod na choy
session_start();

//log in naman diay ka boss
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE) {
  echo "<script>" . "window.location.href='./'" . "</script>";
  exit;
}

//para mu kuha sa database
require_once "./config.php";

// variables ra mani
$user_login_err = $user_password_err = $login_err = "";
$user_login = $user_password = "";

//kung na log in na ba or kung wala
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["user_login"]))) {
    $user_login_err = "Please enter your username or an email id.";
  } else {
    $user_login = trim($_POST["user_login"]);
  }
//enter password if empty ang box
  if (empty(trim($_POST["user_password"]))) {
    $user_password_err = "Please enter your password.";
  } else {
    $user_password = trim($_POST["user_password"]);
  }

//kung naa kay account? edi congrats 
  if (empty($user_login_err) && empty($user_password_err)) {
   //kuha info
    $sql = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
    //gisulod ang kung unsang input
      mysqli_stmt_bind_param($stmt, "ss", $paramUser_login, $paramUser_login);

      //para mu log in na
      $paramUser_login = $user_login;

      //sugdi na
      if (mysqli_stmt_execute($stmt)) {
        //ibutang ang paramters
        mysqli_stmt_store_result($stmt);

        //awon ang database sa user kung naa
        if (mysqli_stmt_num_rows($stmt) == 1) {
          //isabay sila
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

          if (mysqli_stmt_fetch($stmt)) {
            //awon kung tama ang pass ni angkol
            if (password_verify($user_password, $hashed_password)) {

              //para ma bal an sa database nga naka log in naka
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;
              $_SESSION["loggedin"] = TRUE;

              //adto sa homepage
              echo "<script>" . "window.location.href='./'" . "</script>";
              exit;
            } else {
              //mali imong pass
              $login_err = "The password you entered is incorrect.";
            }
          }
        } else {
          //pag wala imong username
          $login_err = "Username not found.";
        }
      } else {
        echo "<script>" . "alert('Something went wrong. Please try again later.');" . "</script>";
        echo "<script>" . "window.location.href='./login.php'" . "</script>";
        exit;
      }
      //bye
      mysqli_stmt_close($stmt);
    }
  }

 //hawa sa sql
  mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--para mahimong html di ma gg-->  
  <meta charset="UTF-8">
  <!--para latest na internet gamiton choy-->  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--para pasok sa bisan unsa nga device or kuan-->  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in</title>
   <!--bootstrap gikuha sa google haha--> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/login.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
   <!--link sa javascript --> 
  <script defer src="./js/script.js"></script>
</head>
<body>
  <div class="container">
    <div class="row min-vh-50 justify-content-center align-items-center">
        <?php
        if (!empty($login_err)) {
          echo "<div class='alert alert-danger'>" . $login_err . "</div>";
        }
        ?>
        <div class="form-wrap border rounded p-4">
          <h1><br>Log In</h1>
          <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div class="mb-3">
              <label for="user_login" class="form-label">Email or username</label>
              <input type="text" class="form-control" name="user_login" id="user_login" value="<?= $user_login; ?>">
              <small class="text-danger"><?= $user_login_err; ?></small>
            </div>
            <div class="mb-2">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="user_password" id="password">
              <small class="text-danger"><?= $user_password_err; ?></small>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="togglePassword">
              <label for="togglePassword" class="form-check-label">Show Password</label>
            </div>
            <div class="mb-3">
              <input type="submit" class="btn btn-primary form-control" name="submit" value="Log In">
            </div>
            <p class="mb-0">Don't have an account ? <a href="./register.php">Sign Up</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>