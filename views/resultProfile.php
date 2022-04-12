<?php

session_start();
print_r($_SESSION);

?>
<html>
<!-- 04/08/2022 - Leny: Copy of myProfile.php, which is for logged in users, this file will be for profiles that have been searched -->
<!-- TO DO: Get profile information for a searched user -->
<head>
<title>My Profile</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="style.css" rel="stylesheet">

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

/*CSS Theme Color Generataed */
.w3-theme-l5 {color:#000 !important; background-color:#eff7fb !important}
.w3-theme-l4 {color:#000 !important; background-color:#cae4f3 !important}
.w3-theme-l3 {color:#000 !important; background-color:#95cae6 !important}
.w3-theme-l2 {color:#fff !important; background-color:#60afda !important}
.w3-theme-l1 {color:#fff !important; background-color:#2f94ca !important}
.w3-theme-d1 {color:#fff !important; background-color:#1f6286 !important}
.w3-theme-d2 {color:#fff !important; background-color:#1c5777 !important}
.w3-theme-d3 {color:#fff !important; background-color:#184c68 !important}
.w3-theme-d4 {color:#fff !important; background-color:#154159 !important}
.w3-theme-d5 {color:#fff !important; background-color:#11364a !important}

.w3-theme-light {color:#000 !important; background-color:#eff7fb !important}
.w3-theme-dark {color:#fff !important; background-color:#11364a !important}
.w3-theme-action {color:#fff !important; background-color:#11364a !important}

.w3-theme {color:#fff !important; background-color:#236c93 !important}
.w3-text-theme {color:#236c93 !important}
.w3-border-theme {border-color:#236c93 !important}

.w3-hover-theme:hover {color:#fff !important; background-color:#236c93 !important}
.w3-hover-text-theme:hover {color:#236c93 !important}
.w3-hover-border-theme:hover {border-color:#236c93 !important}
</style>
</head>

<body class="w3-theme-l3 #1f6286 w3-theme-dark">

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-theme-d2 w3-left-align w3-large text-color:black">
    <div class="w3-bar w3-top w3-left-align w3-large" style="background-color: #E5F2FF; color: black;">
      <div class="w3-bar-item w3-hide-small"><img src="../images/myicon.png" height="45px"></div>
      <?php
      if($_SESSION){
        if($_SESSION['Type'] === 'Landlord'){
          echo "<a href=\"../views/home.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Home</a>
          <a href=\"../views/myProfile.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Profile</a>
          <a href=\"../views/settings.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Settings</a>
          <a href=\"../views/property.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Properies</a>
          <a href=\"../views/aboutus.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">About Us</a>
          <a href=\"../views/contact.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Contact</a>
          <form class=\".logoutLblPos\" action=\"../config/accLogin.php\" method=\"post\">
            <div class= \"w3-bar-item w3-button w3-hide-small w3-hover-light-blue w3-right\"><button id=\"logout\" type=\"submit\" name=\"logout\">Logout</button></div>
          </form>";
       } else if($_SESSION['Type'] === 'Tenant'){
          echo "<a href=\"../views/home.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Home</a>
          <a href=\"../views/myProfile.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Profile</a>
          <a href=\"../views/settings.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Settings</a>
          <a href=\"../views/aboutus.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">About Us</a>
          <a href=\"../views/contact.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Contact</a>
          <form class=\".logoutLblPos\" action=\"../config/accLogin.php\" method=\"post\">
            <div class= \"w3-bar-item w3-button w3-hide-small w3-hover-light-blue w3-right\"><button id=\"logout\" type=\"submit\" name=\"logout\">Logout</button></div>
          </form>";
       }
      }else{
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


<!-- Page Container: My Profile and Related searches and Comments -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile Page on top left side -->
      <div class="w3-card-4 w3-round #2f94ca w3-theme">
        <div class="w3-container">
         <h4 id="accountName" class="w3-center">Name</h4>
         <p class="w3-center"><img src="../images/profile4.png" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
         <hr>

         <?php 
         if($_SESSION){
           if($_SESSION['Type'] === 'Landlord'){
             echo "<p><i class=\"fa fa-home fa-fw w3-margin-right\"></i>Landlord</p>";
          } else if($_SESSION['Type'] === 'Tenant'){
            echo "<p><i class=\"fa fa-home fa-fw w3-margin-right\"></i> Tenant</p>";
          }
         }else{
          echo "<p><i class=\"fa fa-home fa-fw w3-margin-right\"></i> Account Type</p>";
         }
         ?>

         <!-- Direct to a more detailed rating of the acocunt -->
         <a href="../views/detailedReview.html">Overall Rating</a>
         <p><i> <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star"></span>
          <span class="fa fa-star"></span>
         </i></p>
        </div>
      </div>
      <br>
      
      <br>
      
      <!-- Related Searches --> 
      <div class="w3-card w3-round #2f94ca w3-theme w3-hide-small">
        <div class="w3-container">
          <!-- If logged in as Tenant 
          <p>Has rented from...</p>
          <p>
            <button span class="w3-tag w3-small w3-theme-d5">Previous Rentals</span>
          </p>-->
          <!-- If logged in as Landlord -->
          <p>Listed Properties</p>
          <p>
            <button span class="w3-tag w3-small w3-theme-d5">NumOfRooms</span></button>
            <button span class="w3-tag w3-small w3-theme-d4">NumOfBathrooms</span></button>
            <button span class="w3-tag w3-small w3-theme-d3">Price</span></button>
            <button span class="w3-tag w3-small w3-theme-d3">State</span></button>
            <button span class="w3-tag w3-small w3-theme-d3">City</span></button>
            <button span class="w3-tag w3-small w3-theme-d3">Zipcode</span></button>
          </p>
        </div>
      </div>
      <br>
    
    <!-- End Left Column -->
    </div>

    <!-- Middle Column -->
    <div class="w3-col m9">

    <div class="w3-row-padding">
      <div class="w3-col m12">
        <div class="w3-card w3-round w3-theme">
          <?php
          if($_SESSION){
            echo "<div class=\"w3-container w3-padding\">
            <h6>Want to leave a comment?</h6>
            <p contentEditable=true class=\"w3-border w3-padding w3-white\"></p>
            <button type=\"button\" class=\"w3-button\"><i class=\"fa fa-pencil\"></i>  Post</button> ";
          }else{
            echo "<div class=\"w3-container w3-padding\">
            <h6>Sign in or register to leave comments!</h6>
            <p contentEditable=false class=\"w3-border w3-padding w3-white\"></p>
            <button type=\"button\" class=\"w3-button\"><i class=\"fa fa-pencil\"></i>  Post</button>";
          }
          ?>
          </div>
        </div>
      </div>
    </div>

      <!--Comment Page-->
      <div class="w3-container w3-card-4 w3-round w3-margin #1f6286 w3-theme"><br>        
        <!--Time still needs to be fixed, so when a post is added it tells what time is was posted-->
        <div class="w3-container #cae4f3 w3-theme-d2 w3-round" style="height: auto;">
        <span class="w3-right" >1 min ago</span>
        <img src="../images/profile4.png" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:55px"><h4>John Doe</h4></div>
        <!--Top of comments to change different background color-Keben-->
        <hr class="w3-clear">
        <p>Comments would go here.</p>
        <hr class="w3-clear">
        <div class="w3-row-padding" style="margin:0 -16px"></div>
        <button type="button" class="w3-button w3-margin-bottom"><i class="fa fa-thumbs-up" style="font-size:28px;color:white"></i> </button>
        <button type="button" class="w3-button w3-margin-bottom"><i class="fa fa-thumbs-down" style="font-size:28px;color:white"></i> </button>  
        <button type="button" class="w3-button w3-margin-bottom"><i class="fa fa-comment" style="font-size:28px;color:white"></i>  Comment</button> 
      </div>
      
      <!--Comment Page-->
      <div class="w3-container w3-card-4 w3-round w3-margin #1f6286 w3-theme"><br>        
        <!--Time still needs to be fixed, so when a post is added it tells what time is was posted-->
        <div class="w3-container #cae4f3 w3-theme-d2 w3-round" style="height: auto;">
        <span class="w3-right" >16 mins ago</span>
        <img src="../images/profile4.png" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:55px"><h4>Jane Doe</h4></div>
        <!--Top of comments to change different background color-Keben-->
        <hr class="w3-clear">
        <p>Comments would go here.</p>
        <hr class="w3-clear">
        <div class="w3-row-padding" style="margin:0 -16px"></div>
        <button type="button" class="w3-button w3-margin-bottom"><i class="fa fa-thumbs-up" style="font-size:28px;color:white"></i> </button>
        <button type="button" class="w3-button w3-margin-bottom"><i class="fa fa-thumbs-down" style="font-size:28px;color:white"></i> </button>  
        <button type="button" class="w3-button w3-margin-bottom"><i class="fa fa-comment" style="font-size:28px;color:white"></i>  Comment</button> 
      </div>

      <!--Comment Page-->
      <div class="w3-container w3-card-4 w3-round w3-margin #1f6286 w3-theme"><br>        
        <!--Time still needs to be fixed, so when a post is added it tells what time is was posted-->
        <div class="w3-container #cae4f3 w3-theme-d2 w3-round" style="height: auto;">
        <span class="w3-right" >32 mins ago</span>
        <img src="../images/profile4.png" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:55px"><h4>Angie Jane</h4></div>
        <!--Top of comments to change different background color-Keben-->
        <hr class="w3-clear">
        <p>Comments would go here.</p>
        <hr class="w3-clear">
        <div class="w3-row-padding" style="margin:0 -16px"></div>
        <button type="button" class="w3-button w3-margin-bottom"><i class="fa fa-thumbs-up" style="font-size:28px;color:white"></i> </button>
        <button type="button" class="w3-button w3-margin-bottom"><i class="fa fa-thumbs-down" style="font-size:28px;color:white"></i> </button>  
        <button type="button" class="w3-button w3-margin-bottom"><i class="fa fa-comment" style="font-size:28px;color:white"></i>  Comment</button> 
      </div>
    <!-- End Middle Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<br>

<!--Footer-->
<footer id="myFooter">
    <div class="w3-container" style="background-color: #E5F2FF; color: black;">
      <!-- w3-theme-l1"> -->
      <h4>Rate 'Em</h4>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>
 
<script>
// Accordion
function myFunction(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += " w3-theme-d1";
  } else { 
    x.className = x.className.replace("w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-theme-d1", "");
  }
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>

</body>
</html> 
