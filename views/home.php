<?php

session_start();

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
  $.post("../config/searchBar.php", args)
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
<style>
#homeContent {
      position: sticky;        
      min-height: 100%;
      padding-bottom: 6rem;
}
#footer {
      background-color: #E5F2FF; color: black; left: 0; bottom: 0; width: 100%; position: absolute;
    }
</style>

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
<body id="homeContent">
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
      <div class="w3-container" style="width: 50%">
        <h1 class="txtcolor">Our Services</h1>
        <h6>Rate 'Em is a locally created real estate software focused on creating
          a better user experience between tenants and landlords and ease the stress
          of being a renter or renting out your home. Users can decide if they would
          like to create an account as a landlord or a tenant on the site.
          The rating system is utilized for the benefit of other users on making
          an informed decision.</h6>
          <br><br>
        <h6>Our application is primarily set to allow users to search by zipcode
          of the area that they are looking to stay, filter by property type that they are looking for, 
          or they can directly search for a landlord by name, and in result get the
          landlord's information, rating, and any reviews left by other registered users
          so that anyone looking to rent can read reviews on the landlord rather than just the property 
          itself. Alternatively, landlords can also leave reviews but on renters so other people 
          can be aware of who they are renting their property out to. Anyone can visit the 
          site and read reviews, but users must create an account as a landlord or renter to share their 
          thoughts. In conclusion, the goal for Rate 'Em is to assure properties are in good hands
          and well managed so renting can go smoothly as possible.</h6></p>
          <br><br>
          <h6>Our review and rating system is designed to support both renters and landlords.
            Landlords and renters will both be able to know who their tenants are and have an idea
            of what to expect from each other. Landlords are almost universally expected to run background
            checks and review a tenant's credit as part of the procedure, however only 37.6% always check
            a tenant's criminal background and 38.7% check credit history <a href="https://getflex.com/blog/landlord-statistics/">[1]</a>. 
            These checks should be done anyway,but shared reviews can help landlords have a better idea of who their renters are. Tenants, 
            on the other hand, can read landlord reviews to see how fair a landlord is based on previous tenants' experiences
            with that landlord, because 48.7% of landlords have asked tenants to leave suddenly or have raised
            their monthly rent on occasion <a href="https://getflex.com/blog/landlord-statistics/">[1]</a>.
          </h6>
          <br><br><br><br>
          <h3 class="txtcolor">Registered Users</h3>
          <h6>Registered users will have a profile containing their information, property list (landlord account), 
            rental history (tenant account), a rating, and a review section where other registered users can leave comments. 
            At any point, a registered user can update their account information or delete their account, however; each time an update 
            occurs or whenever the account owner decides to terminate their account, they are required to enter their 
            password. If the password is incorrect, then no change occurs.</h6></p>
            <br><br>
          <h6>The “My Rental” page is available only to tenant accounts where they will be able to view their rental 
            history once it is available when a landlord account lists them, and the tenant has the ability to give their rental 
            experience a rating out of five and update it further on. The tenant user will always be required to enter their password 
            each time they give or update a rating.</h6></p>
            <br><br>
          <h6>The “My Properties” page is an available page for Landlord accounts. They have the additional settings option to add 
            new properties, update their property information, or possibly delete a listed property. They are also able to add, update, 
            and delete a tenant that has rented or is currently renting from them. In the event of the renter table being altered on 
            the landlord side, will affect the tenant’s table in the “My Rental” page. As always, landlords are required to enter their 
            password to make changes.</h6></p>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

            <div class="w3-container w3-display-left" style="width: 35%; top: 27%; left: 60%;">
              <img style="width: 100%; height: 100%;" src="../images/searchByZipPage.png"><h6><b>A search by zipcode, page is available when a user
                searches from the home page.</b>
              </h6></div>
            
            <div class="w3-container w3-display-left" style="width: 35%; top: 40%; left: 60%;">
              <img style="width: 100%; height: 100%;" src="../images/resultProfilePage.png"><h6><b>The layout for all profile pages. This an account founded from a search result. Only registered
                and logged in users can leave reviews and ratings.</b>
              </h6></div>
            
            <div class="w3-container w3-display-left" style="width: 35%; top: 56%; left: 60%;">
              <img style="width: 100%; height: 100%;" src="../images/mySettingsPage.png"><h6><b>"My Settings" is where registered users can update their information or delete their account. 
                In order for an update or account termination to be successful, the user must enter their password.</b>
              </h6></div>
            
              <div class="w3-container w3-display-right" style="width: 35%; top: 73%; right: 60%;">
                <img style="width: 100%; height: 100%;" src="../images/myRentalsPage.png"><h6><b>"My Rentals" is where registered tenant accounts can view their rental history, and give 
                  ratings to a particular renting experience.</b>
                </h6></div>
            
              <div class="w3-container w3-display-left" style="width: 35%; top: 73%; left: 60%;">
                <img style="width: 100%; height: 100%;" src="../images/myPropertiesPage.png"><h6><b>A feature registered landlord account's have. They can view, add, update, or delete
                  properties and renters they have had from a list.</b>
                </h6></div>
            
           

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
    
    <!-- END MAIN -->
    </div>
    </body>
  <!--Footer-->
  <footer id="footer">
    <div class="w3-container">
      <!-- w3-theme-l1"> -->
      <h4>Rate 'Em</h4>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>
    
    </html>
