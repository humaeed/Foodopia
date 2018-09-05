<?php
    session_start();
    if (isset($_SESSION['loggedIn'])) { 
        if ($_SESSION['loggedIn'] != 1) {
            header("location: login.php");
        } 
    } else {
        header("location: login.php");
    }

    if (!isset($_SESSION['RVproblem'])) {
        $_SESSION['RVproblem'] = "nope";
    }
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo $_SESSION['name']." | Foodopia"?>
    </title>
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

    .EDEL {
        align-content: right;
        text-align: right;
        margin-top: -20px;
    }

    /* POP UP MODAL CSS */

    .myBtn {
        background:none!important;
        color:inherit;
        border:none; 
        padding:0!important;
        font: inherit;
        cursor: pointer;
    }

    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.2); /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        border: 2px solid;
        margin: auto;
        padding: 20px;
        width: 15%;
        height: 15%;
        text-align: center;
        border-radius: 5px;
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

    function preview(event) { // Picture preview before upload
        var reader = new FileReader();
        var imageField = document.getElementById("IMG");
        reader.onload = function() {
            if (reader.readyState == 2) {
                imageField.src = reader.result;
            }
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function getData(res_name) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("BOARD2").innerHTML = this.responseText;
            }
        };
        if (res_name.length) {
            xhttp.open("GET", "validate.php?q=load_reviews&n=" + res_name, true);
        } else {
            xhttp.open("GET", "validate.php?q=load_reviews&n=null", true);
        }
        xhttp.send();
    }
</script>

<body>
    <br><br>
    <div class="PPic">
        <img src="<?php echo $_SESSION['pic']; ?>" height="200" width="200">
    </div>
    <div class="PInfo">
        <h1>
            <?php echo $_SESSION['name']; ?>
        </h1>
        <h4 style="margin-top: -20;">Dhaka, Bangladesh</h4>
        <h2 style="margin-top: -10;">
        <?php 
            $f_c = explode("@", $_SESSION['following']); 
            if ($_SESSION['following'] == "") echo "0";
            else echo count($f_c);
        ?>
        <a href="rev_prof.php?q=following" style="text-decoration: none; color: black;">Following</a> &nbsp; &nbsp;
        <?php 
            $f_c = explode("@", $_SESSION['follower']); 
            if ($_SESSION['follower'] == "") echo "0";
            else echo count($f_c); 
        ?> 
        <a href="rev_prof.php?q=followers" style="text-decoration: none; color: black">Followers</a> &nbsp; &nbsp;
        <?php 
            echo $_SESSION['review_count']; 
        ?> 
        <a href="rev_prof.php?q=reviews" style="text-decoration: none; color: black">Reviews</a>
        </h2>
    </div>
    <div class="POpts">
        <hr/>
        <h3><a style="color: black;" href="rev_prof.php?q=reviews">Reviews</a></h3>
        <hr>
        <h3><a style="color: black;" href="rev_prof.php?q=profile">Profile</a></h3>
        <hr/>
        <h3><a style="color: black;" href="rev_prof.php?q=edit_profile">Edit Profile</a></h3>
        <hr/>
    </div>
    <div id="search" class='form'>
        
    </div>
    <div id="BOARD">
        <?php
            if (isset($_REQUEST['q'])) {
                if ($_REQUEST['q'] == "profile" or $_REQUEST['q'] == "update_done") {
                    echo "<br><table style='margin-top: -5; margin-left: -50;' border='0' cellpadding='1' height='20' width='500'> <tr> <td> <strong style='font-size: 23px;'>NAME</strong> </td> <td style='font-size: 20px;'>: &nbsp; ".$_SESSION['name']." </td> </tr> <tr> <td colspan='5'> <br> </td> </tr> <tr> <td> <strong style='font-size: 23px;'>USERNAME</strong> </td> <td style='font-size: 20px;'>: &nbsp; @".$_SESSION['username']." </td> </tr> <tr> <td colspan='5'> <br> </td> </tr> <tr> <td> <strong style='font-size: 23px;'>EMAIL</strong> </td> <td style='font-size: 20px;'>: &nbsp; ".$_SESSION['email']." </td> </tr> <tr> <td colspan='5'> <br> </td> </tr> <tr> <td> <strong style='font-size: 23px;'>DATE OF BIRTH</strong> </td> <td style='font-size: 20px;'>: &nbsp; ".$_SESSION['dob']." </td> </tr> </table>";
                } else if ($_REQUEST['q'] == "edit_profile") {
                    $name = explode(" ", $_SESSION['name']);
                    $bd   = explode("/", $_SESSION['dob']); 
                    echo "<div class='form'><p style='font-size: 20px; margin-left: 120; font-weight: bold;'>📋 Fill only those you want to update 📋</p><form action='validate.php' method='post' enctype='multipart/form-data' id='contactform'> <table border='0' style='margin-left: -30;'> <tr> <td align='center' colspan='2'> <strong>Profile Picture</strong> <br><img id='IMG' src='upload/def.png' alt='PIC' height='120' width='120'> <br><input type='file' id='IMG_FILE' name='file' onchange='preview(event)'> <br><br><br></td></tr><tr> <td><strong>Name</strong></td><td> <input id='Fname' name='Fname' placeholder='".$name[0]."' type='text'> <input id='Lname' name='Lname' placeholder='".$name[1]."' type='text'> </td></tr><tr> <td colspan='2'><br></td></tr><tr> <td><strong>Email</strong></td><td> <input id='email' name='email' placeholder='".$_SESSION['email']."' type='email'><br></td></tr><tr> <td colspan='2'><br></td></tr><tr> <td><strong>Change Password<strong> &nbsp; &nbsp;</td><td> <input type='password' onchange='validatePassword()' id='password' placeholder='●●●●●●●●' name='password' minlength='8' size='25' type='text'> </td></tr><tr> <td colspan='2'><br></td></tr><tr> <td><strong>Confirm Password</strong> &nbsp;</td><td> <input type='password' onkeyup='validatePassword()' id='rpassword' placeholder='●●●●●●●●' name='rpassword' size='25' type='text'> </td></tr><tr> <td colspan='2'><br></td></tr><tr> <td><strong>Birthday</strong></td><td> <input class='birthday' type='number' min='1' max='31' name='BirthDay' placeholder='".$bd[0]."'> <input class='birthmonth' type='number' min='1' max='12' name='BirthMonth' placeholder='".$bd[1]."' > <input class='birthyear' type='number' min='1950' max='2017' name='BirthYear' placeholder='".$bd[2]."'> </td></tr><tr> <td colspan='2'><br></td></tr><tr> <td colspan='2'> <input class='buttom' name='RVEdit' id='submit' tabindex='5' value='SAVE' type='submit'> </td></tr></table> </form></div>";
                } else if ($_REQUEST['q'] == "following" or $_REQUEST['q'] == "followers") {
                    $p_c = array();
                    $f_c; //= array();
                    if ($_REQUEST['q'] == "followers") {
                       if ($_SESSION['follower'] == "") {
                            echo "<h2 style='margin-top: 12;'>You don't have any followers yet!</h2>";
                            exit();
                        } else {
                            $f_c = explode("@", $_SESSION['follower']);
                        }
                    }
                    else {
                        if ($_SESSION['following'] == "") {
                            echo "<h2 style='margin-top: 12;'>Start following reviewers!</h2>";
                            exit();
                        } else {
                            $f_c = explode("@", $_SESSION['following']);
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
                        echo "<table border='0' style='margin-left: -50;'><tr><td><img src='".$p_c[$i]['picture']."' height='100' width='100'></td><td><h3 style='margin-top: -52; margin-bottom: 5;'><a style='color: blue; text-decoration: none' href='rev2_prof.php?UN=".$p_c[$i]['rev_username']."'>".$p_c[$i]['name']."</a></h3> <small>@".$p_c[$i]['rev_username']."<small></td></tr><tr><td><br></td></tr></table>";
                    }
                } else {
                    echo "<div class='form' style='margin-top: 20;'><input type='text' style='width: 320;' onkeyup='getData(this.value)' placeholder='Search by Restaurant' /></div>";
                    echo "<br><div id=BOARD2>";
                    $con = mysqli_connect("localhost", "root", "", "restaurant_system");
                    $qry = "select * from reviews where rev_username= '".$_SESSION['username']."' and approval = 'Y';";
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
                            echo "<h3><a href=res_prof2.php?RES_ID=".$row[$i]['res_id'].">".$row[$i]['restaurant']."</a>&nbsp; &nbsp;<small style='font-size: 13px;'>".$row[$i]['date']."</small></h3>"."<h4 style='margin-top: -15;'>Review: <small style='font-size: 20px; color: ".$col."'>".$row[$i]['rating']."</small></h4>"."<p style='margin-left: 0; margin-top: -10; margin-bottom: 35;'>".$row[$i]['review']."</p><div class='EDEL'><strong><small><button class='myBtn' id='".$row[$i]['review_id']."' onclick='delClick(this.id)'>DELETE</button></small></strong></div><br>";
                        }
                        echo "<br><br>";
                        echo "<div id='myModal' class='modal'>
                                  <div class='modal-content'>
                                    <p style='margin-top: 2px; margin-left: 50px;'>CONFIRM<br>&nbsp;<b><small><button class='myBtn' onclick='yeS()'>YES</button> &nbsp; &nbsp; <button class='myBtn' onclick='noO()'>NO</button></small></b></p>
                                  </div>
                                </div>
                                <script>
                                    var modal = document.getElementById('myModal');
                                    var x_id;
                                    function delClick(val) {
                                        modal.style.display = 'block';
                                        x_id = val;
                                    }
                                    function noO() {
                                        modal.style.display = 'none';
                                    }
                                    function yeS() {
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.open('GET', 'validate.php?q=DELREV&id=' + x_id, true);
                                        xhttp.send();
                                        noO();
                                        location.reload();
                                    }   
                                </script>";
                    } else {
                        echo "<h1>NO REVIEWS POSTED YET!</h1>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<div class='form' style='margin-top: 20;'><input type='text' style='width: 320;' onkeyup='getData(this.value)' placeholder='Search by Restaurant' /></div>";
                    echo "<br><div id=BOARD2>";
                $con = mysqli_connect("localhost", "root", "", "restaurant_system");
                $qry = "select * from reviews where rev_username= '".$_SESSION['username']."' and approval = 'Y';";
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
                            echo "<h3><a href=res_prof2.php?RES_ID=".$row[$i]['res_id'].">".$row[$i]['restaurant']."</a>&nbsp; &nbsp;<small style='font-size: 13px;'>".$row[$i]['date']."</small></h3>"."<h4 style='margin-top: -15;'>Review: <small style='font-size: 20px; color: ".$col."'>".$row[$i]['rating']."</small></h4>"."<p style='margin-left: 0; margin-top: -10; margin-bottom: 35;'>".$row[$i]['review']."</p><div class='EDEL'><strong><small><button class='myBtn' id='".$row[$i]['review_id']."' onclick='delClick(this.id)'>DELETE</button></small></strong></div><br>";
                        }
                        echo "<br><br>";
                        echo "<div id='myModal' class='modal'> <div class='modal-content'> <p style='margin-top: 2px; margin-left: 50px;'>CONFIRM<br>&nbsp;<b><small><button class='myBtn' onclick='yeS()'>YES</button> &nbsp; &nbsp; <button class='myBtn' onclick='noO()'>NO</button></small></b></p></div></div><script>var modal=document.getElementById('myModal'); var x_id; function delClick(val){modal.style.display='block'; x_id=val;}function noO(){modal.style.display='none';}function yeS(){var xhttp=new XMLHttpRequest(); xhttp.open('GET', 'validate.php?q=DELREV&id=' + x_id, true); xhttp.send(); noO(); location.reload();}</script>";
                } else {
                    echo "<h1>NO REVIEWS POSTED YET!</h1>";
                }
                echo "</div>";
            }
        ?>
    </div>
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