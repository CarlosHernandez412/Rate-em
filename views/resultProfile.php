<?php

session_start();
print_r($_SESSION);

if (!($_SESSION)) {
  header("Location: ../views/propertySearch.php");
} else if ($_SESSION) {
  if (!($_SESSION['usersResults']))
    header("Location: ../views/propertySearch.php");
}

?>
<html>
<!-- 04/08/2022 - Leny: Copy of myProfile.php, which is for logged in users, this file will be for profiles that have been searched -->
<!-- 04/16/2022 - Keben: Fixed Account Info -->
<!-- CH got ratings to print and allow logged in users to rate other users -->
<!-- 04/08/2022 - Leny: Displayed more info and added some validation for leaving ratings/comments, a logged in user cannot look themselves up and give rating/comment -->
<!-- 04/29/2022 - Leny: Users can now leave comments and ratings -->
<!-- 04/29/2022 - Leny: Users can now like/dislike comments even undo those dislikes or likes -->

<head>
  <title>Search Result</title>

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

    function profileReviews() {
      args = {
        "stars": true,
        "leaveComment": true,
        "dislike": true,
        "like": true,
        "undo-dislike": true,
        "undo-like": true
      };
      $.post("../config/leaveReviews.php", args)
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
    html,
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: "Roboto", sans-serif;
    }

    /*CSS Theme Color Generataed */
    .w3-theme-l5 {
      color: #000 !important;
      background-color: #eff7fb !important
    }

    .w3-theme-l4 {
      color: #000 !important;
      background-color: #cae4f3 !important
    }

    .w3-theme-l3 {
      color: #000 !important;
      background-color: #95cae6 !important
    }

    .w3-theme-l2 {
      color: #fff !important;
      background-color: #60afda !important
    }

    .w3-theme-l1 {
      color: #fff !important;
      background-color: #2f94ca !important
    }

    .w3-theme-d1 {
      color: #fff !important;
      background-color: #1f6286 !important
    }

    .w3-theme-d2 {
      color: #fff !important;
      background-color: #1c5777 !important
    }

    .w3-theme-d3 {
      color: #fff !important;
      background-color: #184c68 !important
    }

    .w3-theme-d4 {
      color: #fff !important;
      background-color: #154159 !important
    }

    .w3-theme-d5 {
      color: #fff !important;
      background-color: #11364a !important
    }

    .w3-theme-light {
      color: #000 !important;
      background-color: #eff7fb !important
    }

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

    .disabledBtnLD {
      border: none;
      display: inline-block;
      padding: 8px 16px;
      vertical-align: middle;
      overflow: hidden;
      text-decoration: none;
      color: inherit;
      background-color: inherit;
      text-align: center;
      white-space: nowrap
    }
    #footer {
      background-color: #E5F2FF; color: black; left: 0; bottom: 0; width: 100%; position: absolute;
    }
    #profileContent {
      position: sticky;        
      min-height: 100%;
      padding-bottom: 6rem;
    }
  </style>
</head>

<body id="profileContent" class="w3-theme-l3 #1f6286 w3-theme-dark">

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

  <?php
  if (isset($_SESSION["error"])) {
    echo "<div style=\"padding-top: 100px;\">";
    echo "<div class=\"warning\"><i class=\"fa fa-warning\"></i> " . $_SESSION["error"] . "</div></div>";
    unset($_SESSION["error"]);
  }
  if (isset($_SESSION["success"])) {
    echo "<div style=\"padding-top: 100px;\">";
    echo "<div class=\"success\"><i class=\"fa fa-check\"></i> " . $_SESSION["success"] . "</div></div>";
    unset($_SESSION["success"]);
  }
  ?>

  <!-- Page Container: My Profile and Related searches and Comments -->
  <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
    <!-- The Grid -->
    <div class="w3-row">
      <!-- Left Column -->
      <div class="w3-col m3">
        <!-- Profile Page on top left side -->
        <div class="w3-card-4 w3-round #2f94ca w3-theme">
          <div class="w3-container">
            <h4 id="accountName" class="w3-center">
              <?php
              print_r($_SESSION['usersResults'][$_SESSION['selectProfile']]['FName']) . print_r(" ") . print_r($_SESSION['usersResults'][$_SESSION['selectProfile']]['MI']) . print_r(" ") . print_r($_SESSION['usersResults'][$_SESSION['selectProfile']]['LName']);
              ?>
            </h4>
            <p class="w3-center"><img src="../images/profile4.png" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
            <hr>
            <p><i class="fa fa-envelope fa-fw w3-margin-right"></i><?php print($_SESSION['usersResults'][$_SESSION['selectProfile']]['Email']) ?></p>
            <?php
            if ($_SESSION) {
              if ($_SESSION['resultType'] === 'Landlord') {
                echo "<p><i class=\"fa fa-home fa-fw w3-margin-right\"></i>Landlord</p>";
              } else if ($_SESSION['resultType'] === 'Tenant') {
                echo "<p><i class=\"fa fa-home fa-fw w3-margin-right\"></i>Tenant</p>";
              }
            } else {
              header("Location: ../views/home.php");
            }
            ?>

            <!--CH created Direct to a more detailed rating of the acocunt -->
            <a href="../views/detailedReview.php">Overall Rating</a>
            <?php
            //display users overall rating/5
            if ($_SESSION) {
              if ($_SESSION['resultUserRating']['TotalRating']) {
                $ratings = $_SESSION['resultUserRating']['TotalRating'];
                $ratings = round($ratings, 1);
                echo ": ", $ratings, "/5", "<br>";
              } else {
                echo ": No ratings<br>";
              }
            } else {
              echo "<br><br>";
            }

            //web user can drop down menu and rate others.
            if ($_SESSION) {
              if ($_SESSION['loggedProfile']) {
                if ($_SESSION['loggedProfile']['Email'] !== $_SESSION['usersResults'][$_SESSION['selectProfile']]['Email']) {
                  if ($_SESSION['Type'] !== $_SESSION['resultType']) {
                    if (($_SESSION['loggedProfile']['Email'] === $_SESSION['loggedProfileRated']['UEmail']) &&
                      ($_SESSION['usersResults'][$_SESSION['selectProfile']]['Email'] === $_SESSION['loggedProfileRated']['ForEmail'])
                    ) {
                      echo "Previously rated, update here:";
                      echo "<form method=\"post\" action=\"../config/leaveReviews.php\" name=\"giveRating\">
                        <input type=\"number\" value=" . $_SESSION['loggedProfileRated']['Stars'] . " name=\"stars\" min=\"1\" max=\"5\" maxlength=\"1\"></form>";
                    } else {
                      echo "Give a Rating (1-5):";
                      echo "<form method=\"post\" action=\"../config/leaveReviews.php\" name=\"giveRating\">
                        <input type=\"number\" name=\"stars\" min=\"1\" max=\"5\" maxlength=\"1\"></form>";
                    }
                  } else {
                    echo "Cannot rate the same user type.<br><br>";
                  }
                } else {
                  echo "<br><br>";
                }
              } else {
                echo "Login or register to rate!";
                echo "<br><br>";
              }
            } else {
              echo "<br><br>";
            }
            ?>

            <!--  
                  <div class="dropdown">
                    <button class="dropbtn">Rate Me</button>
                    <div class="dropdown-content">
                      <a href="#">1</a>
                      <a href="#">2</a>
                      <a href="#">3</a>
                      <a href="#">4</a>
                      <a href="#">5</a>
                    </div>
                  </div> 
            -->
          </div>
        </div>
        <br><br>
        <!-- Related Searches -->
        <div class="w3-card w3-round #2f94ca w3-theme w3-hide-small">
          <div class="w3-container">
            <?php
            if ($_SESSION) {
              if ($_SESSION['resultType'] === 'Landlord') {
                // If logged in as Landlord
                echo "<p><h4>Listed Properties</h4></p>";
                $properties = $_SESSION['resultsProperties'];
                $numProperties = count($properties);
                for ($i = 0; $i < $numProperties; $i++) {
                  echo "<div style=\"font-size: 17px;\"><b>Property " . ($i + 1) . ":</b></div>";
                  echo "Type: " . ($_SESSION['resultsProperties'][$i]['Type']) . "<br>";
                  echo "State: " . ($_SESSION['resultsProperties'][$i]['State']) . "<br>";
                  echo "City: " . ($_SESSION['resultsProperties'][$i]['City']) . "<br>";
                  echo "Zipcode: " . ($_SESSION['resultsProperties'][$i]['Zipcode']) . "<br>";
                  echo "Number of rooms: " . ($_SESSION['myPrresultsPropertiesoperties'][$i]['NumOfRooms']) . "<br>";
                  echo "Number of bathrooms: " . ($_SESSION['resultsProperties'][$i]['NumOfBathrooms']) . "<br>";
                  echo "Price: " . ($_SESSION['resultsProperties'][$i]['Price']) . "<br>";
                  echo "<br>";
                }
              } else if ($_SESSION['resultType'] === 'Tenant') {
                // If logged in as Tenant 
                echo "<p><h4>Previous Rentals</h4></p>";
                $rentals = $_SESSION['resultsPrevRentals'];
                $numRentals = count($rentals);
                for ($i = 0; $i < $numRentals; $i++) {
                  echo "<div style=\"font-size: 17px;\"><b>Property " . ($i + 1) . ":</b></div>";
                  echo "Property Owner: " . ($_SESSION['resultsPrevRentals'][$i]['LEmail']) . "<br>";
                  echo "Property Type: " . ($_SESSION['resultsPrevRentals'][$i]['Type']) . "<br>";
                  echo "Property Location: " . ($_SESSION['resultsPrevRentals'][$i]['City']) . ", " . ($_SESSION['resultsPrevRentals'][$i]['State']) . "<br>";
                  echo "Number of rooms: " . ($_SESSION['resultsPrevRentals'][$i]['NumOfRooms']) . "<br>";
                  echo "Number of bathrooms: " . ($_SESSION['resultsPrevRentals'][$i]['NumOfBathrooms']) . "<br>";
                  echo "Property Price: " . ($_SESSION['resultsPrevRentals'][$i]['Price']) . "<br>";
                  echo "My Rental Rating: " . ($_SESSION['resultsPrevRentals'][$i]['Stars']) . "/5 <br>";
                  echo "<br>";
                }
              }
            }
            ?>
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
              if ($_SESSION) {
                if ($_SESSION['loggedProfile']) {
                  if ($_SESSION['loggedProfile']['Email'] !== $_SESSION['usersResults'][$_SESSION['selectProfile']]['Email']) {
                    echo "<div class=\"w3-container w3-padding\"><h6>Want to leave a comment?</h6>
                      <p><form method=\"post\" action=\"../config/leaveReviews.php\" name=\"commentRate\">
                      <input maxlength=\"500\" type=\"text\" class=\"w3-border w3-white\" name=\"message\" style=\"width: 100%\"></p>
                      <button name=\"leaveComment\" type=\"submit\" class=\"w3-button\"><i class=\"fa fa-pencil\"></i>  Post</button></form></div>";
                  }
                } else {
                  echo "<div class=\"w3-container w3-padding\"><h6>Sign in or register to leave comments!</h6>
                  <p contentEditable=false class=\"w3-border w3-padding w3-white\"></p></div>";
                }
              }
              ?>
            </div>
          </div>
        </div>

        <!--Comment Page-->
        <?php
        function elapsed_time($date, $full = false)
        {
          $now = new DateTime();
          $ago = new DateTime($date);
          $diff = $now->diff($ago);

          $diff->w = floor($diff->d / 7);
          $diff->d -= $diff->w * 7;

          $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
          );
          foreach ($string as $time => &$newtime) {
            if ($diff->$time) {
              $newtime = $diff->$time . ' ' . $newtime . ($diff->$time > 1 ? 's' : '');
            } else {
              unset($string[$time]);
            }
          }

          if (!$full) $string = array_slice($string, 0, 1);
          return $string ? implode(', ', $string) . ' ago' : 'just now';
        }
        $comments = $_SESSION['resultUserCom.'];
        $cRating = $_SESSION['resultComRates'];
        foreach ($comments as $cindex => $comments) {
          $likes = 0;
          $dislikes = 0;
          $commentTime = elapsed_time($comments['Date']);
          foreach ($cRating as $rindex => $rating) {
            if ($rating["CommentID"] === $comments["CommentID"]) {
              if ($rating["Rating"] === 1) {
                $likes++;
              } else {
                $dislikes++;
              }
            }
          }
          echo "<div class=\"w3-container w3-card-4 w3-round w3-margin #1f6286 w3-theme\"><br>";
          echo "<div class=\"w3-container #cae4f3 w3-theme-d2 w3-round\" style=\"height: auto;\">";
          echo "<span class=\"w3-right\">" . $commentTime . "<br></span>";
          echo "<img src=\"../images/profile4.png\" alt=\"Avatar\" class=\"w3-left w3-circle w3-margin-right\" style=\"width:55px\">";
          echo "<h4>" . $comments["FName"] . " " . $comments["MI"] . " " . $comments["LName"] . "</h4>";
          echo "</div>";
          echo "<!--Top of comments to change different background color-Keben-->";
          echo "<hr class=\"w3-clear\">";
          echo "<p>" . $comments["Message"] . "<br></p>";
          echo "<hr class=\"w3-clear\">";
          echo "<div class=\"w3-row-padding\" style=\"margin:0 -16px\"></div>";
          if ($_SESSION['loggedProfile']) {
            if ($_SESSION['loggedProfile']['Email'] !== ($_SESSION['usersResults'][$_SESSION['selectProfile']]['Email'])) {
              if ($_SESSION['resultComRates']) {
                foreach ($cRating as $rindex => $rating) {
                  goto checkAgain;
                }
                checkAgain: {
                  if (($_SESSION['loggedProfile']['Email'] === $rating["UEmail"]) && ($rating["CommentID"] === $comments["CommentID"])) {
                    if ($rating["Rating"] === 1) {
                      echo "<form method=\"post\" action=\"../config/leaveReviews.php\">
                      <input type=\"hidden\" name=\"commentID\" value=" . $comments["CommentID"] . ">
                      <button name=\"undo-like\" type=\"submit\" class=\"w3-button w3-margin-bottom\">
                      <i class=\"fa fa-thumbs-up\" style=\"font-size:28px;color:green\"></i>" . $likes . "</button>";
                      echo "<div class=\"disabledBtnLD w3-margin-bottom\"><i class=\"fa fa-thumbs-down\" style=\"font-size:28px;color:white\"></i>" . $dislikes . "</div></form>";
                    } else {
                      echo "<form method=\"post\" action=\"../config/leaveReviews.php\">
                      <input type=\"hidden\" name=\"commentID\" value=" . $comments["CommentID"] . ">
                      <div class=\"disabledBtnLD w3-margin-bottom\"><i class=\"fa fa-thumbs-up\" style=\"font-size:28px;color:white\"></i>" . $likes . "</div>";
                      echo "<button name=\"undo-dislike\" type=\"submit\" class=\"w3-button w3-margin-bottom\">
                      <i class=\"fa fa-thumbs-down\" style=\"font-size:28px;color:red\"></i>" . $dislikes . "</button></form>";
                    }
                  } else {
                    echo "<form method=\"post\" action=\"../config/leaveReviews.php\">
                    <input type=\"hidden\" name=\"commentID\" value=" . $comments["CommentID"] . ">
                    <button  name=\"like\" type=\"submit\" class=\"w3-button w3-margin-bottom\">
                    <i class=\"fa fa-thumbs-up\" style=\"font-size:28px;color:white\"></i>" . $likes . "</button>";
                    echo "<button name=\"dislike\" type=\"submit\" class=\"w3-button w3-margin-bottom\">
                    <i class=\"fa fa-thumbs-down\" style=\"font-size:28px;color:white\"></i>" . $dislikes . "</button></form>";
                  }
                }
              } else {
                echo "<form method=\"post\" action=\"../config/leaveReviews.php\">
                 <input type=\"hidden\" name=\"commentID\" value=" . $comments["CommentID"] . ">
                 <button  name=\"like\" type=\"submit\" class=\"w3-button w3-margin-bottom\">
                 <i class=\"fa fa-thumbs-up\" style=\"font-size:28px;color:white\"></i>" . $likes . "</button>";
                echo "<button name=\"dislike\" type=\"submit\" class=\"w3-button w3-margin-bottom\">
                 <i class=\"fa fa-thumbs-down\" style=\"font-size:28px;color:white\"></i>" . $dislikes . "</button></form>";
              }
            } else {
              echo "<div class=\"disabledBtnLD w3-margin-bottom\"><i class=\"fa fa-thumbs-up\" style=\"font-size:28px;color:white\"></i>" . $likes . "</div>";
              echo "<div class=\"disabledBtnLD w3-margin-bottom\"><i class=\"fa fa-thumbs-down\" style=\"font-size:28px;color:white\"></i>" . $dislikes . "</div>";
            }
          } else {
            echo "<div class=\"disabledBtnLD w3-margin-bottom\"><i class=\"fa fa-thumbs-up\" style=\"font-size:28px;color:white\"></i>" . $likes . "</div>";
            echo "<div class=\"disabledBtnLD w3-margin-bottom\"><i class=\"fa fa-thumbs-down\" style=\"font-size:28px;color:white\"></i>" . $dislikes . "</div>";
          }
          //echo "<button type=\"button\" class=\"w3-button w3-margin-bottom\"><i class=\"fa fa-comment\" style=\"font-size:28px;color:white\"></i>  Comment</button>";
          echo "</div>";
        }
        ?>
        <!-- End Middle Column -->
      </div>

      <!-- End Grid -->
    </div>

    <!-- End Page Container -->
  </div>
  <br>

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
  <!--Footer-->
  <footer id="footer">
    <div class="w3-container">
      <!-- w3-theme-l1"> -->
      <h4>Rate 'Em</h4>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>

</html>