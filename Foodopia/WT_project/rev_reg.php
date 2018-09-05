<?php
    session_start();
    if (isset($_SESSION['loggedIn'])) {
        header("location: login.php");
    }
    if (!isset($_SESSION['RVproblem'])) {
        $_SESSION['RVproblem'] = "nope";
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
        width: 205px;
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

    .form .select-style {
        -webkit-appearance: button;
        -webkit-border-radius: 2px;
        -webkit-box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
        -webkit-padding-end: 20px;
        -webkit-padding-start: 2px;
        -webkit-user-select: none;
        background-image: url(images/select-arrow.png),
        -webkit-linear-gradient(#FAFAFA, #F4F4F4 40%, #E5E5E5);
        background-position: center right;
        background-repeat: no-repeat;
        border: 0px solid #FFF;
        color: #555;
        font-size: inherit;
        margin: 0;
        overflow: hidden;
        padding-top: 5px;
        padding-bottom: 5px;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-family: "Roboto Condensed";
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
        margin-left: 130px;
        margin-right: 50px;
        margin-bottom: -30px;
        margin-top: -10px;
    }

    h1 {
        margin-left: 50px;
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
    function validatePassword() {   
        var password = document.getElementById("password")
        var confirm_password = document.getElementById("rpassword");
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } 
        else {
            confirm_password.setCustomValidity('');
        }
    }
</script>

<body>
    <br><br><br><br><br><br><br>
    <div class="form">
    <img class="Slogo" src="pics/logo.png" alt="LOGO" width="150" height="150">
    <h1>Become a Food Reviewer</h1>
    <br>
        <form action="validate.php" method="post" enctype="multipart/form-data" id="contactform">
            <p class="contact">
                <label for="name">Name</label>
            </p>
            <input id="Fname" name="Fname" placeholder="First" required="" type="text">
            <input id="Lname" name="Lname" placeholder="Last" required="" type="text">
            <p class="contact">
                <label for="email">Email</label>
            </p>
            <input id="email" name="email" placeholder="example@domain.com" required="" type="email">
            <p class="contact">
                <label for="username">Create a username</label>
            </p>
            <input id="username" name="username" placeholder="Username" required="" type="text">
            <p class="contact">
                <label for="password">Create a password</label>
            </p>
            <input type="password" onchange="validatePassword()" id="password" placeholder="●●●●●●●●" name="password" minlength="8" required="" size="25" type="text">
            <p class="contact">
                <label for="repassword">Confirm your password</label>
            </p>
            <input type="password" onkeyup="validatePassword()" id="rpassword" placeholder="●●●●●●●●" name="rpassword" required="" size="25" type="text">
            <fieldset>
                <p class="contact">
                    <label for="password">Birthday</label>
                </p>
                <label>
                    <input class="birthday" type="number" min="1" max="31" name="BirthDay" placeholder="Day" required="">
                </label>
                <label>
                    <input class="birthmonth" type="number" min="1" max="12" name="BirthMonth" placeholder="Month" required="">
                </label>
                <label>
                    <input class="birthyear" type="number" min="1950" max="2017" name="BirthYear" placeholder="Year" required="">
                </label>
            </fieldset>
            <input class="buttom" name="RVSignUp" id="submit" tabindex="5" value="Sign Up" type="submit">
        </form>
    </div>
    <br><br>
</body>

</html>

<?php 
    if ($_SESSION['RVproblem'] != "nope") {
        // Printing a session variable into a javascript alert.
        echo '<script>
            alert("'.$_SESSION['RVproblem'].'");
        </script>';
        $_SESSION['RVproblem'] = "nope";
    }
?>