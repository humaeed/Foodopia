<?php
    session_start();
    if (isset($_SESSION['loggedIn'])) {
        header("location: login.php");
    } 
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Select | Foodopia</title>
</head>

<style>
    .myButton {
        background-color: #000000;
        border-radius: 42px;
        border: 10px solid #0d0f0d;
        display: inline-block;
        cursor: pointer;
        color: #ffffff;
        font-family: Arial;
        font-size: 40px;
        font-weight: bold;
        padding: 32px 76px;
        text-decoration: none;
        font-family: "Roboto Condensed";
        text-shadow: 0px 15px 0px #000000;
    }

    .myButton:hover {
        background-color: #000000;
    }

    .myButton:active {
        position: relative;
        top: 1px;
    }

    .top_header {
        padding: 5px 20px;
        background: black;
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

    #ops {
        margin-top: 100px;
    }

    h1 {
        font-family: "Roboto Condensed";
        font-size: 45px;
        margin-bottom: 50px;
        margin-left: -40px;
    }

    body {
        margin: 0;
    }
</style>

<body>
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
    <div id="ops" align="center">
        <h1>SELECT</h1>
        <a href="rev_reg.php" class="myButton">REVIEWER</a> &nbsp; &nbsp; &nbsp; &nbsp;
        <a href="res_reg.php" class="myButton">RESTAURANT</a>
    </div>
</body>

</html>