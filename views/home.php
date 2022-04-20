<?php

session_start();
print_r($_SESSION);

?>
<html lang="en">
<!-- 03/17/2022 - Leny: Created homepage-->
<!-- 04/07/2022 LENY: Nav bar is complete -->

<!-- 3-18-22 Laura: Created the search filter-->
<!-- TO DO: add the database and reroute user to the results 
 + fix the design of the filter-->

<!-- 4-04-22 Laura: Redesigned the search bar -->
<title>Home</title>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="style.css" rel="stylesheet">
</head>

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
  function search() {
  args = { "zipcode": true };
  $.post("../config/searhBar.php", args)
    .done(function (result, status, xhr) {
      if (status == "success") { console.log(result); }
      else { console.error(result); }
    })
    .fail(function (xhr, status, error) {
      console.error(error);
    });
  args = { "user": true };
  $.post("../config/searchBar.php", args)
    .done(function (result, status, xhr) {
      if (status == "success") { console.log(result); }
      else { console.error(result); }
    })
    .fail(function (xhr, status, error) {
      console.error(error);
    });
  }
</script>

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

  <!-- Main content -->
  <div class="w3-main">
  
    <div class="w3-row w3-padding-64 img1"></div>
    <div class="w3-container w3-padding-64 w3-display-topmiddle">
      <h1 class="w3-text-black w3-center">Rate 'Em</h1>
      <h3 class="w3-text-black w3-center">Welcome to the new era of rentals!</h3>
      <h6 class="w3-text-black w3-center"><b><i>True reviews for tenants and landlords alike.</i></b></h6><br>
     <!-- Search bar -->
     <form class="search-form" role="search" method="post" action="../config/searchBar.php">
      <input type="text" role="combobox" autocomplete="off" placeholder="Enter Zip Code"
        name="zipcode" maxlength="5" value=""> OR
      <input type="text" autocomplete="off" placeholder="Enter Tenant or Landlord"
        name="user" value="">
        <div class="w3-container w3-center"><button class="btn" id="btn-search" type="submit" 
        name="search">Search</button></div>
    </form>
  </div>
</div>
    <!-- Our Services -->
    <div class="w3-row w3-padding-64">
      <div class="w3-container">
        <h1 class="txtcolor">Our Services</h1>
        <h6>Rate 'Em is a locally created real estate software focused on creating
          a better user experience between tenants and landlords and ease the stress
          of being a renter or renting out your home. Users can decide if they would
          like to create an account as a landlord or a tenant on the site.
          The rating system is utilized for the benefit of other users on making
          an informed decision.</h6>
    
        <h6>Our application is primarily set to allow users to search by city/state/zipcode
          of the area that they are looking to stay, property requirements that they are
          looking for, or they can directly search by a landlord, and in result get the
          landlord's information, rating, and any reviews left by tenants that have rented a
          property to before so that other people looking to rent can read reviews on the
          landlord rather than just the property itself. Alternatively, landlords can also
          leave reviews but on their renters so other landlords can be aware of who they
          are renting their property out to. Anyone can visit the site and read reviews,
          but users can create an account as a landlord or renter to share their thoughts.
          In conclusion, the goal for Rate 'Em is to assure properties are in good hands
          and well managed so renting can go smoothly as possible.</p>
    
          <h6>Our review and rating system is designed to support both renters and landlords.
            Landlords and renters will both be able to know who their tenants are and have an idea
            of what to expect from each other. Landlords are almost universally expected to run background
            checks and review a tenant's credit as part of the procedure, however only 37.6% always check
            a tenant's criminal background and 38.7% check credit history [1]. These checks should be done anyway,
            but shared reviews can help landlords have a better idea of who their renters are. Tenants, on the
            other hand, can read landlord reviews to see how fair a landlord is based on previous tenants' experiences
            with that landlord, because 48.7% of landlords have asked tenants to leave suddenly or have raised
            their monthly rent on occasion [1].
          </h6>
    
          <p>[1] Reed, Catherine “21 Insightful Landlord Statistics 2020” [Online].
            Available: https://getflex.com/blog/landlord-statistics/
            [Accessed 9 October 2021]</p>
    
      </div>
    </div>
    
    <!-- About Us -->
    <div class="w3-row">
      <div class="w3-container">
        <h1 class="txtcolor">About Us</h1>
        <h6>We are a small team of four develpers eager to better the rental experience for all.
          With a rating system set in place for landlords and tenants, users will be able
          to make a better decision on whether or not they would like to rent a place or
          would allow someone to rent from them.</h6>
        <h6><a href="../views/aboutus.php" target="_blank">More about us!</a></h6>
      </div>
    </div>
    
    <!-- Contact -->
    <div class="w3-row w3-padding-64">
      <div class="w3-container">
        <h1 class="txtcolor">Contact</h1>
        <h6><a href="../views/contact.php" target="_blank">Have any suggestions, questions, or need help?</a></h6>
      </div>
    </div>
    
    <footer id="myFooter">
      <div class="w3-container" style="background-color: #E5F2FF;">
        <!-- w3-theme-l1"> -->
        <h4>Rate 'Em</h4>
        <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
      </div>
    </footer>
    
    <!-- END MAIN -->
    </div>
    
    </body>
    
    </html>
