<?php

session_start();

if (!($_SESSION))
    header("Location: ../views/login.php");
else {
    if (!($_SESSION['loggedProfile']))
        header("Location: ../views/login.php");
    elseif ($_SESSION['Type'] === 'Landlord')
        header("Location: ../views/myProfile.php");
}
?>
<html>
<!-- 4/14/2022 Leny: Created a page for any previous rentals or current rentals so tenants can give ratings -->
<!-- 4/28/2022 Leny: Tenants can now give ratings to previous rented properties -->
<title>My Rentals</title>

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
        function TenantSettings() {
            args = {
                "giveRating": true
            };
            $.post("../config/tenantSettings.php", args)
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
            color: black;
            text-align: center;
        }

        body {
            font-family: "Roboto", sans-serif;
            margin: auto;
            background-image: linear-gradient(to bottom, black, #3dbaff);
            background-attachment: fixed;
            background-size: 100% 100%;
        }

        * {
            box-sizing: border-box;
        }

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
        .btn:hover {
            opacity: 1;
        }

        /* style the submit button */
        input[type=submit] {
            background-color: #FFFFFF;
            color: black;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #3dbaff;
        }

        /* Responsive layout - when the screen is less than 650px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 650px) {
            .col {
                width: 100%;
                margin-top: 0;
            }

            /* hide the vertical line */
            .vl {
                display: none;
            }
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
                <a href="../views/rentals.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Rentals</a>
                <a href="../views/aboutus.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">About Us</a>
                <a href="../views/contact.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
                <form class=".logoutLblPos" action="../config/accLogin.php" method="post">
                    <div class="w3-bar-item w3-button w3-hide-small w3-hover-light-blue w3-right"><button id="logout" type="submit" name="logout">Logout</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- For Tenants to view their previous rentals and update ratings -->
    <form action="../config/tenantSettings.php" method="post">
        <div class="w3-container" style="margin: 95px; color: whitesmoke;">
            <div class="w3-section">
                <div class="w3-center"><br>
                    <h6><i><b>Password required</b> to give ratings.</i></h6>
                    <?php 
                        if (isset($_SESSION["error"])) { 
                            echo "<div class=\"warning\"><i class=\"fa fa-warning\"></i> ".$_SESSION["error"]." </div>";
                            unset($_SESSION["error"]); 
                        }
                        if (isset($_SESSION["success"])) { 
                            echo "<div class=\"success\"><i class=\"fa fa-check\"></i> ".$_SESSION["success"]." </div>";
                            unset($_SESSION["success"]); 
                        }
                    ?>
                    <h4><b>My Rentals:</b></h4>
                </div>
                <table style="width:100%">
                    <tr>
                        <th>Property ID</th>
                        <th>Property Owner</th>
                        <th>Type</th>
                        <th>Start-Date</th>
                        <th>End-Date</th>
                        <th>Rating (1-5)</th>
                    </tr>
                    <?php
                    $Rentals = $_SESSION['allRentals'];
                    $numRentals = count($Rentals);
                    for ($i = 0; $i < $numRentals; $i++) {
                        echo "<tr id= $i>";
                        echo "<td><input class=\"w3-input w3-border w3-center w3-margin-bottom\" type=\"number\" min=\"0\" name=\"propertyID\" 
                            readonly value =" . ($_SESSION['allRentals'][$i]['PropertyID']) . "></td>";
                        echo "<td><input class=\"w3-input w3-border w3-center w3-margin-bottom\"
                            readonly value =" . ($_SESSION['allRentals'][$i]['LEmail']) . "></td>";
                        echo "<td><input class=\"w3-input w3-border w3-center w3-margin-bottom\" 
                            readonly value =" . ($_SESSION['allRentals'][$i]['Type']) . "></td>";
                        echo "<td><input class=\"w3-input w3-border w3-center w3-margin-bottom\"
                            readonly value =" . ($_SESSION['allRentals'][$i]['Start']) . "></td>";
                        if (is_null(($_SESSION['allRentals'][$i]['End']))) {
                            echo "<td><input class=\"w3-input w3-border w3-center w3-margin-bottom\" 
                            readonly value =\"Currently Renting!\"></td>";
                        } else {
                            echo "<td><input class=\"w3-input w3-border w3-center w3-margin-bottom\" 
                            readonly value =" . ($_SESSION['allRentals'][$i]['End']) . "></td>";
                        }
                        echo "<td id= $i><input class=\"w3-input w3-border w3-center w3-margin-bottom\" 
                            type=\"number\" min=\"1\" max=\"5\" name=\"rating\" disabled=\"true\" value =" . ($_SESSION['allRentals'][$i]['Stars']) . "></td>";
                        echo "<th contentEditable=false style=\"width: 7%;\"><button id=\"change\" onclick=\"updateRow(event, $i )\"
                        class=\"w3-round-xlarge\" style=\"background-color: lightblue;\" type=\"button\">Edit</button></th></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="w3-section" style="padding-left: 43%; padding-top: 20px;">
                <input class="w3-input w3-border w3-center" style="width:25%" type="password" placeholder="Enter Current Password" name="psw" required></input>
            </div>
        </div>
    </form>
    <script>
        function updateRow(event, row) {
            console.log(event);
            console.log(row);

            // Get selected row
            r = event.srcElement.offsetParent.offsetParent.children[0].children.length;
            for (i = 1; i < r; i++) {
                checkRow = event.srcElement.offsetParent.offsetParent.children[0].children[i].id;
                if (row == checkRow)
                    selectedRowNum = row;
            }

            selectedRow = event.srcElement.offsetParent.offsetParent.children[0].children[selectedRowNum+1];
            var startDate = event.path[2].children[3].children[0].defaultValue;
            var endDate = event.path[2].children[4].children[0].defaultValue;

            // Go through columns to give an updated rating
            cellUpdate = selectedRow.cells[5];
            cellID = parseInt(cellUpdate.id)
            updatingRow = cellUpdate.childNodes[0];
            if (selectedRowNum === cellID) {
                if (updatingRow.disabled == true && event.srcElement.innerHTML === 'Edit') {
                    event.srcElement.innerHTML = 'Save';
                    event.srcElement.style.backgroundColor = 'lightgreen';
                    updatingRow.disabled = false;
                } else {
                    event.srcElement.type = 'submit';
                    event.srcElement.name = 'giveRating';
                    event.path[2].children[3].children[0].name = 'startDate';
                    event.path[2].children[3].children[0].value = startDate;
                    event.path[2].children[4].children[0].name = 'endDate';
                    event.path[2].children[4].children[0].value = endDate;
                }
            }
        }
    </script>

</body>
<footer id="myFooter">
    <div class="w3-container w3-bottom" style="background-color: #E5F2FF;">
        <h4>Rate 'Em</h4>
        <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
</footer>

</html>