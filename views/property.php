<?php

session_start();
print_r($_SESSION);

if (!($_SESSION)) 
  header("Location: ../views/login.php");
else{
    if (!($_SESSION['loggedProfile']))
        header("Location: ../views/login.php");
    elseif($_SESSION['Type'] === 'Tenant')
        header("Location: ../views/myProfile.php");
}
?>
<html>
<!-- 03/17/2022 Keben Carrillo: created the property page for Lanlord -->
<!-- 04/10/2022 Leny: Displaying all properties owned by the landlord and each property information -->
<!-- TO DO: Allow users to edit/delete rows of their property list AND add new properties !PASSWORD WILL BE REQUIRED! -->
<!-- TO DO: Line 171 -->
<title>My Properties</title>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="style.css" rel="stylesheet">


<script>
function logout() {
    args = { "logout": true };
    $.post("../config/accLogin.php", args)
    .done(function(result, status, xhr) {
        if (status == "success") {
            console.log(result);
        } else {
            console.error(result);
        }
    }).fail(function(xhr, status, error) {
        console.error(error);
    });
}
function addTenant() {
    args = { "addTenant": true };
    $.post("../config/landlordSettings.php", args)
    .done(function(result, status, xhr) {
        if (status == "success") {
            console.log(result);
        } else {
            console.error(result);
        }
    }).fail(function(xhr, status, error) {
        console.error(error);
    });
}
</script>
    
    <style>
        table, th, td, tr {
            border: 1px solid black;
            border-collapse: collapse;
            background-color: #FFFFFF;
            color:black;
            text-align: center;
        }
        body {
            font-family: "Roboto", sans-serif;
            margin: auto;
            background-image: linear-gradient(to bottom, black, #3dbaff);
            background-attachment: fixed;
            background-size: 100% 100%;
        }
        * { box-sizing: border-box; }
        /* style inputs andlink buttons */
        input,
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 20px;
            margin: 5px 0;
            opacity: 0.85;
            display: inline-block;
            font-size: 17px;
            line-height: 20px;
            text-decoration: none;
            /* remove underline from anchors*/
        }

        input:hover,
        .btn:hover { opacity: 1;}

        /* style the submit button */
        input[type=submit] {
            background-color: #FFFFFF;
            color: black;
            cursor: pointer;
        }

        input[type=submit]:hover { background-color: #3dbaff; }
        /* Responsive layout - when the screen is less than 650px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 650px) {
            .col {
                width: 100%;
                margin-top: 0;
            }

            /* hide the vertical line */
            .vl { display: none; }
        }
    </style>
</head>

<body>
<!-- Navbar -->
<div class="w3-top">
    <div class="w3-bar w3-theme-d2 w3-left-align w3-large text-color:black">
        <div class="w3-bar w3-top w3-left-align w3-large" style="background-color: #E5F2FF; color: black;">
            <div class="w3-bar-item w3-hide-small"><img src="../images/myicon.png" height="45px"></div>
            <a href="../views/home.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>
            <a href="../views/myProfile.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Profile</a>
            <a href="../views/settings.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Settings</a>
            <a href="../views/property.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Properies</a>
            <a href="../views/aboutus.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">About Us</a>
            <a href="../views/contact.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
            <form class=".logoutLblPos" action="../config/accLogin.php" method="post">
                <div class="w3-bar-item w3-button w3-hide-small w3-hover-light-blue w3-right"><button id="logout"type="submit" name="logout">Logout</button></div>
            </form>
        </div>
    </div>
</div>
        
<!-- For landlords to View/Update/Delete Their Property-->
<form action="/action_page.php">
    <div class="w3-container" style="margin: 95px; color: whitesmoke;">
        <div class="w3-section">
            <div class="w3-center"><br>
                <h6><i><b>Password required</b> to update any information.</i></h6>
                <h6><i>That includes deleting!</i></h6>
                <div style="color: red; font-weight: bold;"><?php if(isset($_SESSION["error"])) { print($_SESSION["error"]); unset($_SESSION["error"]); } ?></div>
                <h4><b>My Properties:</b></h4>
            </div>
            <table style="width:100%">
                <tr>
                    <th>Property ID</th>
                    <th>Type</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Zipcode</th>
                    <th>Number of rooms</th>
                    <th>Number of bathrooms</th>
                    <th>Price</th>
                    <th style="width: 7%;"><button onclick="document.getElementById('id01').style.display='block'"
                            class="w3-round-xlarge" style="background-color: lightgreen;" type="button">Add
                            Property</button></th>
                </tr>
                <?php 
                $properties = $_SESSION['myProperties'];
                $numProperties = count($properties);
                for ($i=0; $i < $numProperties; $i++) { 
                    echo "<tr id=\"update\">";
                    echo "<td contentEditable=false>".($_SESSION['myProperties'][$i]['PropertyID'])."</td>";
                    echo "<td>".($_SESSION['myProperties'][$i]['Type'])."</td>";
                    echo "<td>".($_SESSION['myProperties'][$i]['State'])."</td>";
                    echo "<td>".($_SESSION['myProperties'][$i]['City'])."</td>";
                    echo "<td>".($_SESSION['myProperties'][$i]['Zipcode'])."</td>";
                    echo "<td>".($_SESSION['myProperties'][$i]['NumOfRooms'])."</td>";
                    echo "<td>".($_SESSION['myProperties'][$i]['NumOfBathrooms'])."</td>";
                    echo "<td>".($_SESSION['myProperties'][$i]['Price'])."</td>";
                    // TO FIX: Edit button in another row only allows the first row to be changed
                    echo "<th contentEditable=false style=\"width: 7%;\"><button id=\"change\" onclick=\"updateProperty()\"
                    class=\"w3-round-xlarge\" style=\"background-color: lightblue;\" type=\"button\">Edit</button>
                    <button onclick=\"deleteProperty()\" class=\"w3-round-xlarge\" style=\"background-color: lightcoral;\"
                    type=\"button\">DELETE</button>
                    </th>
                    </tr>";
                }
                ?>
            </table>
        </div>
        <div class="w3-section" style="padding-left: 43%; padding-top: 20px;">
            <input class="w3-input w3-border w3-center" style="width:25%" type="password" placeholder="Enter Current Password"
                name="psw" required></input>
            <button class="w3-button w3-green w3-round-xxlarge" style="width:25%" type="submit">Submit</button>
        </div>
    </div>
</form>
<!-- For landlords to view their renters and add -->
<form action="/action_page.php">
    <div class="w3-container" style="margin: 95px; color: whitesmoke;">
        <div class="w3-section">
            <div class="w3-center"><br>
                <h4><b>My Renters:</b></h4>
            </div>
            <table style="width:100%">
                <tr>
                    <th>Property ID</th>
                    <th>Tenant</th>
                    <th>Start-Date</th>
                    <th>End-Date</th>
                    <th>Their Rating (1-5)</th>
                    <th style="width: 7%;"><button onclick="document.getElementById('id02').style.display='block'"
                            class="w3-round-xlarge" style="background-color: lightgreen;" type="button">Add
                            A Renter</button></th>
                </tr>
                <?php 
                $renters = $_SESSION['myRenters'];
                $numRenters = count($renters);
                for ($i=0; $i < $numRenters; $i++) { 
                    echo "<tr id=\"update\">";
                    echo "<td>".($_SESSION['myRenters'][$i]['PropertyID'])."</td>";
                    echo "<td>".($_SESSION['myRenters'][$i]['TEmail'])."</td>";
                    echo "<td>".($_SESSION['myRenters'][$i]['Start'])."</td>";
                    if(is_null($_SESSION['myRenters'][$i]['End'])){
                        echo "<td>Currently Renting!</td>";
                    }else{ 
                        echo "<td>".($_SESSION['myRenters'][$i]['End'])."</td>";
                    }
                    if(is_null($_SESSION['myRenters'][$i]['Stars'])){
                        echo "<td contentEditable=false>Waiting for rating..!</td>";
                    }else{ 
                        echo "<td contentEditable=false>".($_SESSION['myRenters'][$i]['Stars'])."</td>";
                    }
                    // TO FIX: Edit button in another row only allows the first row to be changed
                    echo "<th contentEditable=false style=\"width: 7%;\"><button id=\"change\" onclick=\"updateProperty()\"
                    class=\"w3-round-xlarge\" style=\"background-color: lightblue;\" type=\"button\">Edit</button>
                    <button onclick=\"deleteProperty()\" class=\"w3-round-xlarge\" style=\"background-color: lightcoral;\"
                    type=\"button\">DELETE</button>
                    </th>
                    </tr>";
                }
                ?>
            </table>
        </div>
    </div>
</form>
<script>
    function updateProperty() {
        var changeBTN = document.getElementById('change');
        if (document.getElementById('update').contentEditable === 'true'){
            document.getElementById('update').contentEditable = false;
            changeBTN.innerText = changeBTN.value;
            changeBTN.innerText = "Edit";
            changeBTN.style.backgroundColor = 'lightblue'; 
        }
        else{
            document.getElementById('update').contentEditable = true;
            changeBTN.innerText = changeBTN.value;
            changeBTN.innerText = "Save";
            changeBTN.style.backgroundColor = 'lightgreen'; 
        }
    }
    function deleteProperty() {
    }
</script>

    <!--Popup form for Landlord to Add a New Property-->  
    <div id="id01" class="w3-modal">
        <div class="w3-round-xxlarge w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
    
            <div class="w3-center"><br>
                <span onclick="document.getElementById('id01').style.display='none'"
                    class="w3-button w3-xlarge w3-transparent w3-round-xxlarge w3-display-topright" title="Close Modal">x</span>
                <label>
                    <h4><b>Add a New Property!</b></h4>
                </label>
            </div>

            <!-- TO DO: Create another file to handle new properties being added -->
            <form class="w3-container" action="../config/landlordSettings.php" method="post">
                <div class="w3-section">
                    <label><h6><b>*State</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter the state the property is in"
                        name="state" required>
                    <label><h6><b>*City</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter the city the property is in"
                        name="city" required>
                    <label><h6><b>*Zipcode</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter the zipcode of the property"
                        name="zip" required>
                    <label><h6><b>*Number of bathrooms</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="number" min="0" placeholder="Enter the number of bathrooms the property has" 
                        name="numOfBathrooms" required>
                    <label><h6><b>*Number of bedrooms</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="number" min="0" placeholder="Enter the number of bedrooms the property has" 
                        name="numOfBedrooms" required>
                    <label><h6><b>*Price</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter the price that the property is listed at" 
                        name="price" required>
                    <label><h6><b>*Property Type</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" list="type" placeholder="Select the property type..." 
                        name="type" required>
                    <datalist id="type">
                        <option value="Apartment"></input>
                        <option value="House"></input>
                        <option value="Mobile Home"></input>
                        <option value="Trailer Home"></input>
                        <option value="Condo"></input>
                        <option value="Studio"></input>
                    </datalist>
                    <label><h6><b>*Current Password</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Enter Current Password" 
                        name="psw" required>
                    <div class="w3-center">
                        <button class="w3-button w3-center w3-green w3-round-xxlarge w3-section w3-padding" style="width:50%" type="submit">Submit</button>
                    </div>
                    <div class="w3-center">
                        <button onclick="document.getElementById('id01').style.display='none'" style="width:50%" type="button" 
                        class="w3-button w3-center w3-red w3-round-xxlarge w3-section w3-padding">Cancel</button>
                    </div>
                </div>
            </form>  
        </div>
    </div>
    <!--Popup form for Landlord to add a new renter-->  
    <div id="id02" class="w3-modal">
        <div class="w3-round-xxlarge w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
    
            <div class="w3-center"><br>
                <span onclick="document.getElementById('id02').style.display='none'"
                    class="w3-button w3-xlarge w3-transparent w3-round-xxlarge w3-display-topright" title="Close Modal">x</span>
                <label>
                    <h4><b>Add a new Renter!</b></h4>
                </label>
            </div>

            <form class="w3-container" action="../config/landlordSettings.php" method="post">
                <div class="w3-section">
                    <label><h6><b>*Property ID - refer to "My Properties" Table </b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="number" min="0" name="propID" 
                        value="<?php print($_SESSION["PropID"]); unset($_SESSION["PropID"]); ?>" required>
                    <label><h6><b>*Tenant</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Enter the tenant's email" name="tEmail" 
                        value="<?php print($_SESSION["TEmail"]); unset($_SESSION["TEmail"]); ?>" required>
                    <label><h6><b>*Start-Date</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="date" placeholder="Enter the start date" name="startDate" 
                        value="<?php print($_SESSION["StartDate"]); unset($_SESSION["StartDate"]); ?>" required>
                    <label><h6><b>End-Date</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="date" placeholder="Enter the end date" name="endDate"
                        value="<?php print($_SESSION["EndDate"]); unset($_SESSION["EndDate"]); ?>">
                    <label class="w3-center"><h6><b><i>The rating will be updated when the tenant gives a rating!</i></b></h6></label>
                    <label><h6><b>*Current Password</b></h6></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Enter Current Password" 
                        name="psw" required>
                    <div class="w3-center">
                        <button class="w3-button w3-center w3-green w3-round-xxlarge w3-section w3-padding" style="width:50%" type="submit" name="addTenant">Submit</button>
                    </div>
                    <div class="w3-center">
                        <button onclick="document.getElementById('id02').style.display='none'" style="width:50%" type="button" 
                        class="w3-button w3-center w3-red w3-round-xxlarge w3-section w3-padding">Cancel</button>
                    </div>
                </div>
            </form>  
        </div>
    </div>
  
  <!--Footer-->
  <footer id="myFooter">
    <div class="w3-container" style="background-color: #E5F2FF; color: black;">
      <!-- w3-theme-l1"> -->
      <h4>Rate 'Em</h4>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>

</body>
</html>
