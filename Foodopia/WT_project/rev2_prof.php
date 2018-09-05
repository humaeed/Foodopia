<?php
    session_start();
    if (!isset($_REQUEST['UN'])) {
        echo "<h1>DIE DIE DIE!</h1>";
        exit();
    }
    else if (isset($_SESSION['username']) and $_REQUEST['UN'] == $_SESSION['username']) {
        header("Location: rev_prof.php");
    } else {
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        $qry = "select * from reviewer where rev_username= '".$_REQUEST['UN']."';";
        $res = mysqli_query($con, $qry);
        $col = "";
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
            $_REQUEST['name']      = $row["name"];
            $_REQUEST['username']  = $row["rev_username"];
            $_REQUEST['email']     = $row["email"];
            $_REQUEST['password']  = $row["password"];
            $_REQUEST['follower']  = $row["follower"];
            $_REQUEST['following'] = $row["following"];
            $_REQUEST['points']    = $row["points"];
            $_REQUEST['pic']       = $row["picture"];
            $_REQUEST['dob']       = $row['dob'];
            // Checking for FOLLOW or FOLLOWING button value
            $_REQUEST['ForFColor'] = "black";
            if (isset($_SESSION['loggedIn'])) {
                if ($_SESSION['loggedIn'] != 2) {
                     if (isset($_SESSION['loggedIn'])) {
                        $f_c = explode("@", $_SESSION['following']);
                        if (in_array($_REQUEST['UN'], $f_c)) {
                            $_REQUEST['ForF'] = "Unfollow";
                            $_REQUEST['ForFColor'] = "grey";
                        }
                        else $_REQUEST['ForF'] = "Follow";
                    } else {
                        $_REQUEST['ForF'] = "Follow";
                    }
                }
            }
            // GET REVIEW COUNT
            $qry = "SELECT COUNT(*) FROM reviews WHERE rev_username = '".$row['rev_username']."' and approval = 'Y'";
            $res = mysqli_query($con, $qry);
            $hah = mysqli_fetch_array($res, MYSQLI_ASSOC);
            $_REQUEST['review_count'] = $hah['COUNT(*)'];
        } else {
            echo "<h1>DIE DIE DIE</h1>";
            exit();
        }
    }
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo $_REQUEST['name']." | Foodopia"?>
    </title>
    <div class="header">
        <a href="#default" class="logo">FOODOPIA</a>
        <input type="text" size="50" maxlength="80" style='margin-left: 28px; margin-top: 6px; font-family: Roboto Condensed; line-height: 30px;' placeholder="Search" onkeyup="getsearch(this.value)" />
        <div class="header-right">
            <?php
                if (isset($_SESSION['loggedIn'])) {
                    if ($_SESSION['loggedIn'] == 1) {
                        echo '<a href="#home">HOME</a>
                              <a href="rev_prof.php">PROFILE</a>
                              <a href="validate.php?q=logout">LOG OUT</a>';
                    } else if ($_SESSION['loggedIn'] == 2) {
                        echo '<a href="#home">HOME</a>
                              <a href="res_prof.php">PAGE</a>
                              <a href="validate.php?q=logout">LOG OUT</a>';
                    } else {
                        echo '<a href="login.php">SIGN IN</a>
                              <a href="opt_reg.php">SIGN UP</a>';
                    } 
                } else {
                    echo '<a href="login.php">SIGN IN</a>
                          <a href="opt_reg.php">SIGN UP</a>';
                }
            ?>
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

    td {
        padding-left: 50px;
    }

    .form {
        -webkit-border-radius: 10px;
        margin: 0 auto;
    }

    .form input[type="text"] {
        width: 158px;
    }

    .form input[type="email"] {
        width: 320px;
    }

    .form input[type="password"] {
        width: 320px;
    }

    .form input.birthday {
        width: 85px;
    }

    .form input.birthmonth {
        width: 100px;
    }

    .form input.birthyear {
        width: 128px;
    }

    .form label {
        color: #000;
        font-size: 16px;
        font-family: "Roboto Condensed";
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
        width: 50%;
        height: 8.5%;
        color: white;
        cursor: pointer;
        font-size: 20px;
        margin-top: 5px;
        margin-left: 120px;
        margin-bottom: 15px;
        font-weight: bold;
        border: 1px solid;
        border-radius: 4px;
        background: black;
        padding: 12px 18px 13px;
        font-family: "Roboto Condensed";
    }

    #IMG { 
        margin-bottom: 10;
        margin-top: 10;  
    }

    p {
        text-align: justify;
        margin-left: 90;
    }

    .PPic {
        margin-left: 200;
        margin-top: 50;
    }

    .PInfo {
        margin-left: 450;
        margin-top: -170;
    }

    .POpts {
        margin-left: 220;
        margin-top: 100;
        text-align: center;
        height: 150;
        width: 150;
    }
        
    #search {
        margin-left: 450;
        top: -150px;
        position: relative;
    }

    #BOARD {
        margin-left: 450;
        margin-top: -170;
        height: 100%;
        width: 50%;
    }

    .buttonStyle {
        width: 15%%;
        height: 8%;
        color: white;
        cursor: pointer;
        font-size: 20px;
        margin-top: -10px;
        margin-bottom: 20px;
        font-weight: bold;
        border: 1px solid;
        text-align: center;
        border-radius: 4px;
        padding: 12px 18px 13px;
        font-family: "Roboto Condensed";
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

    function ForFClick(value, UN) {
        var xhttp = new XMLHttpRequest();
        if (document.getElementById("ForF").name == 0) {
            alert("You must log in first!");
        } else if (value == "Unfollow") {
            xhttp.open("GET", "validate.php?q=ForF&w=Unfollow&UN=" + UN, true);
            document.getElementById("ForF").style.background = "black";
            document.getElementById("ForF").value = "Follow";
            xhttp.send();
            
        } else {
            xhttp.open("GET", "validate.php?q=ForF&w=Follow&UN=" + UN, true);
            document.getElementById("ForF").style.background = "grey";
            document.getElementById("ForF").value = "Unfollow";
            xhttp.send();
        }
        location.reload();
    }
</script>

<body>
    <br><br>
    <div class="PPic">
        <img src="<?php echo $_REQUEST['pic']; ?>" height="200" width="200">
    </div>
    <div class="PInfo">
        <h1>
            <?php echo $_REQUEST['name'];?> &nbsp; &nbsp;
            <input id="ForF" onclick="ForFClick(this.value, `<?php echo $_REQUEST['UN'];?>`)" type="submit" class="buttonStyle" style="background-color: <?php echo $_REQUEST['ForFColor'];?>"; name="<?php if (isset($_SESSION['loggedIn'])) echo "1"; else echo "0"; ?>" value="<?php echo $_REQUEST['ForF']?>" />
        </h1>
        <?php 
            if (isset($_SESSION['loggedIn']) and $_SESSION['loggedIn'] == 2) {
                echo "<script> document.getElementById('ForF').style.visibility = 'hidden'; </script>";
            }
        ?>
        <h4 style="margin-top: -50;">Dhaka, Bangladesh</h4>
        <h2 style="margin-top: -10;">
        <?php 
            $f_c = explode("@", $_REQUEST['following']); 
            if ($_REQUEST['following'] == "") echo "0";
            else echo count($f_c);
        ?>
        <a href="rev2_prof.php?UN=<?php echo $_REQUEST['username']; ?>&q=following" style="text-decoration: none; color: black;">Following</a> &nbsp; &nbsp;
        <?php 
            $f_c = explode("@", $_REQUEST['follower']); 
            if ($_REQUEST['follower'] == "") echo "0";
            else echo count($f_c); 
        ?> 
        <a href="rev2_prof.php?UN=<?php echo $_REQUEST['username']; ?>&q=followers" style="text-decoration: none; color: black;">Followers</a> &nbsp; &nbsp;
        <?php 
            echo $_REQUEST['review_count']; 
        ?> 
        <a href="rev2_prof.php?UN=<?php echo $_REQUEST['username']; ?>&q=reviews" style="text-decoration: none; color: black;">Reviews</a>
        </h2>
    </div>
    <div class="POpts">
        <hr>
        <h3><a style="color: black;" href="rev2_prof.php?UN=<?php echo $_REQUEST['username']; ?>&q=reviews">Reviews</a></h3>
        <hr>
        <h3><a style="color: black;" href="rev2_prof.php?UN=<?php echo $_REQUEST['username']; ?>&q=profile">Profile</a></h3>
        <hr>
    </div>
    <div id="search" class='form'>
        
    </div>
    <div id="BOARD">
        <?php
            if (isset($_REQUEST['q'])) {
                if ($_REQUEST['q'] == "profile") {
                    echo "<br><table style='margin-top: -5; margin-left: -50;' border='0' cellpadding='1' height='20' width='500'> <tr> <td> <strong style='font-size: 23px;'>NAME</strong> </td> <td style='font-size: 20px;'>: &nbsp; ".$_REQUEST['name']." </td> </tr> <tr> <td colspan='5'> <br> </td> </tr> <tr> <td> <strong style='font-size: 23px;'>USERNAME</strong> </td> <td style='font-size: 20px;'>: &nbsp; @".$_REQUEST['username']." </td> </tr> <tr> <td colspan='5'> <br> </td> </tr> <tr> <td> <strong style='font-size: 23px;'>EMAIL</strong> </td> <td style='font-size: 20px;'>: &nbsp; ".$_REQUEST['email']." </td> </tr> <tr> <td colspan='5'> <br> </td> </tr> <tr> <td> <strong style='font-size: 23px;'>DATE OF BIRTH</strong> </td> <td style='font-size: 20px;'>: &nbsp; ".$_REQUEST['dob']." </td> </tr> </table>";
                } else if ($_REQUEST['q'] == "following" or $_REQUEST['q'] == "followers") {
                    $p_c = array();
                    $f_c; //= array();
                    if ($_REQUEST['q'] == "followers") {
                       if ($_REQUEST['follower'] == "") {
                            echo "<h2 style='margin-top: 12;'>You don't have any followers yet!</h2>";
                            exit();
                        } else {
                            $f_c = explode("@", $_REQUEST['follower']);
                        }
                    } else {
                        if ($_REQUEST['following'] == "") {
                            echo "<h2 style='margin-top: 12;'>Start following reviewers!</h2>";
                            exit();
                        } else {
                            $f_c = explode("@", $_REQUEST['following']);
                        }
                    }
                    $con = mysqli_connect("localhost", "root", "", "restaurant_system");
                    // Taking pics of each user 
                    for ($i = 0; $i < count($f_c); $i++) {
                        $qry = "select * from reviewer where rev_username= '".$f_c[$i]."';";
                        $res = mysqli_query($con, $qry);
                        $hah = mysqli_fetch_array($res, MYSQLI_ASSOC);
                        array_push($p_c, $hah);
                    }
                    // Print List
                    echo "<br>";
                    for ($i = 0; $i < count($f_c); $i++) {
                        echo "<table border='0' style='margin-left: -50;'><tr><td><img src='".$p_c[$i]['picture']."' height='100' width='100'></td><td><h3 style='margin-top: -52; margin-bottom: 5;'><a style='color: blue; text-decoration: none;' href='rev2_prof.php?UN=".$p_c[$i]['rev_username']."'>".$p_c[$i]['name']."</a></h3> <small>@".$p_c[$i]['rev_username']."<small></td></tr><tr><td><br></td></tr></table>";
                    }
                } else {
                    echo "<div class='form' style='margin-top: 20;'><input type='text' style='width: 320;' onkeyup='getData(this.value)' placeholder='Search by Restaurant' /></div>";
                    echo "<br><div id=BOARD2>";
                    $con = mysqli_connect("localhost", "root", "", "restaurant_system");
                    $qry = "select * from reviews where rev_username= '".$_REQUEST['UN']."' and approval = 'Y';";
                    $res = mysqli_query($con, $qry);
                    $col = "";
                    if (mysqli_num_rows($res) > 0) {
                        for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                            if ($i != 0) echo "<hr>";
                            $row[$i] = mysqli_fetch_array($res);
                            // Setting color for rating
                            if ($row[$i]['rating'] == "GOOD") $col = "green";
                            else if ($row[$i]['rating'] == "AVERAGE") $col = "orange";
                            else $col = "red";
                            // Print review
                            echo "<h3><a href=res_prof2.php?RES_ID=".$row[$i]['res_id'].">".$row[$i]['restaurant']."</a>&nbsp; &nbsp;<small style='font-size: 13px;'>".$row[$i]['date']."</small></h3>"."<h4 style='margin-top: -15;'>Review: <small style='font-size: 20px; color: ".$col."'>".$row[$i]['rating']."</small></h4>"."<p style='margin-left: 0; margin-top: -10; margin-bottom: 40;'>".$row[$i]['review']."</p>"; 
                        }
                    } else {
                        echo "<h1>NO REVIEWS POSTED YET!</h1>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<div class='form' style='margin-top: 20;'><input type='text' style='width: 320;' onkeyup='getData(this.value)' placeholder='Search by Restaurant' /></div>";
                    echo "<br><div id=BOARD2>";
                $con = mysqli_connect("localhost", "root", "", "restaurant_system");
                $qry = "select * from reviews where rev_username= '".$_REQUEST['UN']."' and approval = 'Y';";
                $res = mysqli_query($con, $qry);
                $col = "";
                if (mysqli_num_rows($res) > 0) {
                    for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                        if ($i != 0) echo "<hr>";
                        $row[$i] = mysqli_fetch_array($res);
                        // Setting color for rating
                        if ($row[$i]['rating'] == "GOOD") $col = "green";
                        else if ($row[$i]['rating'] == "AVERAGE") $col = "orange";
                        else $col = "red";
                        // Print review
                        echo "<h3><a href=res_prof2.php?RES_ID=".$row[$i]['res_id'].">".$row[$i]['restaurant']."</a>&nbsp; &nbsp;<small style='font-size: 13px;'>".$row[$i]['date']."</small></h3>"."<h4 style='margin-top: -15;'>Review: <small style='font-size: 20px; color: ".$col."'>".$row[$i]['rating']."</small></h4>"."<p style='margin-left: 0; margin-top: -10; margin-bottom: 40;'>".$row[$i]['review']."</p>"; 
                    }
                } else {
                    echo "<h1>NO REVIEWS POSTED YET!</h1>";
                }
                echo "</div>";
            }
        ?>
    </div>
</body>

</html>