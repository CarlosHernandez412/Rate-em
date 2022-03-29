<!-- 3-17-22 LENY: Created homepage-->
<!-- TO DO: Fix image, continue working on navbar + page -->

<!-- 3-18-22 Laura: Created the search filter-->
<!-- TO DO: add the database and reroute user to the results 
 + fix the design of the filter-->
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="style.css" rel="stylesheet">
</head>

<body>

  <!-- Navbar -->
  <div class="w3-top">
    <div class="w3-bar w3-top w3-left-align w3-large" style="background-color: #E5F2FF;">
      <div class="w3-bar-item w3-hide-small"><img src="../images/myicon.png" height="45px"></div>
      <a href="../views/home.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>
      <a href="../views/register.html" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Register</a>
      <a href="../views/login.html" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Login</a>
      <a href="../views/aboutus.html" class="w3-bar-item w3-button w3-hide-small w3-hover-white">About Us</a>
      <a href="../views/contact.html" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
    </div>
  </div>

  <!-- Main content -->
  <div class="w3-main">

    <div class="w3-row w3-padding-64 img1"></div>
    <div class="w3-container w3-padding-64 w3-display-topmiddle">
      <h1 class="w3-text-black w3-center">Rate 'Em</h1>
      <h3 class="w3-text-black">Welcome to the new era of rentals!</h3>
      <h6 class="w3-text-black w3-center"><b><i>True reviews for tenants and landlords alike.</i></b></h6><br>
    <!-- Search bar -->
    <form class="search-form" role="search" method="post" action="propertySearch.php">
      <input required type="text" role="combobox" autocomplete="off" placeholder="Enter Tenant, Landlord, or Zip Code" 
      name="zipcode" value="">
      <div class="container">
      <button class="btn" id="btn-search" type="submit" name="search">Search</button>
    <!-- Including PHP file -->
    <?php
  
    ?>
    </form>
      </div>
    </div>    

  </head>
  </div>
</form>
<script>
/* if user enters zipcode redirect them to propertySearch */
<?php
if (isset($_SESSION["search"])) {
  if (isset($_SESSION["zipcode"])) {
      header("Location: ../views/propertySearch.php");
  }
  else if (isset($_SESSION["tenant"])) {
      header("Location: ../views/tenant.php");
  }
}
?>
</script>

    <!-- Our Services -->
    <div class="w3-row w3-padding-64">
      <div class="w3-container">
        <h1 class="txtcolor">Our Services</h1>
        <p>Rate 'Em is a locally created real estate software focused on creating
          a better user experience between tenants and landlords and ease the stress
          of being a renter or renting out your home. Users can decide if they would
          like to create an account as a landlord or a tenant on the site.
          The rating system is utilized for the benefit of other users on making
          an informed decision.</p>
      </div>
    </div>

    <!-- About Us -->
    <div class="w3-row">
      <div class="w3-container">
        <h1 class="txtcolor">About Us</h1>
        <p>We are a small team of four develpers eager to better the rental experience for all.
          With a rating system set in place for landlords and tenants, users will be able
          to make a better decision on whether or not they would like to rent a place or
          would allow someone to rent from them.</p>
      </div>
    </div>

    <!-- Contact -->
    <div class="w3-row w3-padding-64">
      <div class="w3-container">
        <h1 class="txtcolor">Contact</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
          dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
          commodo consequat. Lorem ipsum
          dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
          aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat.</p>
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
