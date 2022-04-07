<?php

session_start();
print_r($_SESSION);

?>
<!-- 3-18-22 CH: Created about us page-->
<!-- TO DO: Continue working on navbar -->
<!DOCTYPE html>
<title>About us</title>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <script>
    args = { "logout": true };
    $.post("../config/accLogin.php", args)
      .done(function (result, status, xhr) {
        if (status == "success") { console.log(result); }
        else { console.error(result); }
      })
      .fail(function (xhr, status, error) {
        console.error(error);
      });
  </script>

  <style> 
  html,body,h1,h2,h3,h4,h5,h6 { font-family: "Roboto", sans-serif; }
    body { margin: 0; }
    html {
      box-sizing: border-box;
    }

    *, *:before, *:after { box-sizing: inherit; }

    .column {
      float: left;
      width: 33.3%;
      margin-bottom: 16px;
      padding: 0 8px;
    }

    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      margin: 8px;
    }

    .about-section {
      padding: 50px;
      text-align: center;
      background-color: #474e5d;
      color: white;
    }

    .container {
      padding: 0 16px;
    }

    .container::after,
    .row::after {
      content: "";
      clear: both;
      display: table;
    }

    .title {
      color: grey;
    }

    .button {
      border: none;
      outline: 0;
      display: inline-block;
      padding: 8px;
      color: white;
      background-color: #000;
      text-align: center;
      cursor: pointer;
      width: 100%;
    }

    .button:hover {
      background-color: #555;
    }

    @media screen and (max-width: 650px) {
      .column {
        width: 100%;
        display: block;
      }
    }
  </style>
</head>

<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-theme-d2 w3-left-align w3-large text-color:black">
    <div class="w3-bar w3-top w3-left-align w3-large" style="background-color: #E5F2FF; color: black;">
      <div class="w3-bar-item w3-hide-small"><img src="../images/myicon.png" height="45px"></div>
      <!-- If logged out -->
      <a href="../views/home.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>
      <a href="../views/register.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Register</a>
      <a href="../views/login.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Login</a>
      <a href="../views/aboutus.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">About Us</a>
      <a href="../views/contact.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
      <!-- If logged in as Tenant
      <a href="../views/home.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>
      <a href="../views/profile.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Profile</a>
      <a href="../views/settings.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Settings</a>
      <a href="../views/aboutus.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">About Us</a>
      <a href="../views/contact.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
      <form class=".logoutLblPos" action="../config/accLogin.php" method="post">
        <div class= "w3-bar-item w3-button w3-hide-small w3-hover-light-blue w3-right"><button id="logout" type="submit" name="logout">Logout</button></div>
      </form> -->
      <!-- If logged in as Landlord 
      <a href="../views/home.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>
      <a href="../views/profile.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Profile</a>
      <a href="../views/settings.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Settings</a>
      <a href="../views/property.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Properies</a>
      <a href="../views/aboutus.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">About Us</a>
      <a href="../views/contact.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
      <form class=".logoutLblPos" action="../config/accLogin.php" method="post">
        <div class= "w3-bar-item w3-button w3-hide-small w3-hover-light-blue w3-right"><button id="logout" type="submit" name="logout">Logout</button></div>
      </form>-->
    </div>
  </div>
</div>
  <div class="about-section">
    <h1>About Us</h1>
    <p>The team consists of Keben Carrillo, Elena Castaneda, Carlos Hernandez, and Laura Moreno,</p>
    <p>all senior students at California State University, Bakersfield. We are a small team of four</p>
    <p>developers eager to better the rental experience for all.</p>
  </div>

  <h2 style="text-align:center">Our Team</h2>
  <div class="row">
    <div class="column">
      <div class="card">
        <img src="/images/team1.jpg" alt="Leny" style="width:inherit">
        <div class="container">
          <h2>Elena Castaneda</h2>
          <p class="title">Backend Developer</p>
          <p><button class="button">Contact</button></p>
        </div>
      </div>
    </div>

    <div class="column">
      <div class="card">
        <img src="/images/team2.jpg" alt="Keben" style="width:inherit">
        <div class="container">
          <h2>Keben Carrillo</h2>
          <p class="title">Backend Developer</p>
          <p><button class="button">Contact</button></p>
        </div>
      </div>
    </div>

    <div class="column">
      <div class="card">
        <img src="/images/team2.jpg" alt="Laura" style="width:inherit">
        <div class="container">
          <h2>Laura Moreno</h2>
          <p class="title">Front End Developer</p>
          <p><button class="button">Contact</button></p>
        </div>
      </div>
    </div>

    <div class="column">
      <div class="card">
        <img src="/images/team3.jpg" alt="Carlos" style="width:inherit">
        <div class="container">
          <h2>Carlos Hernandez</h2>
          <p class="title">Front End Developer</p>
          <p><button class="button">Contact</button></p>
        </div>
      </div>
    </div>
  </div>
  <footer id="myFooter">
    <div class="w3-container w3-bottom" style="background-color: #E5F2FF;">
      <h4>Rate 'Em</h4>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>
</body>

</html>
