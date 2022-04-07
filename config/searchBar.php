<?php
// 3-17-22 LENY: Created a separate file with Laura's work 
// from the homepage for the searches
// TO DO: Searches/search results

// 4/04/2022 Laura: Redirecting the user to desired results page
// + connect with database

require_once "../config/.config.php";

session_start();

/* if user enters zipcode redirect them to propertySearch */
if (isset($_POST["search"])) {
  if (isset($_POST["zipcode"]) && !empty($_POST["zipcode"])) {
      $_SESSION["zipcode"] = $_POST["zipcode"];
      header("Location: ../views/propertySearch.html");
  }
  else if (isset($_POST["tenant"]) && !empty($_POST["tenant"])) {
    $_SESSION["tenant"] = $_POST["tenant"];
    header("Location: ../views/userResults.html");
  }
}
while($row = $search->fetch_assoc()) {
  $validation = $db->prepare("SELECT DISTINCT * FROM Property Where Zipcode =?");
if (!$validation) {
  echo "zipcode:" .$row[Zipcode] "<br>";
}
}
?>