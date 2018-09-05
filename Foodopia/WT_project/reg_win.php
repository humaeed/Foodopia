<?php
    session_start();
    if (isset($_SESSION['loggedIn'])) {
        header("location: login.php");
    } else if (isset($_SESSION['REGWin'])) {
        if ($_SESSION['REGWin'] == "true") {
            $_SESSION['REGWin'] = "false";
        } else {
            header("location: login.php");
        }
    } else {
        header("location: login.php");
    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Successfully Registered | Foodopia</title>
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
        margin-top: 10px;
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

    #a2 {
        text-decoration: underline;
        color: red;
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
    <br><br><br>
    <table align="center" height="200" width="100">
        <tr>
            <td>
                <fieldset style="background: white;">
                    <img class="Slogo" src="pics/logo.png" alt="LOGO" width="150" height="150">
                    <h2>Congratulations!</h2>
                    <form action="validate.php" method="post">
                        <table cellpadding="1" height="20" width="330">
                            <tr>
                                <td align="center">
                                    <div id="HAHA">
                                        <label>
                                            <?php
                                                if (isset($_REQUEST['q'])) {
                                                    if ($_REQUEST['q'] == "rev") {
                                                        echo "You are a Foodopian now.<br>Now <a id='a2' href='login.php'>log in</a> and share your reviews.";
                                                    } else {
                                                        echo "Welcome to Foodopia.<br>Now <a id='a2' href='login.php'>log in</a> and get on board.";
                                                    }
                                                } else {
                                                    echo "Welcome to Foodopia.<br>Now <a id='a2' href='login.php'>log in</a> and get on board.";
                                                }
                                            ?>
                                        </label>
                                    </div>
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