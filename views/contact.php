<?php

session_start();

?>
<html>
<!-- 3-18-22 CH: Created about us page-->
<!-- 04/07/2022 LENY: Nav bar is complete -->
<title>Contact</title>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
<script>
function logout() {
  args = { "logout": true };
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
    * { box-sizing: border-box; }

    input[type=text],
    select,
    textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      margin-top: 6px;
      margin-bottom: 16px;
      resize: vertical;
    }

    input[type=submit] {
      background-color: #04AA6D;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type=submit]:hover {
      background-color: #45a049;
    }

    .container {
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 20px;
    }
  </style>
</head>

<body style="background-color: #f2f2f2">
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
  <!-- Need to fix the contact form label not popping up(HEIGHT OR LOCATION ISSUE) -->
  <h3>Contact Form</h3>
  <!-- Need to make a php file for contact inquiries -->
  <div class="container">
    <form action="/contactredirect.php">
      <label for="fname">First Name</label>
      <input type="text" id="fname" name="firstname" placeholder="John">

      <label for="lname">Last Name</label>
      <input type="text" id="lname" name="lastname" placeholder="Smith">

      <label for="name">Email</label>
      <input type="text" id="email" name="name" placeholder="email@email.com">

      <label for="subject">Subject</label>
      <textarea id="subject" name="subject" placeholder="Hello I am contacting you about.."
        style="height:200px"></textarea>

      <input type="submit" value="Submit">
    </form>
  </div>

  <footer id="myFooter">
    <div class="w3-container w3-bottom" style="background-color: #E5F2FF;">
      <h4>Rate 'Em</h4>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>
</body>

</html>