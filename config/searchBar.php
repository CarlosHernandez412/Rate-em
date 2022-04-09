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
  if (isset($_POST["zipcode"]) && !empty($_POST["zipcode"])) {
    //$_SESSION["zipcode"] = $_POST["zipcode"];
    $db = getConnected();
    $Zipcode = $_POST["zipcode"];
    $validation = $db->prepare("SELECT DISTINCT * FROM Property NATURAL JOIN PropertyType 
      Where Property.Zipcode =?");
    $validation->bind_param('i', $Zipcode);
    $validation->execute();
    $Property = $validation->get_result();
    
    $results = [];
    while ($row = $Property->fetch_assoc()) {
        $results[] = $row;
      /*if (!$validation) {
        echo "zipcode:\" .$row[Zipcode] \"<br>";
      }*/
    }
    $_SESSION["zipCodeResults"] = $results;
    //echo json_encode($results);
    header("Location: ../views/propertySearch.php");
  }
  else if (isset($_POST["user"]) && !empty($_POST["user"])) {
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
?>