<?php
    session_start();
    if (isset($_SESSION['loggedIn'])) { 
        if ($_SESSION['loggedIn'] == 0) {
            header("location: login.php");
        } else if ($_SESSION['loggedIn'] == 2) {
            header("location: res_prof.php");
        }
    } else {
        header("location: login.php");
    }

    // default rating
    $_SESSION['REVIEW_OF_RES_ID'] = $_REQUEST['RES_ID'];
    $_SESSION['REVIEW_OF_RES_NAME'] = $_REQUEST['RES_NAME'];
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Write a Review | Foodopia</title>
    <div class="header">
        <input type="text" size="50" maxlength="80" style='margin-left: 28px; margin-top: 6px; font-family: Roboto Condensed; line-height: 30px;' placeholder="Search" onkeyup="getsearch(this.value)" />
        <a href="#default" class="logo">FOODOPIA</a>
        <div class="header-right">
            <a href="#home">HOME</a>
            <a href="rev_prof.php">PROFILE</a>
            <a href="validate.php?q=logout">LOG OUT</a>
        </div>
    </div>
    <br><br>
    <table border="0" style="margin-top: 7px; position: fixed; z-index: 0;"  width="100%" align="center" border="0">
        <tr>   
            <td width="115">
            </td>
            <td colspan="1" align="left">
                <div  id="search-result-container" style="background-color: white; border: 1px solid; margin-left: 100px; display:none; width: 322px;  z-index: 2;">
                </div>
            </td>
        </tr>
    </table>
</head>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: "Roboto Condensed";
    }

    .header {
        overflow: hidden;
        padding: 5px 20px;
        background: black;
        position: fixed;
        width: 100%;
    }

    .header a {
        float: left;
        color: black;
        color: white;
        padding: 12px;
        font-size: 18px;
        line-height: 25px;
        border-radius: 4px;
        text-align: center;
        text-decoration: none;
        font-family: "Roboto Condensed";

    }

    .header a.logo {
        font-size: 45px;
        font-weight: bold;
        font-family: "Operator Mono";
    }

    .header-right {
        float: right;
    }

    @media screen and (max-width: 500px) {
        .header a {
            float: none;
            display: block;
            text-align: left;
        }
        .header-right {
            float: none;
        }
    }

    h2 {
        font-size: 25px;
        margin-bottom: 15px;
        text-align: center;
        font-family: "Roboto Condensed";
    }

    h4 {
        margin-top: 0;
        margin-bottom: 3pt;
        font-size: 20px;
        font-family: "Roboto Condensed";
    }

    #res_name {
        font-size: 20px;
        font-family: "Roboto Condensed";
    }

    .review_box {
        font-size: 15px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .buttonStyle {
        width: 60%;
        color: white;
        cursor: pointer;
        font-size: 20px;
        margin-top: 15px;
        margin-bottom: 15px;
        font-weight: bold;
        border: 1px solid;
        text-align: center;
        border-radius: 4px;
        background: black;
        padding: 12px 18px 13px;
        font-family: "Roboto Condensed";
    }

    .rate {
        width: 100px;
        height: 100px;
        color: white;
        cursor: pointer;
        background: black;
        border-radius: 10px;
        display: inline-block;
    }

    a {
        text-decoration:none;
    }
</style>

<script type="text/javascript">
    function getsearch(str) {
        if (str.length == 0) {
           document.getElementById('search-result-container').style.display = "none";
        } else {
            document.getElementById('search-result-container').style.display = "block";
            var xhttp= new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("search-result-container").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET","validate.php?q=search&val=" + str, true);
            xhttp.send();
        }
    }

    function selectRate(value) {
        if (value == "GOOD") {
            document.getElementById("GOOD").style.background = "red";
            document.getElementById("AVERAGE").style.background = "black";
            document.getElementById("BAD").style.background = "black";
            document.getElementById('rate').value = 'GOOD';
        } else if (value == "AVERAGE") {
            document.getElementById("GOOD").style.background = "black";
            document.getElementById("AVERAGE").style.background = "red";
            document.getElementById("BAD").style.background = "black";
            document.getElementById('rate').value = 'AVERAGE';
        } else {
            document.getElementById("GOOD").style.background = "black";
            document.getElementById("AVERAGE").style.background = "black";
            document.getElementById("BAD").style.background = "red";
            document.getElementById('rate').value = 'BAD';
        }
    }
</script>

<body>
    <br><br>
    <form action='validate.php' method='post'>
        <div align="center">
            <table border="0">
                <tr>
                    <td align="center" colspan="2">
                        <h1 style='font-size: 30px;' id="res_name"><?php echo $_REQUEST['RES_NAME'] ?></h1>
                        <h4 style="text-decoration: underline;">WRITE A REVIEW</h4>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2">
                        <br>
                        <label><b>Give a rating: </b></label>
                        <br>
                        <br>
                        <div id="GOOD" onclick="selectRate(this.id)" class="rate" style='background-color: red;'>
                            <br>
                            <br>
                            <h4>GOOD</h4>
                        </div>
                        &nbsp;
                        <div id="AVERAGE" onclick="selectRate(this.id)" class="rate">
                            <br>
                            <br>
                            <h4>AVERAGE</h4>
                        </div>
                        &nbsp;
                        <div id="BAD" onclick="selectRate(this.id)" class="rate">
                            <br>
                            <br>
                            <h4>BAD</h4>
                        </div>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <textarea class="review_box" type="text" name="input_review" rows="20" cols="100" placeholder="Write your review here." maxlength="2000"
                            required></textarea>
                        <br>
                        <label>
                            <a href="">Read our review guidelines</a>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="500">
                        <br>
                        <h4>Upload Pictures: </h4>
                        <input type="file" name="my_file[]" multiple>
                        <input class="buttonStyle" type="submit" name="PRSubmit" value="Post" />
                    </td>
                    <td align="right">
                        <img class="Slogo" src="pics/logo.png" alt="LOGO" width="150" height="150">
                    </td>
                </tr>
            </table>
            <input id='rate' type='text' name='RATING' value="GOOD" style='visibility: hidden;'>
        </div>
    </form>
</body>

</html>