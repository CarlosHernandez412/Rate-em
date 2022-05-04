<?php

session_start();

?>
<html>
<!-- 3-18-22 CH: Created about us page-->
<!-- 04/07/2022 LENY: Nav bar is complete -->
<title>About us</title>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <script>
    function logout() {
      args = {
        "logout": true
      };
      $.post("../config/accLogin.php", args)
        .done(function(result, status, xhr) {
          if (status == "success") {
            console.log(result);
          } else {
            console.error(result);
          }
        })
        .fail(function(xhr, status, error) {
          console.error(error);
        });
    }
  </script>

  <style>
  html, body, h1, h2, h3, h4, h5, h6 {
      font-family: "Roboto", sans-serif;
    }

    body {
      margin: 0;
    }

    html {
      box-sizing: border-box;
    }

    *,
    *:before,
    *:after {
      box-sizing: inherit;
    }

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

    .profilepic {
      margin: auto;
      text-align: center;
      width: 150px;
      border-radius: 50%;
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
        <?php
        if ($_SESSION) {
          if ($_SESSION['Type'] === 'Landlord') {
            echo "<a href=\"../views/home.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Home</a>
          <a href=\"../views/myProfile.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Profile</a>
          <a href=\"../views/settings.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Settings</a>
          <a href=\"../views/property.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Properies</a>
          <a href=\"../views/aboutus.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">About Us</a>
          <a href=\"../views/contact.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Contact</a>
          <form class=\".logoutLblPos\" action=\"../config/accLogin.php\" method=\"post\">
            <div class= \"w3-bar-item w3-button w3-hide-small w3-hover-light-blue w3-right\"><button id=\"logout\" type=\"submit\" name=\"logout\">Logout</button></div>
          </form>";
          } else if ($_SESSION['Type'] === 'Tenant') {
            echo "<a href=\"../views/home.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Home</a>
          <a href=\"../views/myProfile.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Profile</a>
          <a href=\"../views/settings.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Settings</a>
          <a href=\"../views/rentals.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Rentals</a>
          <a href=\"../views/aboutus.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">About Us</a>
          <a href=\"../views/contact.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Contact</a>
          <form class=\".logoutLblPos\" action=\"../config/accLogin.php\" method=\"post\">
            <div class= \"w3-bar-item w3-button w3-hide-small w3-hover-light-blue w3-right\"><button id=\"logout\" type=\"submit\" name=\"logout\">Logout</button></div>
          </form>";
          } else {
            echo "<a href=\"../views/home.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Home</a>
          <a href=\"../views/register.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Register</a>
          <a href=\"../views/login.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Login</a>
          <a href=\"../views/aboutus.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">About Us</a>
          <a href=\"../views/contact.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Contact</a>";
          }
        } else {
          echo "<a href=\"../views/home.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Home</a>
          <a href=\"../views/register.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Register</a>
          <a href=\"../views/login.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Login</a>
          <a href=\"../views/aboutus.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">About Us</a>
          <a href=\"../views/contact.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Contact</a>";
        }
        ?>
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
  <div class="row" style="position: relative; left: 310px;">
    <div class="column">
      <div class="w3-center card">
        <a href="https://github.com/leny673">
          <img class="profilepic" src="../images/leny.jpg" alt="Leny">
        </a>
        <div class="container">
          <h2>Elena Castaneda</h2>
          <p class="title">Frontend/Backend Developer</p>
          <p><a href="mailto:ecastaneda11@csub.edu">
              <button class="button">Contact</button>
            </a></p>
        </div>
      </div>
    </div>

    <div class="column">
      <div class="w3-center card">
        <a href="https://github.com/KebenCarrillo">
          <img class="profilepic" src="../images/squidward.png" alt="Keben" style="width: 160px; height: 150px">
        </a>
        <div class="container">
        <h2>Keben Carrillo</h2>
        <p class="title">Frontend/Backend Developer</p>
          <p><a href="mailto:kcarrillo15@csub.edu">
              <button class="button">Contact</button>
            </a></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="position: relative; left: 310px;">
    <div class="column">
      <div class="w3-center card">
        <a href="https://github.com/lmoreno29">
          <img class="profilepic" src="../images/frenchgirl.png" alt="Laura" style="width: 180px; height: 150px">
        </a>
        <div class="container">
          <h2>Laura Moreno</h2>
          <p class="title">Frontend/Backend Developer</p>
          <p><a href="mailto:lmoreno29@csub.edu">
              <button class="button">Contact</button>
            </a></p>
        </div>
      </div>
    </div>
    
    <div class="column">
      <div class="w3-center card">
        <a href="https://github.com/CarlosHernandez412">
          <img class="profilepic" src="../images/carlos.jpg" alt="Carlos Hernandez">
        </a>
        <div class="container">
        <h2>Carlos Hernandez</h2>
        <p class="title">Frontend/Backend Developer</p>
          <p><a href="mailto:chernandez147@csub.edu">
              <button class="button">Contact</button>
            </a></p>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <div class="w3-container" style="background-color: #E5F2FF;">
      <h4>Rate 'Em</h4>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>

</body>

</html>