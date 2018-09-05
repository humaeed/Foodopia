<?php
    session_start();
    if (isset($_SESSION['loggedIn'])) {
        header("location: login.php");
    }
    if (!isset($_SESSION['RSproblem'])) {
        $_SESSION['RSproblem'] = "nope";
    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up | Foodopia</title>
    <div class="top_header">
        <table class="table_1" border="0" width="100%" align="center">
            <tr>
                <td style="font-family: 'Operator Mono'; font-size: 45px;" align="center">
                    <a href="home.php">
                        <b>FOODOPIA</b>
                    </a>
                </td>
            </tr>
        </table>
    </div>
</head>

<style>
    .top_header {
        padding: 5px 20px;
        background: black;
        position: fixed;
        width: 100%;
    }

    .table_1 {
        color: white;
        font-size: 25px;
        font-family: "Roboto Condensed";
    }

    a {
        text-decoration: none;
        color: white;
    }

    p {
        padding-bottom: 5px;
    }

    body {
        margin: 0;
        font-family: "Roboto Condensed";
    }

    .form {
        border: 2px solid black;
        -webkit-border-radius: 10px;
        width: 470px;
        margin: 0 auto;
        padding-left: 50px;
        padding-top: 20px;
    }

    .form fieldset {
        border: 0px;
        padding: 0px;
        margin: 0px;
    }

    .form p.contact {
        font-size: 12px;
        margin: 0px 0px 10px 0;
        line-height: 14px;
        font-family: "Roboto Condensed";
    }

    .form input[type="text"] {
        width: 412px;
    }

    .form input[type="email"] {
        width: 412px;
    }

    .form input[type="password"] {
        width: 412px;
    }

    .form input.birthday {
        width: 70px;
    }

    .form input.birthmonth {
        width: 90px;
    }

    .form input.birthyear {
        width: 133px;
    }

    .form label {
        color: #000;
        font-size: 16px;
        font-family: "Roboto Condensed";
    }

    .form label.month {
        width: 135px;
    }

    .form input,
    textarea {
        border-style: solid;
        border-width: 1px;
        border-radius: 3px;
        height: 38;
        font-size: 17px;
        border-color: rgb(153, 153, 153);
        padding: 7px;
        font-family: "Roboto Condensed";
        font-size: 14px;
        -webkit-border-radius: 5px;
        margin-bottom: 15px;
        margin-top: -10px;
    }

    select {
        border-style: solid;
        border-width: 1px;
        border-radius: 3px;
        height: 38;
        width: 150;
        font-size: 50px;
        border-color: rgb(153, 153, 153);
        padding: 7px;
        font-family: "Roboto Condensed";
        font-size: 14px;
        -webkit-border-radius: 5px;
        margin-bottom: 15px;
        margin-top: -10px;
    }

    .form input.buttom {
        width: 89%;
        height: 8.5%;
        color: white;
        cursor: pointer;
        font-size: 20px;
        margin-top: 5px;
        margin-bottom: 15px;
        font-weight: bold;
        border: 1px solid;
        text-align: center;
        border-radius: 4px;
        background: black;
        padding: 12px 18px 13px;
        font-family: "Roboto Condensed";
    }

    .slogo {
        display: block;
        margin-left: 140px;
        margin-right: 50px;
        margin-bottom: -30px;
        margin-top: -10px;
    }

    h1 {
        margin-left: 30px;
        margin-bottom: 10px;
    }

    input[type="radio"], input.radio {
        vertical-align:text-top;
        width: 13px;
        height: 13px;
        padding: 0;
        margin: 0;
        margin-top: 5px;
        position: relative;
        overflow: hidden;
        top: 2px;
    }
</style>

<script>
    function checkAC() {
        var CITY = document.getElementById("city");
        var AREA = document.getElementById("area");
        //
        if (document.getElementById("city").value == "nocity") {
            CITY.setCustomValidity("Select a city");
        } else {
            CITY.setCustomValidity('');
        }
        //
        if (document.getElementById("area").value == "noarea") {
            AREA.setCustomValidity("Select an area");
        } else {
            AREA.setCustomValidity('');
        }
    }

    function validatePassword() {   
        var password = document.getElementById("password")
        var confirm_password = document.getElementById("rpassword");
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    function addItem() {
        var dhaka  = ["Banani", "Gulshan", "Dhanmondi", "Mohakhali", "Mirpur"];
        var ctg    = ["Boalkhali", "Fatikchhari", "Hathazari", "Lohagara", "Mirsharai"];
        var raj    = ["Durgapur", "Godagari", "Putia", "Kazla", "Tanor"];
        var khulna = ["BIT Khulna", "Doulatpur", "Khulna sadar", "Siramani"];
        var sylhet = ["Kadamtali", "Mogla", "Jalalabad", "Lalbazar"];
        var name   = document.getElementById("city").value;

        if (name == "Dhaka") {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
            for (var i = 0; i < dhaka.length; i++) {
                var item   = document.createElement("option");
                item.value = item.text = dhaka[i];
                document.getElementById("area").appendChild(item);
            }

        } else if (name == "Rajshahi") {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
            for (var i = 0; i < dhaka.length; i++) {
                var item = document.createElement("option");
                item.value = item.text = raj[i];
                document.getElementById("area").appendChild(item);
            }
        } else if (name == "Chittagong") {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
            for (var i = 0; i < dhaka.length; i++) {
                var item = document.createElement("option");
                item.value = item.text = ctg[i];
                document.getElementById("area").appendChild(item);
            }
        } else if (name == "Khulna") {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
            for (var i = 0; i < dhaka.length; i++) {
                var item = document.createElement("option");
                item.value = item.text = khulna[i];
                document.getElementById("area").appendChild(item);
            }
        } else if (name == "Sylhet") {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
            for (var i = 0; i < dhaka.length; i++) {
                var item = document.createElement("option");
                item.value = item.text = sylhet[i];
                document.getElementById("area").appendChild(item);
            }
        } else {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
        }
    }
</script>

<body>
    <br><br><br><br><br><br><br>
    <div id="stuff" class="form">
    <img class="slogo" src="pics/logo.png" alt="LOGO" width="150" height="150">
    <h1>Your Restaurant in Foodopia</h1>
    <br>
        <form action="validate.php" method="post" enctype="multipart/form-data" id="contactform">
            <p class="contact">
                <label for="name">Restaurant Name</label>
            </p>
            <input id="Rname" name="Rname" placeholder="eg: Kentucky Fried Chicken" required="" type="text">
            <p class="contact">
                <label for="name">Location</label>
            </p>
            <select name="city" id="city" onchange="addItem(); checkAC();" required="">
                <option value="nocity">Select City:</option>
                <option value="Dhaka">Dhaka</option>
                <option value="Chittagong">Chittagong </option>
                <option value="Rajshahi">Rajshahi </option>
                <option value="Khulna">Khulna</option>
                <option value="Sylhet">Sylhet</option>
            </select>
            &nbsp;
            <select name="area" id="area" onchange="checkAC()" required="">
                <option value="noarea">Select Area:</option>
            </select>
            <p class="contact">
                <label for="email">Email</label>
            </p>
            <input id="email" name="email" placeholder="example@domain.com" required="" type="email">
            <p class="contact">
                <label for="password">Create a password</label>
            </p>
            <input type="password" onchange="validatePassword()" id="password" placeholder="●●●●●●●●" name="password" minlength="8" required="" size="25" type="text">
            <p class="contact">
                <label for="repassword">Confirm your password</label>
            </p>
            <input type="password" onkeyup="validatePassword()" id="rpassword" placeholder="●●●●●●●●" name="rpassword" required="" size="25" type="text">
            <p class="contact">
                <label for="name">Page Manager</label>
            </p>
            <input id="name" name="m_name" placeholder="Full Name" required="" type="text">
            <input class="buttom" name="RSSignUp" id="submit" tabindex="5" value="Sign Up" type="submit">
        </form>
    </div>
    <br><br>
</body>

</html>

<script type="text/javascript">
    checkAC();
</script>

<?php 
    if ($_SESSION['RSproblem'] != "nope") {
        // Printing a session variable into a javascript alert.
        echo '<script>
            alert("'.$_SESSION['RSproblem'].'");
        </script>';
        $_SESSION['RSproblem'] = "nope";
    }
?>