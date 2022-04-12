<?php
// 3-17-22 LENY: Created a separate file with Laura's work 
// from the homepage for the searches

// 4/04/2022 Laura: Redirecting the user to desired results page
// + connect with database

// 04/08/22 LENY: Helped retrieve data for searches 

require_once "../config/.config.php";
/* if user enters zipcode redirect them to propertySearch */
if (isset($_POST["search"])) {
  unset($_POST["search"]);
  if (isset($_POST["zipcode"]) && is_null($_POST["zipcode"]) == false) {
    //$_SESSION["zipcode"] = $_POST["zipcode"];
    $db = getConnected();
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
    
    $LandlordResult = [];
    $PropertyResult = [];
    while ($row = $Property->fetch_assoc()) {
      $PropertyResult[] = $row;
    }
    while ($row = $Landlord->fetch_assoc()) {
      $LandlordResult[] = $row;
    }
    $_SESSION["propertyByZip"] = $PropertyResult;
    $_SESSION["LandlordByZip"] = $LandlordResult;
    //echo json_encode($results);
    header("Location: ../views/propertySearch.php");
  }
  else if (isset($_POST["user"]) && is_null($_POST["user"]) == false) {
    //$_SESSION["user"] = $_POST["user"];
    $UserSearch = $_POST["user"];
    $db = getConnected();
    $query = $db->prepare("SELECT * FROM User Where FName =?");
    $query->bind_param('s', $UserSearch);
    $query->execute();
    $Account = $query->get_result();

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
          $_SESSION["usersResults"] = $result;
          $_SESSION['Type'] = "Tenant";
          header("Location: ../views/userResults.php");
        } else {
          $_SESSION["usersResults"] = $result;
          $_SESSION['Type'] = "Landlord";
          header("Location: ../views/userResults.php");
        }
      }
    }
  }
}else{
  header("Location: ../views/home.php");
}
if (isset($_POST["zipcode"])) {
  //$_SESSION["zipcode"] = $_POST["zipcode"];
  $db = getConnected();
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
  
  $LandlordResult = [];
  $PropertyResult = [];
  while ($row = $Property->fetch_assoc()) {
    $PropertyResult[] = $row;
  }
  while ($row = $Landlord->fetch_assoc()) {
    $LandlordResult[] = $row;
  }
  $_SESSION["propertyByZip"] = $PropertyResult;
  $_SESSION["LandlordByZip"] = $LandlordResult;
  //echo json_encode($results);
  header("Location: ../views/propertySearch.php");
}
?>