<?php
    session_start();
    if (isset($_SESSION['loggedIn'])) {
        if ($_SESSION['loggedIn'] == 0) {
            header("location: login.php");
        } else if ($_SESSION['loggedIn'] == 1) {
            header("location: rev_prof.php");
        } else if ($_SESSION['loggedIn'] == 2) {
            header("location: res_prof.php");
        } else if ($_SESSION['loggedIn'] == 3) {
            header("location: Admin.php");
        }
    }
    //
    if (!isset($_SESSION['success'])) {
        $_SESSION['success'] = "nope";
    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In | Foodopia</title>
</head>

<style>
    .top_header {
        padding: 5px 20px;
        background: black;
    }

    .table_1 {
        color: white;
        font-size: 25px;
        font-family: "Roboto Condensed";
    }

    .buttonStyle {
        width: 90%;
        color: white;
        cursor: pointer;
        font-size: 20px;
        margin-top: 5px;
        margin-bottom: 5px;
        font-weight: bold;
        border: 1px solid;
        text-align: center;
        border-radius: 4px;
        background: black;
        padding: 12px 18px 13px;
        font-family: "Roboto Condensed";
    }

    .forgot-link {
        font-size: 14px;
        text-align: right;
        color: black;
        text-decoration: underline;
    }

    small {
        color: #0073bb;
        font-size: 12px;
        line-height: 1;
    }

    .Tbox {
        display: block;
        height: 40;
        width: 90%;
        font-size: 17px;
        padding: 5px 9px;
        border-width: 1px;
        border-radius: 3px;
        text-align: center;
        border-style: solid;
        margin: 0px 0px 18px;
        box-sizing: border-box;
        border-color: rgb(153, 153, 153);
        font-family: "Roboto Condensed";
    }

    h2 {
        font-size: 30px;
        text-align: center;
        font-weight: bold;
        margin-top: 0;
        line-height: 1;
        color: black;
    }

    h4 {
        margin-top: -10;
        text-align: center;
    }

    .slogo {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    body {
        margin: 0;  
        font-family: "Roboto Condensed";
    }

    fieldset {
        border-radius: 15px;
    }

    a {
        text-decoration: none;
        color: white;
    }

   
</style>

<body align="center">
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
    <br>
    <br>
    <table align="center" height="200" width="100">
        <tr>
            <td>
                <fieldset style="background: white;">
                    <img class="Slogo" src="pics/logo.png" alt="LOGO" width="150" height="150">
                    <h2>Log In</h2>
                    <h4>New to Foodopia?
                        <a href="opt_reg.php" style="color:red">Sign up</a>
                    </h4>
                    <form action="validate.php" method="post">
                        <table cellpadding="1" height="20" width="330">
                            <tr>
                                <td align="center">
                                    <input class="Tbox" type="email" name="email" maxlength="30" placeholder="Email" required/>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <input class="Tbox" type="password" name="password" minlength="8" maxlength="30" placeholder="Password" required/>
                                    <small>
                                        <a class="forgot-link" href="forgot.php">Forgot Password?</a>
                                        <br><br>
                                        <label id="JOLA"></label>
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="5">
                                    <input type="submit" class="buttonStyle" name="LGSubmit" value="Log In" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
            </td>
        </tr>
    </table>
</body>

</html>

<?php
    if (isset($_SESSION['success'])) {
        if ($_SESSION['success'] == "failed") {
            echo '<script>
                document.getElementById("JOLA").innerHTML = "Incorrect Email or Password";
            </script>';
            $_SESSION['success'] = "nope";
        } else if ($_SESSION['success'] == "banned") {
            echo '<script>
                document.getElementById("JOLA").innerHTML = "You have been banned.";
            </script>';
            $_SESSION['success'] = "nope";
        } else if ($_SESSION['success'] == "Pbanned") {
            echo '<script>
                document.getElementById("JOLA").innerHTML = "Restaurant page has been banned.";
            </script>';
            $_SESSION['success'] = "nope";
        }
    } 
?>