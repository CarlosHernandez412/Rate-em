<?php

session_start();
print_r($_SESSION);

?>
<html lang="en">
<!-- 03/17/2022 - Leny: Created login -->
<!-- 04/07/2022 LENY: Nav bar is complete -->
<!-- TO DO: Error messages on LINE 80 -->
<title>Login</title>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <script>
  function login(){
    args = { "login": true };
    $.post("../config/accLogin.php", args)
    .done(function (result, status, xhr) {
      if (status == "success") { console.log(result); }
      else { console.error(result); }
    })
    .fail(function (xhr, status, error) {
      console.error(error);
    });
  }
  </script>
  
  <style>
  html,body,h1,h2,h3,h4,h5,h6 { font-family: "Roboto", sans-serif; }
    .form {
      background-color: white;
      width: 800px;
      height: 400px;
      margin: auto;
      margin-top: 50px;
      padding: 10px;
      padding-top: 50px;
    }
    .img1 {
      background-image: url("../images/homeimg.jpeg");
      opacity: 0.7;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: 100% 100%;
      position: fixed;
      top: 0%;
      right: 0%;
      width: 100%;
      height: 200%;
    }
  </style>
</head>

<body>
  
  <!-- Navbar -->
  <div class="w3-top">
    <div class="w3-bar w3-top w3-left-align w3-large" style="background-color: #E5F2FF;">
      <div class="w3-bar-item w3-hide-small"><img src="../images/myicon.png" height="45px"></div>
      <a href="../views/home.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>
      <a href="../views/register.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Register</a>
      <a href="../views/login.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Login</a>
      <a href="../views/aboutus.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">About Us</a>
      <a href="../views/contact.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
    </div>
  </div>


  <!-- Main content -->
  <div class="w3-main img1 form">
    <div class="w3-container w3-modal-content w3-border-top w3-card-4 form w3-padding-32" style="max-width:600px; background-color: #FFFFFF;">
      <div class="w3-center"><br>
        <h3><b>Welcome back!</b></h3>
        <div><?php if(isset($_SESSION["error"])) { print($_SESSION["error"]); unset($_SESSION["error"]); } ?></div>
      </div>
      
      <form class="w3-container" action="../config/accLogin.php" method="post">
        <div class="w3-section">
          <label><b>Email</b></label>
          <input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Enter Email" name="email"
            required>
          <label><b>Password</b></label>
          <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="psw" required><br>
          <button class="w3-button w3-block w3-section w3-text-white w3-padding" type="submit"
            style="background-color: #236c93;" name="login">Login</button>
        </div>
      </form>
    </div>

    <div class="w3-center w3-modal-content w3-card-4 w3-container w3-padding-16"
      style="max-width:600px; background-color: #E5F2FF; bottom: 15px;">
      <span class="w3-hide-small">Forgot <a href="#">password?</a>
        / Need to <a href="../views/register.php">Register?</a></span>
    </div>
        <!-- END MAIN -->
  </div>

    <footer id="myFooter">
      <div class="w3-container w3-bottom" style="background-color: #E5F2FF;">
        <h4>Rate 'Em</h4>
        <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
      </div>
    </footer>
</body>

</html>
