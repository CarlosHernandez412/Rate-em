<?php

session_start();
print_r($_SESSION);

?>
<html>
<!--03/17/2022 -Keben Carrillo: created Register Page-->
<!--03/19/2022 -Keben Carrillo: I was able to fix the whole page background to fill 
                                when in full screen-->
<!--03/19/2022 - Leny: Created the forms for tenant and landlord -->
<!-- 04/07/2022 LENY: Nav bar is complete -->
<!--4/10/22 Keben: Worked on displaying error message when registering with existing email-->
<title>Account Selection</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="style.css" rel="stylesheet">
    
    <script>
    function register(){
        args = { "landlordReg": true, "tenantReg": true };
        $.post("../config/landlordReg.php", args)
            .done(function (result, status, xhr) {
                if (status == "success") { console.log(result); }
                else { console.error(result); }
            })
            .fail(function (xhr, status, error) {
                console.error(error);
            });
        $.post("../config/tenantReg.php", args)
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
        body {
            font-family: "Roboto", sans-serif;
            margin: auto;
        }
        * { box-sizing: border-box; }

        /* style inputs and link buttons */
        input,
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            margin: 5px 0;
            opacity: 0.85;
            display: inline-block;
            font-size: 17px;
            line-height: 20px;
            text-decoration: none;
            /* remove underline from anchors */
        }

        input:hover,
        .btn:hover { opacity: 1; }

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
        <div class="w3-bar w3-top w3-left-align w3-large" style="background-color: #E5F2FF;">
            <div class="w3-bar-item w3-hide-small"><img src="../images/myicon.png" height="45px"></div>
            <a href="../views/home.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>
            <a href="../views/register.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Register</a>
            <a href="../views/login.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Login</a>
            <a href="../views/aboutus.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">About Us</a>
            <a href="../views/contact.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div style="color: red; font-weight: bold;"><?php if(isset($_SESSION["reg_error"])) { print($_SESSION["reg_error"]); unset($_SESSION["reg_error"]); } ?></div>
            <h2 style="text-align:center">Welcome to Rate 'Em</h2>
            <h3 style="text-align:center">Register as...</h3>
            <div class="vl">
                <span class="vl-innertext">or</span>
            </div>
    
            <div class="col">
                <p>Landlord</p>
                <img src="../images/landlord.png" alt="landlord_renting" class="img"><br><br>
                <input onclick="document.getElementById('id01').style.display='block'" type="submit" value="Register">
            </div>
    
            <div class="col">
                <p>Tenant</p>
                <img src="../images/house.png" alt="landlord_renting" class="img"><br><br>
                <input onclick="document.getElementById('id02').style.display='block'" type="submit" value="Register">
            </div>
    
        </div>
    </div>
    
    <footer id="myFooter">
        <div class="w3-container w3-bottom" style="background-color: #E5F2FF;">
            <h4>Rate 'Em</h4>
            <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        </div>
    </footer>
    
    <!-- Pop up register forms -->
    <!-- Landlord -->
    <div id="id01" class="w3-modal">
        <div class="w3-round-xxlarge w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
    
            <div class="w3-center"><br>
                <span onclick="document.getElementById('id01').style.display='none'"
                    class="w3-button w3-xlarge w3-transparent w3-round-xxlarge w3-display-topright" title="Close Modal">x</span>
                <label>
                    <h4><b>Welcome!</b></h4>
                </label>
                <div style="color: red; font-weight: bold;"><?php if(isset($_SESSION["lreg_error"])) { print($_SESSION["lreg_error"]); unset($_SESSION["lreg_error"]); } ?></div>
            </div>
    
            <form class="w3-container" action="../config/landlordReg.php" method="post">
                <div class="w3-section">
                    <h5><b>Account Info:</b></h5>
                    <label><b>*First Name</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter First Name"
                        value="<?php print($_SESSION["Lfirst"]); unset($_SESSION["Lfirst"]); ?>" name="fname" required>
                    <label><b>Middle Name</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Middle Name"
                        value="<?php print($_SESSION["Lmid"]); unset($_SESSION["Lmid"]); ?>" name="mname">
                    <label><b>*Last Name</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Last Name"
                        value="<?php print($_SESSION["Llast"]); unset($_SESSION["Llast"]); ?>" name="lname" required>
                    <label><b>*Phone Number</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Phone Number"
                        value="<?php print($_SESSION["Lnum"]); unset($_SESSION["Lnum"]); ?>" name="phonenum" required>
                    <label><b>*Email</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Enter Email" 
                        value="<?php print($_SESSION["LeAddress"]); unset($_SESSION["LeAddress"]); ?>" name="email" required>
                    <label><b>*Password</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Enter Password" 
                        value="<?php print($_SESSION["Lpass"]); unset($_SESSION["Lpass"]); ?>" name="psw" required>
                    
                    <br><h5><b>Property Info:</b></h5>
                    <label><b>*State</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter the state the property is in"
                        value="<?php print($_SESSION["St"]); unset($_SESSION["St"]); ?>" name="state" required>
                    <label><b>*City</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter the city the property is in"
                        value="<?php print($_SESSION["Cty"]); unset($_SESSION["Cty"]); ?>" name="city" required>
                    <label><b>*Zipcode</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter the zipcode of the property"
                        value="<?php print($_SESSION["Zpcode"]); unset($_SESSION["Zpcode"]); ?>" name="zip" required>
                    <label><b>*Number of bathrooms</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="number" min="0" placeholder="Enter the number of bathrooms the property has"
                        value="<?php print($_SESSION["Bathrms"]); unset($_SESSION["Bathrms"]); ?>" name="numOfBathrooms" required>
                    <label><b>*Number of bedrooms</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="number" min="0" placeholder="Enter the number of bedrooms the property has" 
                        value="<?php print($_SESSION["Rms"]); unset($_SESSION["Rms"]); ?>" name="numOfBedrooms" required>
                    <label><b>*Price</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter the price that the property is listed at" 
                        value="<?php print($_SESSION["Cost"]); unset($_SESSION["Cost"]); ?>" name="price" required>
                    <label><b>*Property Type</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" list="type" placeholder="Select the property type..."
                        valuen="<?php print($_SESSION["PType"]); unset($_SESSION["PType"]); ?>" name="type" required>
                    <datalist id="type">
                        <option value="Apartment"></input>
                        <option value="House"></input>
                        <option value="Mobile Home"></input>
                        <option value="Trailer Home"></input>
                        <option value="Condo"></input>
                        <option value="Studio"></input>
                    </datalist>
                    <button class="w3-button w3-round-xxlarge w3-block w3-green w3-section w3-padding" type="submit" name="landlordReg">Submit</button>
                </div>
            </form>
    
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('id01').style.display='none'" type="button"
                    class="w3-button w3-red">Cancel</button>
                <span class="w3-right w3-padding w3-hide-small">Already registered? <a
                        href="../views/login.php">Login</a></span>
            </div>
    
        </div>
    </div>
    <!-- Tenant -->
    <div id="id02" class="w3-modal">
        <div class="w3-round-xxlarge w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
    
            <div class="w3-center"><br>
                <span onclick="document.getElementById('id02').style.display='none'"
                    class="w3-button w3-xlarge w3-round-xxlarge w3-transparent w3-display-topright" title="Close Modal">x</span>
                <label>
                    <h4><b>Welcome!</b></h4>
                </label>
                <div style="color: red; font-weight: bold;"><?php if(isset($_SESSION["treg_error"])) { print($_SESSION["treg_error"]); unset($_SESSION["treg_error"]); } ?></div>
            </div>
    
            <form class="w3-container" action="../config/tenantReg.php" method="post">
                <div class="w3-section">
                    <h5><b>Account Info:</b></h5>
                    <label><b>*First Name</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter First Name"
                        value="<?php print($_SESSION["Tfirst"]); unset($_SESSION["Tfirst"]); ?>" name="fname" required>
                    <label><b>Middle Name</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Middle Name"
                        value="<?php print($_SESSION["Tmid"]); unset($_SESSION["Tmid"]); ?>" name="mname">
                    <label><b>*Last Name</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Last Name"
                        value="<?php print($_SESSION["Tlast"]); unset($_SESSION["Tlast"]); ?>" name="lname" required>
                    <label><b>*Phone Number</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Phone Number"
                        value="<?php print($_SESSION["Tnum"]); unset($_SESSION["Tnum"]); ?>" name="phonenum" required>
                    <label><b>*Email</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Enter Email" 
                        value="<?php print($_SESSION["TeAddress"]); unset($_SESSION["TeAddress"]); ?>" name="email" required>
                    <label><b>*Password</b></label>
                    <input class="w3-input w3-border" type="password" placeholder="Enter Password" 
                        value="<?php print($_SESSION["Tpass"]); unset($_SESSION["Tpass"]); ?>" name="psw" required>
                    <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit" name="tenantReg">Submit</button>
                </div>
            </form>
    
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('id02').style.display='none'" type="button"
                    class="w3-button w3-red">Cancel</button>
                <span class="w3-right w3-padding w3-hide-small">Already registered? <a
                        href="../views/login.php">Login</a></span>
            </div>
        </div>
    </div>
</body>
</html>