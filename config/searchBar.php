<?php
// 3-17-22 LENY: Created a separate file with Laura's work 
// from the homepage for the searches

// 4/04/2022 Laura: Redirecting the user to desired results page
// + connect with database

// 04/08/22 LENY: Helped retrieve data for searches 
// 04/14/22 LENY: Worked on results by landlord/tenant name

// TO DO: Get the account comments/ratings - LINE 31 & 53 & 113

require_once "../config/.config.php";
/* if user enters zipcode redirect them to propertySearch */
if (isset($_POST["search"])) {
  unset($_POST["search"]);
  $db = getConnected();
  if (isset($_POST["zipcode"]) && !empty($_POST["zipcode"]) && is_numeric($_POST["zipcode"])) {
    $Zipcode = $_POST["zipcode"];
    $user = $db->prepare("SELECT DISTINCT User.* FROM Property JOIN User
      Where Property.Zipcode =? AND Property.LEmail = User.Email");
    $user->bind_param('i', $Zipcode);
    $user->execute();
    $Landlord = $user->get_result();

    $property = $db->prepare("SELECT DISTINCT * FROM Property NATURAL JOIN PropertyType
      Where Property.Zipcode =?");
    $property->bind_param('i', $Zipcode);
    $property->execute();
    $Property = $property->get_result();

    // Get Comments/Ratings for Accounts


    $LandlordResult = [];
    $PropertyResult = [];
    while ($row = $Property->fetch_assoc()) {
      $PropertyResult[] = $row;
    }
    while ($row = $Landlord->fetch_assoc()) {
      $LandlordResult[] = $row;
    }
    $_SESSION["resultsProperties"] = $PropertyResult;
    $_SESSION["usersResults"] = $LandlordResult;
    $_SESSION['resultType'] = "Landlord";
    header("Location: ../views/propertySearch.php");
  } else if (isset($_POST["user"]) && !empty($_POST["user"]) && !(is_numeric($_POST["user"]))) {
    $UserSearch = $_POST["user"];
    $query = $db->prepare("SELECT * FROM User Where FName =?");
    $query->bind_param('s', $UserSearch);
    $query->execute();
    $Account = $query->get_result();

    // Get Comments/Ratings for Accounts

    $result = [];
    while ($row = $Account->fetch_assoc()) {
      $result[] = $row;
    }
    $accType = $db->prepare("SELECT Landlord.Email FROM Landlord Where Email =?");
    $accType->bind_param('s', $result[0]["Email"]);
    if ($accType->execute()) {
      if (mysqli_stmt_bind_result($accType, $res_LEmail)) {
        $landlordAcc = 0;

        while ($accType->fetch()) {
          $landlordAcc++;
        }
        if ($landlordAcc == 0) {
          $query = $db->prepare("SELECT DISTINCT Property.*, PropertyType.Type, Occupies.Stars FROM Property 
            NATURAL JOIN PropertyType NATURAL JOIN Occupies NATURAL JOIN Tenant NATURAL JOIN User 
            Where Occupies.TEmail = Tenant.Email AND User.FName =?");
          $query->bind_param('s', $UserSearch);
          $query->execute();
          $prevRentals = $query->get_result();

          $resultsPrevRentals = [];
          while ($row = $prevRentals->fetch_assoc()) {
            $resultsPrevRentals[] = $row;
          }
          $_SESSION["usersResults"] = $result;
          $_SESSION["resultsPrevRentals"] = $resultsPrevRentals;
          $_SESSION['resultType'] = "Tenant";
          header("Location: ../views/userSearch.php");
        } else if ($landlordAcc > 0) {
          $query = $db->prepare("SELECT * FROM Property NATURAL JOIN PropertyType Where LEmail =?");
          $query->bind_param('s', $result[0]["Email"]);
          $query->execute();
          $properties = $query->get_result();

          $propertyList = [];
          while ($row = $properties->fetch_assoc()) {
            $propertyList[] = $row;
          }
          $_SESSION["usersResults"] = $result;
          $_SESSION["resultsProperties"] = $propertyList;
          $_SESSION['resultType'] = "Landlord";
          header("Location: ../views/userSearch.php");
        }
      } else {
        header("Location: ../views/home.php");
      }
    } else {
      header("Location: ../views/home.php");
    }
  } else {
    header("Location: ../views/home.php");
  }
} else {
  header("Location: ../views/home.php");
}

if (isset($_POST["zipcodeAgain"]) && !empty($_POST["zipcodeAgain"]) && is_numeric($_POST["zipcodeAgain"])) {
  $db = getConnected();
  $Zipcode = $_POST["zipcodeAgain"];
  $user = $db->prepare("SELECT DISTINCT User.* FROM Property JOIN User
    Where Property.Zipcode =? AND Property.LEmail = User.Email");
  $user->bind_param('i', $Zipcode);
  $user->execute();
  $Landlord = $user->get_result();

  $property = $db->prepare("SELECT DISTINCT * FROM Property NATURAL JOIN PropertyType
    Where Property.Zipcode =?");
  $property->bind_param('i', $Zipcode);
  $property->execute();
  $Property = $property->get_result();
  
  // Get Comments/Ratings for Accounts


  $LandlordResult = [];
  $PropertyResult = [];
  while ($row = $Property->fetch_assoc()) {
    $PropertyResult[] = $row;
  }
  while ($row = $Landlord->fetch_assoc()) {
    $LandlordResult[] = $row;
  }
  $_SESSION["resultsProperties"] = $PropertyResult;
  $_SESSION["usersResults"] = $LandlordResult;
  $_SESSION['resultType'] = "Landlord";
  header("Location: ../views/propertySearch.php");
}
