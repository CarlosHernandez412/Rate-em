<?php

session_start();
print_r($_SESSION);

?>
<html>
<!-- 3/28/2022 Laura: Created a new page for search results and filters -->
<!-- Carlos: Need to fix Geomap from colliding with search filters -->
<!-- 4/01/2022 Laura: Fixed collision with geomap and search filter and redesigned filtering -->
<!-- -->
<title>propertySearch</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="style.css" rel="stylesheet">
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

<body class="w3-theme-l3">
  <!-- Navbar -->
  <div class="w3-top">
    <div class="w3-bar w3-top w3-left-align w3-large" style="background-color: #E5F2FF;">
      <div class="w3-bar-item w3-hide-small"><img src="../images/myicon.png" height="45px"></div>
      <?php if($_SESSION['Type'] === 'Landlord'){
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
  <!-- Search Bar/filter -->
  <div style="position: relative; left: 0px; top: 55px; max-width: 200px">
    <section class="container" aria-label="filters">
      <form class="search-form" role="search" method="post" id="search-form">
        <input required type="text" autocomplete="off" placeholder="Enter Zip Code" name="zipcode" value=""
          maxlength="5" style="position: fixed; left: 0px; top:52px">
      </form>
  </div>
  <!-- Home Type Selection -->
  <div class="dropdown" style="position: fixed; left: 200px; top: 60px">
    <button class="dropbtn" onclick="myFunction('Home Type')">Home Type</button>
    <div id="myDropdown" class="dropdown-content">
      <!-- Bedroom Selection -->
      <!--<div tabindex="-1" style="position: relative" for="bedrooms">-->
      <legend>Home Type</legend>
      <input type="checkbox" onClick="toggle(this)" name=homeType[] form="search-form"/>Select All</legend><br>
      <input type="checkbox" id="houses" name="homeType" value="" form="search-form">
      <label for="houses">Houses</label><br>
      <input type="checkbox" id="apartments" name="homeType" value="" form="search-form">
      <label for="apartments">Apartments</label><br>
      <input type="checkbox" id="condos" name="homeType" value="" form="search-form">
      <label for="condos">Condos</label><br>
      <input type="checkbox" id="studios" name="homeType" value="" form="search-form">
      <label for="studio">Studios</label><br>
      <input type="checkbox" id="trailers" name="homeType" value="" form="search-form">
      <label for="trailers">Trailers</label><br>
      <input type="checkbox" id="mobiles" name="homeType" value="" form="search-form">
      <label for="mobiles">Mobile Homes</label><br>
      <button class="btn" id="btn-search" type="submit" name="filter">Done</button>
    </div>
  </div>
  <!-- End of Home Type Selection -->
  <!-- Beds Selection -->
  <div class="dropdown" style="position: fixed; left: 302px; top: 60px">
    <button class="dropbtn" onclick="myFunction('Beds & Baths')">Beds & Baths</button>
    <div id="myDropdown" class="dropdown-content">
      <!-- Bedroom Selection -->
      <!--<div tabindex="-1" style="position: relative" for="bedrooms">-->
      <fieldset class="bed-filter">
        <legend>Bedrooms</legend>
        <div name="beds-option" class="buttonStyle" role="group">
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('any')" form="search-form"> Any </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('1+')" form="search-form"> 1+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('2+')" form="search-form"> 2+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('3+')" form="search-form"> 3+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('4+')" form="search-form"> 4+ </button>
        </div>
      </fieldset>
      <!-- Bathroom Selection -->
      <fieldset>
        <legend>Bathrooms</legend>
        <div name="beds-option" class="buttonStyle" role="group">
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('any')" form="search-form"> Any </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('1+')" form="search-form"> 1+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('2+')" form="search-form"> 2+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('3+')" form="search-form"> 3+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('4+')" form="search-form"> 4+ </button>
        </div>
      </fieldset>
      <button class="btn" id="btn-search" type="submit" name="filter">Done</button>
    </div>
  </div>
  <!-- End of Beds Selection -->
  <!-- Price Selection -->
  <div class="dropdown" style="position: fixed; left: 416px; top: 60px">
    <button class="dropbtn" onclick="myFunction('Price')">Price</button>
    <div id="myDropdown" class="dropdown-content">
      <fieldset class="price-filter">
        <legend>Price Range</legend>
        <div name="price-option" class="buttonStyle" role="group">
          <div>
            <label for="price-option-min">
              <div>
                <input id="price-option-min" type="tel" placeholder="Min" aria-owns="min-options" form="search-form">
              </div>
            </label>
            <span>-</span>
            <label for="price-option-max">
              <div>
                <input id="price-option-max" type="tel" placeholder="Max" aria-owns="max-options" form="search-form">
              </div>
            </label>
          </div>
        </div>
      </fieldset>
      <button class="btn" id="btn-search" type="submit" name="filter">Done</button>
      <!-- End of price selection -->
      </section>

      <script>
        function toggle(source) {
          checkboxes = document.getElementsByName('homeType');
          for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
          }
        }
      </script>
    </div>
    <!-- Section for map
  <div class="split left">
    <div class="w3-center" style="background-color: #E5F2FF; color: black">
    </div>
  </div> -->
   <!-- Geolocation -->
  </div>
<div class="w3-display-right">
 <style>
   .gfg {
     font-size: 40px;
     font-weight: bold;
     color: #009900;
     margin-left: 20px;
   }
   .maps {
     margin-left: 150px;
   }
   p {
     font-size: 20px;
     margin-left: 20px;
   }
 </style>

 <button class="maps" type="button" onclick="getlocation();" >
   Current Position
 </button>
 <div id="demo2"
      style="width: 700px; height: 500px"></div>
 <script src=
"https://maps.google.com/maps/api/js?sensor=false">
 </script>
 <script type="text/javascript">
   function getlocation() {
     if (navigator.geolocation) {
       navigator.geolocation.getCurrentPosition(showLoc, errHand);
     }
   }
   function showLoc(pos) {
     latt = pos.coords.latitude;
     long = pos.coords.longitude;
     var lattlong = new google.maps.LatLng(latt, long);
     var OPTions = {
       center: lattlong,
       zoom: 10,
       mapTypeControl: true,
       navigationControlOptions: {
         style: google.maps.NavigationControlStyle.SMALL,
       },
     };
     var mapg = new google.maps.Map(
       document.getElementById("demo2"),
       OPTions
     );
     var markerg = new google.maps.Marker({
       position: lattlong,
       map: mapg,
       title: "You are here!",
     });
   }

   function errHand(err) {
     switch (err.code) {
       case err.PERMISSION_DENIED:
         result.innerHTML =
           "The application doesn't have the permission" +
           "to make use of location services";
         break;
       case err.POSITION_UNAVAILABLE:
         result.innerHTML = "The location of the device is uncertain";
         break;
       case err.TIMEOUT:
         result.innerHTML = "The request to get user location timed out";
         break;
       case err.UNKNOWN_ERROR:
         result.innerHTML =
           "Time to fetch location information exceeded" +
           "the maximum timeout interval";
         break;
     }
   }
  </script>
  </div>
    <!-- Section for results -->
    <!-- Footer -->
    <footer id="myFooter">
      <div class="w3-container w3-bottom" style="background-color: #E5F2FF;">
        <h4>Rate 'Em</h4>
        <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
      </div>
    </footer>
</body>
</html>