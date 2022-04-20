<?php

session_start();
print_r($_SESSION);

if (!($_SESSION)) 
  header("Location: ../views/login.php");
else{
    if ($_SESSION['Type'] === 'Landlord')
        header("Location: ../views/myProfile.php");
}
?>
<html>
<!-- 4/14/2022 - Leny: Created a page for any previous rentals or current rentals so tenants can give ratings -->
<!-- TO DO: Allow users to give a rating to previous rentals !PASSWORD WILL BE REQUIRED!-->
<!-- TO DO: FIX 147 -->
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
            <a href="../views/rentals.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">My Rentals</a>
            <a href="../views/aboutus.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">About Us</a>
            <a href="../views/contact.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
            <form class=".logoutLblPos" action="../config/accLogin.php" method="post">
                <div class="w3-bar-item w3-button w3-hide-small w3-hover-light-blue w3-right"><button id="logout"type="submit" name="logout">Logout</button></div>
            </form>
        </div>
    </div>
</div>

<!-- For Tenants to view their previous rentals and update ratings -->
<form action="/action_page.php">
    <div class="w3-container" style="margin: 95px; color: whitesmoke;">
        <div class="w3-section">
            <div class="w3-center"><br>
                <h6><i><b>Password required</b> to give ratings.</i></h6>
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
                for ($i=0; $i < $numRentals; $i++) { 
                    echo "<tr id=\"update\">";
                    echo "<td contentEditable=false>".($_SESSION['allRentals'][$i]['PropertyID'])."</td>";
                    echo "<td contentEditable=false>".($_SESSION['allRentals'][$i]['LEmail'])."</td>";
                    echo "<td contentEditable=false>".($_SESSION['allRentals'][$i]['Type'])."</td>";
                    echo "<td contentEditable=false>".($_SESSION['allRentals'][$i]['Start'])."</td>";
                    if(is_null(($_SESSION['allRentals'][$i]['End']))){
                        echo "<td contentEditable=false>Currently Renting!</td>";
                    }else{
                        echo "<td contentEditable=false>".($_SESSION['allRentals'][$i]['End'])."</td>";
                    }
                    echo "<td>".($_SESSION['allRentals'][$i]['Stars'])."</td>";
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

</body>
    <footer id="myFooter">
        <div class="w3-container w3-bottom" style="background-color: #E5F2FF;">
            <h4>Rate 'Em</h4>
            <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        </div>
    </footer>
</html>