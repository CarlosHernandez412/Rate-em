<?php

session_start();
print_r($_SESSION);

?>
<!--03/17/2022 -Keben Carrillo: created the property page for Lanlord-->
<!-- TO DO: Should be a page where landlords can edit(update), delete, or add properties
to their profile -->
<!DOCTYPE html>
<html>
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
        args = { "logout": true };
        $.post("../config/accLogin.php", args)
          .done(function (result, status, xhr) {
            if (status == "success") { console.log(result); }
            else { console.error(result); }
          })
          .fail(function (xhr, status, error) {
            console.error(error);
          });
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
            <a href="../views/profile.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Profile</a>
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
<div class="w3-container" style="margin: 95px; color: whitesmoke;">
    <div class="w3-section">
    <div class="w3-center"><br>
        <h4><b>My Properties:</b></h4>
    </div>
    <table style="width:100%">
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
            <td style="width: 7%;"><button onclick="document.getElementById('id01').style.display='block'" 
                class="w3-round-xlarge" style="background-color: lightgreen;">Add Property</button></td>
        </tr>
        <tr id="update">
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>Germany</td>
            <td contentEditable = false style="width: 7%;"><button id="change" onclick="updateProperty()" class="w3-round-xlarge" style="background-color: lightblue;">Edit</button>
                <button onclick="deleteProperty()" class="w3-round-xlarge" style="background-color: lightcoral;">Delete</button>
            </td>
        </tr>
    </table>
    </div>
</div>
<script>
    function updateProperty() {
        var changeBTN = document.getElementById('change');
        if (document.getElementById("update").contentEditable == "true"){
            document.getElementById("update").contentEditable = false;
            changeBTN.innerText = changeBTN.value;
            changeBTN.innerText = "Edit";
            changeBTN.style.backgroundColor = 'lightblue'; 
        }
        else{
            document.getElementById("update").contentEditable = true;
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
    
            <form class="w3-container" action="../config/landlordReg.php" method="post">
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

</body>
    <footer id="myFooter">
        <div class="w3-container w3-bottom" style="background-color: #E5F2FF;">
            <h4>Rate 'Em</h4>
            <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        </div>
    </footer>
</html>
