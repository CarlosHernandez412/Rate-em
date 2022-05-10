<?php

session_start();

?>
<html>
<!-- CH user search for tenants/LL 4/12/22 -->
<head>
  <title>userSearch</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="style.css" rel="stylesheet">

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
    function searchUser() {
  args = { "userSearchAgain": true };
  $.post("../config/searhBar.php", args)
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
    html, body, h1, h2, h3, h4, h5, h6 {
      font-family: "Roboto", sans-serif;
    }
    /*CSS Theme Color Generataed */
    .w3-theme-l5 { color: #000 !important; background-color: #eff7fb !important }
    .w3-theme-l4 { color: #000 !important; background-color: #cae4f3 !important }
    .w3-theme-l3 { color: #000 !important; background-color: #95cae6 !important }
    .w3-theme-l2 { color: #fff !important; background-color: #60afda !important }
    .w3-theme-l1 { color: #fff !important; background-color: #2f94ca !important }
    .w3-theme-d1 { color: #fff !important; background-color: #1f6286 !important }
    .w3-theme-d2 { color: #fff !important; background-color: #1c5777 !important }
    .w3-theme-d3 { color: #fff !important; background-color: #184c68 !important }
    .w3-theme-d4 { color: #fff !important; background-color: #154159 !important }
    .w3-theme-d5 { color: #fff !important; background-color: #11364a !important }
    
    .w3-theme-light { color: #000 !important; background-color: #eff7fb !important}

    .w3-theme-dark {
      color: #fff !important;
      background-color: #11364a !important
    }

    .w3-theme-action {
      color: #fff !important;
      background-color: #11364a !important
    }

    .w3-theme {
      color: #fff !important;
      background-color: #236c93 !important
    }

    .w3-text-theme {
      color: #236c93 !important
    }

    .w3-border-theme {
      border-color: #236c93 !important
    }

    .w3-hover-theme:hover {
      color: #fff !important;
      background-color: #236c93 !important
    }

    .w3-hover-text-theme:hover {
      color: #236c93 !important
    }

    .w3-hover-border-theme:hover {
      border-color: #236c93 !important
    }
  </style>
</head>

<body style="background-image: linear-gradient(to bottom, black, #3dbaff);">
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
  <!-- Search Bar/filter -->
  <div style="position: relative; left: 0px; top: 55px; max-width: 200px">
    <section class="w3-container" aria-label="filters" style="z-index: 1;">
      <form class="search-form" role="search" method="post" id="search-form" action="../config/searchBar.php">
        <input required type="text" autocomplete="off" placeholder="Enter Desired User.." name="userSearchAgain" value="" style="position: fixed; left: 0px; top:52px">
      </form>
  </div>

  <!-- User Type Selection -->
  <!--div class="dropdown" style="position: fixed; left: 229px; top: 60px"> <--!-- action and method "post" -->
    <!--button class="dropbtn" onclick="myFunction('UserType')">UserType</button>
    <div id="myDropdown" class="dropdown-content">
      <a href="#about">Tenant</a>
      <a href="#base">Landlord</a>
      <a href="#blog">All</a>
      <button class="btn" id="btn-search" type="submit" name="filter">Done</button>-->
      <!-- End of price selection 
    </div>
  </div>
  <script>
    function toggle(source) {
      checkboxes = document.getElementsByName('homeType');
      for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;
      }
    }
  </script>-->
  </section>


  <!-- Section for results -->
  <?php
  if ($_SESSION) {
    if ($_SESSION['usersResults']) {
      $results = $_SESSION['usersResults'];
      $resultLength = count($results);
      for ($i = 0; $i < $resultLength; $i++) {
        echo "<a href=\"../views/resultProfile.php\"><div class=\"w3-container w3-card-4 w3-round w3-margin\" style=\"height:90px;width:450px; background-color: #E5F2FF; color:black;
        position:absolute; top:20%; left:50%;transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%)\">";
        echo ($_SESSION['usersResults'][$i]['FName'])." ".($_SESSION['usersResults'][$i]['MI'])." ".($_SESSION['usersResults'][$i]['LName'])."<br>";
        echo "<i class=\"fa fa-home fa-fw w3-margin-right\"></i>".($_SESSION['resultType'])."</br>";
        echo "<i class=\"fa fa-envelope fa-fw w3-margin-right\"></i>".($_SESSION['usersResults'][$i]['Email'])."<br></a>";
        echo "</div>";
        $_SESSION['selectProfile'] = $i;
      }
    }
  } 
  ?>
  <!-- Footer -->
  <footer id="myFooter">
    <div class="w3-container w3-bottom" style="background-color: #E5F2FF;">
      <h4>Rate 'Em</h4>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>
</body>

</html>