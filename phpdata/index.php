<?php
session_start();
//diretso sa log in pag wala ka log in ganiha
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  echo "<script>" . "window.location.href='./login.php';" . "</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!--para mahimog html di ma gg-->  
<meta charset="UTF-8">
<!--para latest na internet gamiton choy-->  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--para pasok sa bisan unsa nga device or kuan-->  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <!--bootstrap gikuha sa google haha-->  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <!--para sa font-->  
  <link rel="stylesheet" href="./css/main.css">
    <!--para didtoas taas-->  
  <link rel="shortcut icon" href="./img/avatar.webp" type="image/x-icon">
</head>

<body>
 <!--malamang sudlanan-->  
  <div class="container">
     <!--speaks for itslef-->  
    <div class="alert alert-success my-5">
      Welcome ! You are now signed in to your account.
    </div>
     <!--mutunga si avatar-->  
    <div class="row justify-content-center">
       <!--pagamayon  si avatar-->  
      <div class="col-lg-5 text-center">
         <!--tua ra gawas nas avatar-->  
        <img src="./img/ar.png" class="img-fluid rounded" alt="User avatar" width="180">
         <!--hello daw kung kinsa man ka-->  
        <h4 class="my-4">Hello, <?= htmlspecialchars($_SESSION["username"]); ?></h4>
         <!--aw pasi na ka boss?-->  
        <a href="./logout.php" class="btn btn-primary">Log Out</a>
      </div>
    </div>
  </div>
</body>

</html>