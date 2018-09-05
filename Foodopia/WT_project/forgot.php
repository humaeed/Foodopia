<?php
    session_start();
    if (isset($_SESSION['loggedIn'])) { 
        header("location: login.php");
    } 
    //
    if (!isset($_SESSION['f_success'])) {
        $_SESSION['f_success'] = "nope";
    } 
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset | Foodopia</title>
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
                    <h2>Password Reset</h2>
                    <form action="validate.php" method="post">
                        <table cellpadding="1" height="20" width="330">
                            <tr>
                                <td align="center">
                                    <div id="HAHA">
                                        <?php 
                                            if (isset($_REQUEST['q'])) {
                                                if ($_REQUEST['q'] == "GO" and $_SESSION['f_success'] == "GO") {
                                                    echo "The verification mail has been sent. <br> Please check your inbox.";
                                                    $_SESSION['f_success'] = "nope";
                                                } else if ($_REQUEST['q'] == "success") {
                                                    echo "You have succesfully changed your password. <br> Now <a style='color: blue;' href='login.php'>log in</a> to your account.";
                                                } else {
                                                    header("location: forgot.php");
                                                }
                                            } else {
                                                echo "Enter the registered email where the verification <br>link & code will be sent. <br><br><input class='Tbox' type='email' name='email' maxlength='30' placeholder='Email' required/> <small><label id='JOLA'></label></small> <input type='submit' class='buttonStyle' name='SDVerf' value='Send'/>";
                                            }
                                        ?>
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

<?php
    if (isset($_SESSION['f_success'])) {
        if ($_SESSION['f_success'] == "failed") {
            echo '<script>
                document.getElementById("JOLA").innerHTML = "Incorrect Email";
            </script>';
            $_SESSION['f_success'] = "nope";
        } else if ($_SESSION['f_success'] == "shit") {
            echo '<script>
                document.getElementById("HAHA").innerHTML = "We are facing some server issues. Please try again later. Sorry for the inconvenience";
            </script>';
            $_SESSION['f_success'] = "nope";
        }
    }
?>