<?php
require_once "./config.php";

$firstname_err = $lastname_err = $gender_err = $username_err = $email_err = $password_err = "";
$firstname = $lastname = $gender = $username = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Please enter a firstname.";
    } else {
        $firstname = trim($_POST["firstname"]);
        if (strlen($firstname) < 1) {
            $firstname_err = "Firstname can only contain letters, hyphens, and apostrophes.";
        }
    }

    if (empty(trim($_POST["lastname"]))) {
        $lastname_err = "Please enter a lastname.";
    } else {
        $lastname = trim($_POST["lastname"]);
        if (strlen($lastname) < 1) {
            $lastname_err = "Lastname can only contain letters, hyphens, and apostrophes.";
        }
    }

    if (empty($_POST["gender"])) {
        $gender_err = "Please select a gender.";
    } else {
        $gender = $_POST["gender"];
    }

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
        if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            $username_err = "Username can only contain letters, numbers, and underscores.";
        }
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
        if (strlen($password) < 8) {
            $password_err = "Password must be at least 8 characters long.";
        }
    }


    if (empty($firstname_err) && empty($lastname_err) && empty($gender_err) && empty($username_err) && empty($email_err) && empty($password_err)) {
        $sql = "INSERT INTO users (firstname, lastname, gender, username, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssss", $param_firstname, $param_lastname, $param_gender, $param_username, $param_email, $param_password);
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_gender = $gender;
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Registration completed successfully. Please log in.');window.location.href='./login.php';</script>";
                exit;
            } else {
                echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/register.css">
  <link rel="shortcut icon" href="./img/avatar.png" type="image/x-icon">
  <script defer src="./js/script.js"></script>
</head>

<body>
  <div class="container">
    <div class="row min-vh-100 justify-content-center align-items-center">
        <div class="form-wrap border rounded p-4">
          <h1><br>Sign up</h1>
          <!-- diri mag fill in -->
          <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
           
            <div class="mb-3">
              <label for="firstname" class="form-label">Firstname</label>
              <input type="text" class="form-control" name="firstname" id="firstname" value="<?= $firstname; ?>">
              <small class="text-danger"><?= $firstname_err; ?></small>
            </div>
            <div class="mb-3">
              <label for="lastname" class="form-label">Lastname</label>
              <input type="text" class="form-control" name="lastname" id="lastname" value="<?= $lastname; ?>">
              <small class="text-danger"><?= $lastname_err; ?></small>
           
     
              <div class="form-group">
  <label for="gender" class="form-label">Gender:</label>
  <select name="gender" id="gender" class="form-select">
    <option value="male">Male</option>
    <option value="female">Female</option>
    <option value="others">Prefer not to say</option>
  </select>
</div>


            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" name="username" id="username" value="<?= $username; ?>">
              <small class="text-danger"><?= $username_err; ?></small>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" name="email" id="email" value="<?= $email; ?>">
              <small class="text-danger"><?= $email_err; ?></small>
            </div>
            <div class="mb-2">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="password" value="<?= $password; ?>">
              <small class="text-danger"><?= $password_err; ?></small>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="togglePassword">
              <label for="togglePassword" class="form-check-label">Show Password</label>
            </div>
            <div class="mb-3">
              <input type="submit" class="btn btn-primary form-control" name="submit" value="Sign Up">
            </div>
            <p class="mb-0">Already have an account ? <a href="./login.php">Log In</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
