<?php
// 3-17-22 LENY: Created a separate file with Laura's work 
// from the homepage for the searches
// TO DO: Searches/search results

require_once "../config/.config.php";

/* if user enters zipcode redirect them to propertySearch */
if (isset($_SESSION["search"])) {
  if (isset($_SESSION["zipcode"])) {
      header("Location: ../views/propertySearch.html");
  }
  else if (isset($_SESSION["tenant"])) {
      header("Location: ../views/tenant.html");
  }
}

?>